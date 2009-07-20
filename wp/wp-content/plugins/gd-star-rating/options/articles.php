<?php

global $wpdb;

$posts_per_page = $options["admin_rows"];

$url = $_SERVER['REQUEST_URI'];
$url_pos = strpos($url, "&gdsr=");
if (!($url_pos === false))
    $url = substr($url, 0, $url_pos);

$url.= "&gdsr=articles";

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

if ($_POST["gdsr_update"] == __("Update", "gd-star-rating")) {
    $gdsr_items = $_POST["gdsr_item"];
    if (count($gdsr_items) > 0) {
        $ids = "(".join(", ", $gdsr_items).")";
        if ($_POST["gdsr_delete_articles"] != '') 
            GDSRDatabase::delete_votes($ids, $_POST["gdsr_delete_articles"], $gdsr_items);
        if ($_POST["gdsr_delete_comments"] != '') 
            GDSRDatabase::delete_votes($ids, $_POST["gdsr_delete_comments"], $gdsr_items);
        if ($_POST["gdsr_review_rating"] != "") {
            $review = $_POST["gdsr_review_rating"];
            if ($_POST["gdsr_review_rating_decimal"] != "" && $_POST["gdsr_review_rating"] < $options["review_stars"])
                $review.= ".".$_POST["gdsr_review_rating_decimal"];
            GDSRDatabase::update_reviews($ids, $review, $gdsr_items);
        }
        GDSRDatabase::update_settings($ids, $_POST["gdsr_article_moderation"], $_POST["gdsr_article_voterules"], $_POST["gdsr_comments_moderation"], $_POST["gdsr_comments_voterules"], $gdsr_items);
        if ($_POST["gdsr_timer_type"] != "") {
            GDSRDatabase::update_restrictions($ids, $_POST["gdsr_timer_type"], GDSRHelper::timer_value($_POST["gdsr_timer_type"], $_POST['gdsr_timer_date_value'], $_POST['gdsr_timer_countdown_value'], $_POST['gdsr_timer_countdown_type']));
        }
    }
}

if ($filter_cats != '' || $filter_cats != '0') $url.= "&cat=".$filter_cats;
if ($filter_date != '' || $filter_date != '0') $url.= "&date=".$filter_date;
if ($search != '') $url.= "&s=".$search;
if ($select != '') $url.= "&select=".$select;

$sql_count = GDSRDatabase::get_stats_count($filter_date, $filter_cats, $search);
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
function gdsrTimerChange() {
    var timer = jQuery("#gdsr_timer_type").val();
    jQuery("#gdsr_timer_date").css("display", "none");
    jQuery("#gdsr_timer_countdown").css("display", "none");
    jQuery("#gdsr_timer_date_text").css("display", "none");
    jQuery("#gdsr_timer_countdown_text").css("display", "none");
    if (timer == "D") {
        jQuery("#gdsr_timer_date").css("display", "block");
        jQuery("#gdsr_timer_date_text").css("display", "block");
    }
    if (timer == "T") {
        jQuery("#gdsr_timer_countdown").css("display", "block");
        jQuery("#gdsr_timer_countdown_text").css("display", "block");
    }
}
</script>

<?php if ($wpv < 27) { ?><div class="wrap" style="max-width: <?php echo $options["admin_width"]; ?>px">
<?php } else { ?><div class="wrap"><?php } ?>
<form id="gdsr-articles" method="post" action="">
<h2 class="gdptlogopage">GD Star Rating: <?php _e("Articles", "gd-star-rating"); ?></h2>
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

    $sql = GDSRDatabase::get_stats($select, ($page_id - 1) * $posts_per_page, $posts_per_page, $filter_date, $filter_cats, $search);
    $rows = $wpdb->get_results($sql, OBJECT);
    
