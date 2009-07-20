<?php

global $wpdb;

$posts_per_page = $options["admin_rows"];

$url = $_SERVER['REQUEST_URI'];
$url_pos = strpos($url, "&gdsr=");
if (!($url_pos === false))
    $url = substr($url, 0, $url_pos);

$url.= "&gdsr=murpost";

$set_id = $_GET["sid"];

$select = "";
$page_id = 1;
$filter_date = "";
$filter_cats = "";
if (isset($_GET["select"])) $select = $_GET["select"];
if (isset($_GET["pg"])) $page_id = $_GET["pg"];
if (isset($_GET["date"])) $filter_date = $_GET["date"];
if (isset($_GET["cat"])) $filter_cats = $_GET["cat"];
if (isset($_GET["s"])) $search = $_GET["s"];

if ($_POST["gdsr_filter"] == __("Filter", "gd-star-rating")) {
    $filter_date = $_POST["gdsr_dates"];
    $filter_cats = $_POST["gdsr_categories"];
}

if ($_POST["gdsr_search"] == __("Search Posts", "gd-star-rating")) {
    $search = apply_filters('get_search_query', stripslashes($_POST["s"]));
}

$url.= "&sid=".$set_id;
if ($filter_cats != '' || $filter_cats != '0') $url.= "&cat=".$filter_cats;
if ($filter_date != '' || $filter_date != '0') $url.= "&date=".$filter_date;
if ($search != '') $url.= "&s=".$search;
if ($select != '') $url.= "&select=".$select;

$sql_count = GDSRDBMulti::get_stats_count($set_id, $filter_date, $filter_cats, $search);
$np = $wpdb->get_results($sql_count);
$number_posts_page = 0;
$number_posts_post = 0;
if (count($np) > 0) {
    foreach ($np as $n) {
        if ($n->post_type == "page") $number_posts_page = $n->count;
        else $number_posts_post = $n->count;
    }
}
$number_posts_all = $number_posts_post + $number_posts_page;
if ($select == "post") $number_posts = $number_posts_post;
else if ($select == "page") $number_posts = $number_posts_page;
else $number_posts = $number_posts_all;

$max_page = floor($number_posts / $posts_per_page);
if ($max_page * $posts_per_page != $number_posts) $max_page++;

if ($max_page > 1)
    $pager = GDSRHelper::draw_pager($max_page, $page_id, $url, "pg");

$set = gd_get_multi_set($set_id);

?>

<script>
function checkAll(form) {
    for (i = 0, n = form.elements.length; i < n; i++) {
        if(form.elements[i].type == "checkbox" && !(form.elements[i].getAttribute('onclick', 2))) {
            if(form.elements[i].checked == true)
                form.elements[i].checked = false;
            else
                form.elements[i].checked = true;
        }
    }
}
</script>

<div class="wrap" style="max-width: <?php echo $options["admin_width"]; ?>px">
<form id="gdsr-articles" method="post" action="">
<h2 class="gdptlogopage">GD Star Rating: <?php _e("Multi Set Results", "gd-star-rating"); ?>: <?php _e("Articles", "gd-star-rating"); ?></h2>
<ul class="subsubsub">
    <li><a<?php echo $select == "" ? ' class="current"' : ''; ?> href="<?php echo $url; ?>">All Articles (<?php echo $number_posts_all; ?>)</a> |</li>
    <li><a<?php echo $select == "post" ? ' class="current"' : ''; ?> href="<?php echo $url; ?>&select=post">Posts (<?php echo $number_posts_post; ?>)</a> |</li>
    <li><a<?php echo $select == "page" ? ' class="current"' : ''; ?> href="<?php echo $url; ?>&select=page">Pages (<?php echo $number_posts_page; ?>)</a></li>
</ul>
<?php
    if ($select != '') $url.= "&select=".$select;
?>
<p id="post-search">
    <label class="hidden" for="post-search-input"><?php _e("Search Posts", "gd-star-rating"); ?>:</label>
    <input class="search-input" id="post-search-input" type="text" value="<?php echo $search; ?>" name="s"/>
    <input class="button" type="submit" value="<?php _e("Search Posts", "gd-star-rating"); ?>" name="gdsr_search" />
</p>
<div class="tablenav">
    <div class="alignleft">
