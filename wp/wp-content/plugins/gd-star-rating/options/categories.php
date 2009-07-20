<?php

$posts_per_page = $options["admin_rows"];

$url = $_SERVER['REQUEST_URI'];
$url_pos = strpos($url, "&gdsr=");
if (!($url_pos === false))
    $url = substr($url, 0, $url_pos);

$url.= "&gdsr=categories";

$page_id = 1;
if (isset($_GET["pg"])) $page_id = $_GET["pg"];

if ($_POST["gdsr_update"] == __("Update", "gd-star-rating")) {
    $gdsr_items = $_POST["gdsr_item"];
    if (count($gdsr_items) > 0) {
        $ids = "(".join(", ", $gdsr_items).")";
        GDSRDatabase::update_category_settings($ids, $_POST["gdsr_article_moderation"], $_POST["gdsr_article_voterules"], $_POST["gdsr_comments_moderation"], $_POST["gdsr_comments_voterules"], $gdsr_items);
    }
}

$all_cats = GDSRDatabase::get_all_categories();
$categories = GDSRHelper::get_categories_hierarchy($all_cats);

$number_posts = count($categories);

$max_page = floor($number_posts / $posts_per_page);
if ($max_page * $posts_per_page != $number_posts) $max_page++;

if ($max_page > 1)
    $pager = GDSRHelper::draw_pager($max_page, $page_id, $url, "pg");

$cat_from = ($page_id - 1) * $posts_per_page;
$cat_to = $page_id * $posts_per_page;
if ($cat_to > $number_posts) $cat_to = $number_posts;
    
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
<h2 class="gdptlogopage">GD Star Rating: <?php _e("Categories", "gd-star-rating"); ?></h2>
<div class="tablenav">
    <div class="alignleft">
    </div>
    <div class="tablenav-pages">
        <?php echo $pager; ?>
    </div>
</div>
<br class="clear"/>
<table class="widefat">
    <thead>
        <tr>
            <th class="check-column" scope="col"><input type="checkbox" onclick="checkAll(document.getElementById('gdsr-articles'));"/></th>
            <th scope="col"><?php _e("Category", "gd-star-rating"); ?></th>
            <th scope="col" width="16"></th>
            <?php if ($options["moderation_active"] == 1) { ?>
                <th scope="col"><?php _e("Moderation", "gd-star-rating"); ?></th>
            <?php } ?>
            <?php if ($options["timer_active"] == 1) { ?>
                <th scope="col"><?php _e("Time Restrictions", "gd-star-rating"); ?></th>
            <?php } ?>
            <th scope="col"><?php _e("Vote Rules", "gd-star-rating"); ?></th>
            <th scope="col"><?php _e("Posts", "gd-star-rating"); ?></th>
        </tr>
    </thead>
    <tbody>

<?php
       
    $tr_class = "";
    for ($i = $cat_from; $i < $cat_to; $i++) {
        $row = $categories[$i];
        $row = GDSRDB::convert_category_row($row);
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

        echo '<tr id="post-'.$row->term_id.'" class="'.$tr_class.' author-self status-publish" valign="top">';
        echo '<th scope="row" class="check-column"><input name="gdsr_item[]" value="'.$row->term_id.'" type="checkbox"></th>';
        echo '<td><strong><a href="./admin.php?page=gd-star-rating-stats&gdsr=articles&cat='.$row->term_id.'">';
        echo str_repeat("― ", $row->depth).$row->name;
        echo '</a></strong></td>';
        echo '<td><a href="'.get_category_link($row->term_id).'" target="_blank"><img src="'.STARRATING_URL.'gfx/view.png" border="0" /></a></td>';
        if ($options["moderation_active"] == 1) 
            echo '<td nowrap="nowrap">'.$row->moderate_articles.'<br />'.$row->moderate_comments.'</td>';
        if ($options["timer_active"] == 1)
            echo '<td>'.$timer_info.'</td>';
        echo '<td nowrap="nowrap">'.$row->rules_articles.'<br />'.$row->rules_comments.'</td>';
        echo '<td>'.$row->count.'</td>';
        echo '</tr>';
        
        if ($tr_class == "")
            $tr_class = "alternate ";
        else
            $tr_class = "";
    }

?>

    </tbody>
</table>
<div class="tablenav" style="height: 9em">
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
                <?php GDSRHelper::render_moderation_combo("gdsr_article_moderation", "/", 120, "", true, true); ?>
                </td><td style="width: 10px"></td>
                <?php } ?>
                <td style="width: 80px; height: 29px;">
                    <span class="paneltext"><?php _e("Vote Rules", "gd-star-rating"); ?>:</span>
                </td>
                <td style="width: 140px; height: 29px;" align="right">
                <?php GDSRHelper::render_rules_combo("gdsr_article_voterules", "/", 120, "", true, true); ?>
                </td>
            </tr>
            </table>
            <table cellpadding="0" cellspacing="0">
            <tr>
                <td style="width: 120px; height: 29px;">
                </td>
                <td style="width: 80px; height: 29px;">
                    <span class="paneltext"><?php _e("Restriction", "gd-star-rating"); ?>:</span>
                </td>
                <td style="width: 140px; height: 29px;" align="right">
                <?php GDSRHelper::render_timer_combo("gdsr_timer_type", $timer_restrictions, 120, '', true, 'gdsrTimerChange()', true); ?>
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
                <td></td>
                <td></td>
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
                <?php GDSRHelper::render_moderation_combo("gdsr_comments_moderation", "/", 120, "", true, true); ?>
                </td><td style="width: 10px"></td>
                <?php } ?>
                <td style="width: 80px; height: 29px;">
                    <span class="paneltext"><?php _e("Vote Rules", "gd-star-rating"); ?>:</span>
                </td>
                <td style="width: 140px; height: 29px;" align="right">
                <?php GDSRHelper::render_rules_combo("gdsr_comments_voterules", "/", 120, "", true, true); ?>
                </td>
            </tr>
            </table>
            <?php } ?>
        </td>
        <td style="width: 10px;"></td>
        <td class="gdsr-vertical-line"><input class="button-secondary delete" type="submit" name="gdsr_update" value="<?php _e("Update", "gd-star-rating"); ?>" /></td>
        </tr>
        </table>
        </div>
    </div>
<br class="clear"/>
</div>
</form>
</div>