?>
<table class="widefat">
    <thead>
        <tr>
            <th class="check-column" scope="col"><input type="checkbox" onclick="checkAll(document.getElementById('gdsr-articles'));"/></th>
            <th scope="col"><?php _e("Title", "gd-star-rating"); ?></th>
            <th scope="col"><?php _e("View", "gd-star-rating"); ?></th>
            <th scope="col" class="num"><div class="vers"><img src="images/comment-grey-bubble.png" alt="Comments"/></div></th>
            <?php if ($options["moderation_active"] == 1) { ?>
                <th scope="col"><?php _e("Moderation", "gd-star-rating"); ?></th>
            <?php } ?>
            <?php if ($options["timer_active"] == 1) { ?>
                <th scope="col"><?php _e("Time", "gd-star-rating"); ?></th>
            <?php } ?>
            <th scope="col"><?php _e("Vote Rules", "gd-star-rating"); ?></th>
            <th scope="col"><?php _e("Categories", "gd-star-rating"); ?></th>
            <th scope="col"><?php _e("Ratings", "gd-star-rating"); ?></th>
            <th scope="col"><?php _e("Total", "gd-star-rating"); ?></th>
            <?php if ($options["review_active"] == 1) { ?>
                <th scope="col"><?php _e("Review", "gd-star-rating"); ?></th>
            <?php } ?>
        </tr>
    </thead>
    <tbody>
    
<?php
       
    $tr_class = "";
    foreach ($rows as $row) {
        $row = GDSRDB::convert_row($row);
        $moderate_articles = GDSRDatabase::get_moderation_count($row->pid);
        $moderate_comments = GDSRDatabase::get_moderation_count_joined($row->pid);
        
        if ($moderate_articles == 0)
            $moderate_articles = "[ <strong>0</strong> ] ";
        else
            $moderate_articles = sprintf('[<a href="./admin.php?page=gd-star-rating-stats&gdsr=moderation&pid=%s&vt=article"> <strong style="color: red;">%s</strong> </a>] ', $row->pid, $moderate_articles);

        if ($moderate_comments == 0)
            $moderate_comments = "[ <strong>0</strong> ] ";
        else
            $moderate_comments = sprintf('[<a href="./admin.php?page=gd-star-rating-stats&gdsr=moderation&pid=%s&vt=post"> <strong style="color: red;">%s</strong> </a>] ', $row->pid, $moderate_comments);
            
        $comment_count = GDSRDatabase::get_comments_count($row->pid);
        if ($comment_count == 0)
            $comment_count = '<a class="post-com-count" title="0"><span class="comment-count">0</span></a>';
        else
            $comment_count = sprintf('<a class="post-com-count" title="%s" href="./admin.php?page=gd-star-rating-stats&gdsr=comments&postid=%s"><span class="comment-count">%s</span></a>',
                $comment_count,
                $row->pid,
                $comment_count
            );
        $timer_info = "";
        if ($options["timer_active"] == 1) {
            if ($row->expiry_type == "D") {
                $timer_info = '<strong><span style="color: red">'.__("date limit", "gd-star-rating").'</span></strong><br />';
                $timer_info.= $row->expiry_value;
            }
            else if ($row->expiry_type == "T") {
                $timer_info = '<strong><span style="color: red">'.__("countdown", "gd-star-rating").'</span></strong><br />';
                $timer_info.= substr($row->expiry_value, 1)." ";
                switch (substr($row->expiry_value, 0, 1)) {
                    case "H":
                        $timer_info.= __("Hours", "gd-star-rating");
                        break;
                    case "D":
                        $timer_info.= __("Days", "gd-star-rating");
                        break;
                    case "M":
                        $timer_info.= __("Months", "gd-star-rating");
                        break;
                }
            }
            else $timer_info = __("no limit", "gd-star-rating");
        }

        if ($row->rating_total > $options["stars"] || $row->rating_visitors > $options["stars"] || $row->rating_users > $options["stars"])
            $tr_class.=" invalidarticle";

        echo '<tr id="post-'.$row->pid.'" class="'.$tr_class.' author-self status-publish" valign="top">';
        echo '<th scope="row" class="check-column"><input name="gdsr_item[]" value="'.$row->pid.'" type="checkbox"></th>';
        echo '<td><strong>'.$row->title.'</strong></td>';
        echo '<td nowrap="nowrap">';
            echo '<a href="'.get_permalink($row->pid).'" target="_blank"><img src="'.STARRATING_URL.'gfx/view.png" border="0" /></a>&nbsp;';
            echo '<a onclick="generateUrl('.$row->pid.')" href="#TB_inline?height=520&width=950&inlineId=gdsrchart" title="'.__("Charts", "gd-star-rating").'" class="thickbox"><img src="'.STARRATING_URL.'gfx/chart.png" border="0" /></a>';
        echo '</td>';
        echo '<td class="num"><div class="post-com-count-wrapper">'.$comment_count.'</div></td>';
        if ($options["moderation_active"] == 1) 
            echo '<td nowrap="nowrap">'.$moderate_articles.$row->moderate_articles.'<br />'.$moderate_comments.$row->moderate_comments.'</td>';
        if ($options["timer_active"] == 1)
            echo '<td>'.$timer_info.'</td>';
        echo '<td nowrap="nowrap">'.$row->rules_articles.'<br />'.$row->rules_comments.'</td>';
        echo '<td>'.GDSRDatabase::get_categories($row->pid).'</td>';
        echo '<td nowrap="nowrap">'.$row->votes.'</td>';
        echo '<td nowrap="nowrap">'.$row->total.'</td>';
        if ($options["review_active"] == 1) 
            echo '<td align="right">'.$row->review.'</td>';
        echo '</tr>';
        
        if ($tr_class == "")
            $tr_class = "alternate ";
        else
            $tr_class = "";
    }