<?php GDSRDatabase::get_combo_months($filter_date); ?>
<?php GDSRDatabase::get_combo_categories($filter_cats); ?>
        <input class="button-secondary delete" type="submit" name="gdsr_filter" value="<?php _e("Filter", "gd-star-rating"); ?>" />
    </div>
    <div class="tablenav-pages">
        <?php echo $pager; ?>
    </div>
</div>
<br class="clear"/>
<?php

    $sql = GDSRDBMulti::get_stats($set_id, $select, ($page_id - 1) * $posts_per_page, $posts_per_page, $filter_date, $filter_cats, $search);
    $rows = $wpdb->get_results($sql, OBJECT);
    
?>

<table class="widefat">
    <thead>
        <tr>
            <th class="check-column" scope="col"><input type="checkbox" onclick="checkAll(document.getElementById('gdsr-articles'));"/></th>
            <th scope="col"><?php _e("Title", "gd-star-rating"); ?></th>
            <th scope="col"><?php _e("View", "gd-star-rating"); ?></th>
            <th scope="col"><?php _e("Categories", "gd-star-rating"); ?></th>
            <th scope="col"><?php _e("Ratings", "gd-star-rating"); ?></th>
            <th scope="col"><?php _e("Total", "gd-star-rating"); ?></th>
            <?php if ($options["review_active"] == 1) { ?>
                <!--<th scope="col"><?php _e("Review", "gd-star-rating"); ?></th>-->
            <?php } ?>
        </tr>
    </thead>
    <tbody>
<?php
       
    $tr_class = "";
    foreach ($rows as $row) {
        $ratings = GDSRDBMulti::calculate_set_rating($set, $row->id);

        echo '<tr id="post-'.$row->pid.'" class="'.$tr_class.' author-self status-publish" valign="top">';
        echo '<th scope="row" class="check-column"><input name="gdsr_item[]" value="'.$row->pid.'" type="checkbox"></th>';
        echo '<td><strong>'.sprintf('<a href="./post.php?action=edit&post=%s">%s</a>', $row->pid, $row->post_title).'</strong></td>';
        echo '<td nowrap="nowrap">';
            echo '<a href="'.get_permalink($row->pid).'" target="_blank"><img src="'.STARRATING_URL.'gfx/view.png" border="0" /></a>&nbsp;';
        echo '</td>';
        echo '<td>'.GDSRDatabase::get_categories($row->pid).'</td>';
        echo '<td>';
            if ($ratings["visitors"]["votes"] == 0) echo sprintf("[ 0 ] %s: /<br />", __("visitors", "gd-star-rating"));
            else echo sprintf('[ <a href="./admin.php?page=gd-star-rating-multi-sets&gdsr=murset&sid=%s&pid=%s&filter=visitor"><strong style="color: red;">%s</strong></a> ] %s: <strong style="color: red;">%s</strong><br />', $set_id, $row->pid, $ratings["visitors"]["votes"], __("visitors", "gd-star-rating"), $ratings["visitors"]["rating"]);
            if ($ratings["users"]["votes"] == 0) echo sprintf("[ 0 ] %s: /<br />", __("users", "gd-star-rating"));
            else echo sprintf('[ <a href="./admin.php?page=gd-star-rating-multi-sets&gdsr=murset&sid=%s&pid=%s&filter=user"><strong style="color: red;">%s</strong></a> ] %s: <strong style="color: red;">%s</strong>', $set_id, $row->pid, $ratings["users"]["votes"], __("users", "gd-star-rating"), $ratings["users"]["rating"]);
        echo '</td>';
        echo '<td>';
            if ($ratings["total"]["votes"] == 0) echo sprintf("[ 0 ] %s: /", __("rating", "gd-star-rating"));
            else echo sprintf('[ <a href="./admin.php?page=gd-star-rating-multi-sets&gdsr=murset&sid=%s&pid=%s"><strong style="color: red;">%s</strong></a> ] %s: <strong style="color: red;">%s</strong><br />', $set_id, $row->pid, $ratings["total"]["votes"], __("rating", "gd-star-rating"), $ratings["total"]["rating"]);
        echo '</td>';
        if ($options["review_active"] == 1)
            echo '<!--<td align="right">/</td>-->';
        echo '</tr>';

        if ($tr_class == "")
            $tr_class = "alternate ";
        else
            $tr_class = "";
    }

?>

</tbody>
</table>

</form>
</div>
