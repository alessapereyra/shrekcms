<?php

$filter_section = "";

if ($_POST["gdsr_filter"] == __("Filter", "gd-star-rating")) {
    $filter_section = $_POST["filter_section"];
}

$all_sections = $tpls->list_sections_assoc();

?>

<div class="wrap"><h2 class="gdptlogopage">GD Star Rating: T2 <?php _e("Templates", "gd-star-rating"); ?></h2>
<div class="gdsr">

<div class="tablenav">
    <div class="alignleft">
        <form method="post">
            <?php GDSRHelper::render_templates_sections("filter_section", $tpls->list_sections(), true, $filter_section) ?>
            <input class="button-secondary delete" type="submit" name="gdsr_filter" value="<?php _e("Filter", "gd-star-rating"); ?>" />
        </form>
    </div>
    <div class="tablenav-pages">
    </div>
</div>
<br class="clear"/>

<table class="widefat">
    <thead>
        <tr>
            <th scope="col" width="33"><?php _e("ID", "gd-star-rating"); ?></th>
            <th scope="col"><?php _e("Name", "gd-star-rating"); ?></th>
            <th scope="col"><?php _e("Section / Type", "gd-star-rating"); ?></th>
            <th scope="col"><?php _e("Description", "gd-star-rating"); ?></th>
            <th scope="col"><?php _e("Tag", "gd-star-rating"); ?></th>
            <th scope="col" style="text-align: right"><?php _e("Options", "gd-star-rating"); ?></th>
        </tr>
    </thead>
    <tbody>

<?php

    $templates = GDSRDB::get_templates($filter_section);

    $tr_class = "";
    foreach ($templates as $t) {
        $mode = $t->preinstalled == "0" ? "edit" : "copy";
        $url = "admin.php?page=gd-star-rating-t2&";
        echo '<tr id="post-'.$t->template_id.'" class="'.$tr_class.' author-self status-publish" valign="top">';
        echo '<td><strong>'.$t->template_id.'</strong></td>';
        echo '<td><strong><a href="'.$url.'mode='.$mode.'&tplid='.$t->template_id.'">'.$t->name.'</a></strong></td>';
        echo '<td>'.$all_sections[$t->section].'</td>';
        echo '<td>'.$t->description.'</td>';
        echo '<td>'.$tpls->find_template_tag($t->section).'</td>';
        echo '<td style="text-align: right">';
        if ($t->preinstalled == "0") echo '<a href="'.$url.'deltpl='.$t->template_id.'">delete</a> | ';
        if ($t->preinstalled == "0") echo '<a href="'.$url.'mode=edit&tplid='.$t->template_id.'">edit</a> | ';
        echo '<a href="'.$url.'mode=copy&tplid='.$t->template_id.'">duplicate</a>';
        echo '</td>';
        echo '</tr>';
        
        if ($tr_class == "")
            $tr_class = "alternate ";
        else
            $tr_class = "";
    }

?>

    </tbody>
</table>
<br class="clear"/>

<div class="tablenav">
    <div class="alignleft">
        <form method="post">
            <input class="button-secondary delete" type="submit" name="gdsr_defaults" value="<?php _e("Set Default Templates", "gd-star-rating"); ?>" />
        </form>
    </div>
    <div class="tablenav-pages">
        <form method="post">
            <table cellpadding="0" cellspacing="0"><tr><td>
            <?php _e("New template for:", "gd-star-rating"); ?> </td><td>
            <?php GDSRHelper::render_templates_sections("tpl_section", $tpls->list_sections(), false) ?>
            <input class="button-secondary delete" type="submit" name="gdsr_create" value="<?php _e("Create", "gd-star-rating"); ?>" />
            </td></tr></table>
        </form>
    </div>
</div>
<br class="clear"/>
</div>

</div>
</div>