?>

    </tbody>
</table>
<div class="tablenav" style="height: 13em">
    <div class="alignleft">
        <div class="panel">
        <table cellpadding="0" cellspacing="0">
        <tr>
        <td>
            <table cellpadding="0" cellspacing="0">
            <tr>
                <td style="width: 120px; height: 29px;">
                    <span class="paneltext"><strong><?php _e("Articles", "gd-star-rating"); ?>:</strong></span>
                </td>
                <td style="width: 80px; height: 29px;">
                    <span class="paneltext"><?php _e("Delete", "gd-star-rating"); ?>:</span>
                </td>
                <td style="width: 140px; height: 29px;" align="right">
                    <select id="gdsr_delete_articles" name="gdsr_delete_articles" style="width: 120px;">
                        <option value="">/</option>
                        <option value="AV"><?php _e("Visitors", "gd-star-rating"); ?></option>
                        <option value="AU"><?php _e("Users", "gd-star-rating"); ?></option>
                        <option value="AA"><?php _e("All", "gd-star-rating"); ?></option>
                    </select>
                </td><td style="width: 10px"></td>
                <?php if ($options["moderation_active"] == 1) { ?>
                <td style="width: 80px; height: 29px;">
                    <span class="paneltext"><?php _e("Moderation", "gd-star-rating"); ?>:</span>
                </td>
                <td style="width: 140px; height: 29px;" align="right">
                <?php GDSRHelper::render_moderation_combo("gdsr_article_moderation", "/", 120, "", true); ?>
                </td><td style="width: 10px"></td>
                <?php } ?>
                <td style="width: 80px; height: 29px;">
                    <span class="paneltext"><?php _e("Vote Rules", "gd-star-rating"); ?>:</span>
                </td>
                <td style="width: 140px; height: 29px;" align="right">
                <?php GDSRHelper::render_rules_combo("gdsr_article_voterules", "/", 120, "", true); ?>
                </td>
            </tr>
            </table>
            <table cellpadding="0" cellspacing="0">
            <tr>
                <td style="width: 120px; height: 29px;">
                </td>
                <?php if ($options["review_active"] == 1) { ?>
                <td style="width: 80px; height: 29px;">
                    <span class="paneltext"><?php _e("Review", "gd-star-rating"); ?>:</span>
                </td>
                <td style="width: 140px; height: 29px;" align="right">
                <select id="gdsr_review_rating" name="gdsr_review_rating" style="width: 50px; text-align: right;">
                    <option value="">/</option>
                    <?php GDSRHelper::render_stars_select_full(-1, $options["review_stars"], 0); ?>
                </select>.
                <select id="gdsr_review_rating_decimal" name="gdsr_review_rating_decimal" style="width: 50px; text-align: right;">
                    <option value="">/</option>
                    <?php GDSRHelper::render_stars_select_full(-1, 9, 0); ?>
                </select>
                </td><td style="width: 10px"></td>
                <?php } ?>
                <td style="width: 80px; height: 29px;">
                    <span class="paneltext"><?php _e("Restriction", "gd-star-rating"); ?>:</span>
                </td>
                <td style="width: 140px; height: 29px;" align="right">
                <?php GDSRHelper::render_timer_combo("gdsr_timer_type", $timer_restrictions, 120, '', true, 'gdsrTimerChange()'); ?>
                </td><td style="width: 10px"></td>
                <td style="width: 80px; height: 29px;">
                    <div id="gdsr_timer_countdown_text" style="display: none"><span class="paneltext"><?php _e("Countdown", "gd-star-rating"); ?>:</span></div>
                    <div id="gdsr_timer_date_text" style="display: none"><span class="paneltext"><?php _e("Date", "gd-star-rating"); ?>:</span></div>
                </td>
                <td style="width: 140px; height: 29px;" align="right">
                    <div id="gdsr_timer_countdown" style="display: none"><input type="text" value="<?php echo $countdown_value; ?>" id="gdsr_timer_countdown_value" name="gdsr_timer_countdown_value" style="width: 35px; text-align: right; padding: 2px;" />
                    <?php GDSRHelper::render_countdown_combo("gdsr_timer_countdown_type", $countdown_type, 70); ?></div>
                    <div id="gdsr_timer_date" style="display: none"><input type="text" value="<?php echo $timer_date_value; ?>" id="gdsr_timer_date_value" name="gdsr_timer_date_value" style="width: 110px; padding: 2px;" /></div>
                </td>
            </tr>
            </table>
            <div class="gdsr-table-split"></div>
            <?php if ($options["comments_active"] == 1) { ?>
            <table cellpadding="0" cellspacing="0">
            <tr>
                <td style="width: 120px; height: 29px;">
                    <span class="paneltext"><strong><?php _e("Comments", "gd-star-rating"); ?>:</strong></span>
                </td>
                <td style="width: 80px; height: 29px;">
                    <span class="paneltext"><?php _e("Delete", "gd-star-rating"); ?>:</span>
                </td>
                <td style="width: 140px; height: 29px;" align="right">
                    <select id="gdsr_delete_articles" name="gdsr_delete_comments" style="margin-top: -4px; width: 120px;">
                        <option value="">/</option>
                        <option value="CV"><?php _e("Visitors", "gd-star-rating"); ?></option>
                        <option value="CU"><?php _e("Users", "gd-star-rating"); ?></option>
                        <option value="CA"><?php _e("All", "gd-star-rating"); ?></option>
                    </select>
                </td><td style="width: 10px"></td>
                <?php if ($options["moderation_active"] == 1) { ?>
                <td style="width: 80px; height: 29px;">
                    <span class="paneltext"><?php _e("Moderation", "gd-star-rating"); ?>:</span>
                </td>
                <td style="width: 140px; height: 29px;" align="right">
                <?php GDSRHelper::render_moderation_combo("gdsr_comments_moderation", "/", 120, "", true); ?>
                </td><td style="width: 10px"></td>
                <?php } ?>
                <td style="width: 80px; height: 29px;">
                    <span class="paneltext"><?php _e("Vote Rules", "gd-star-rating"); ?>:</span>
                </td>
                <td style="width: 140px; height: 29px;" align="right">
                <?php GDSRHelper::render_rules_combo("gdsr_comments_voterules", "/", 120, "", true); ?>
                </td>
            </tr>
            </table>
            <?php } ?>
            <div class="gdsr-table-split"></div>
            <table cellpadding="0" cellspacing="0">
            <tr>
                <td style="width: 120px; height: 29px;">
                    <span class="paneltext"><strong><?php _e("Fixing", "gd-star-rating"); ?>:</strong></span>
                </td>
            </tr>
            </table>
        </td>
        <td style="width: 10px;"></td>
        <td class="gdsr-vertical-line">
            <input class="button-secondary delete" type="submit" name="gdsr_update" value="<?php _e("Update", "gd-star-rating"); ?>" />
        </td>
        </tr>
        </table>
        </div>
    </div>
<br class="clear"/>
</div>
<br class="clear"/>
</form>
</div>

<div id="gdsrchart" style="display: none">
    <?php include(STARRATING_PATH.'options/articles_chart.php'); ?>
</div>