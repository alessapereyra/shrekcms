<?php

    if ($_POST["gdsr_reinstall"] == __("Reinstall", "gd-star-rating")) {
        gdDBInstallGDSR::drop_tables(STARRATING_PATH);
        gdDBInstallGDSR::create_tables(STARRATING_PATH);
        ?> <div id="message" class="updated fade" style="background-color: rgb(255, 251, 204);"><p><strong><?php _e("Database tables reinstalled.", "gd-star-rating"); ?></strong></p></div> <?php
    }
    if ($_POST["gdsr_remultis"] == __("Reinstall", "gd-star-rating")) {
        gdDBInstallGDSR::drop_table("gdsr_multis");
        gdDBInstallGDSR::drop_table("gdsr_multis_data");
        gdDBInstallGDSR::drop_table("gdsr_multis_trend");
        gdDBInstallGDSR::drop_table("gdsr_multis_values");
        gdDBInstallGDSR::create_tables(STARRATING_PATH);
        GDSRDB::insert_default_templates(STARRATING_PATH);
        GDSRDB::insert_extras_templates(STARRATING_PATH);
        GDSRDB::insert_extras_templates(STARRATING_XTRA_PATH, false);
        ?> <div id="message" class="updated fade" style="background-color: rgb(255, 251, 204);"><p><strong><?php _e("Multi rating tables reinstalled.", "gd-star-rating"); ?></strong></p></div> <?php
    }
    if ($_POST["gdsr_remove_settings"] == __("Remove Settings", "gd-star-rating")) {
        delete_option('gd-star-rating');
        delete_option('widget_gdstarrating');
        ?> <div id="message" class="updated fade" style="background-color: rgb(255, 251, 204);"><p><strong><?php _e("Settings are removed from WordPress installation.", "gd-star-rating"); ?></strong></p></div> <?php
    }
    if ($_POST["gdsr_remove_templates"] == __("Reinstall Templates", "gd-star-rating")) {
        gdDBInstallGDSR::drop_table("gdsr_templates");
        gdDBInstallGDSR::create_tables(STARRATING_PATH);
        GDSRDB::insert_default_templates(STARRATING_PATH);
        GDSRDB::insert_extras_templates(STARRATING_PATH);
        GDSRDB::insert_extras_templates(STARRATING_XTRA_PATH, false);
        delete_option('gd-star-rating-templates');
        ?> <div id="message" class="updated fade" style="background-color: rgb(255, 251, 204);"><p><strong><?php _e("Plugins default templates are reinstalled.", "gd-star-rating"); ?></strong></p></div> <?php
    }
    if ($_POST["gdsr_reset_imports"] == __("Reset Imports", "gd-star-rating")) {
        delete_option('gd-star-rating-import');
        ?> <div id="message" class="updated fade" style="background-color: rgb(255, 251, 204);"><p><strong><?php _e("Import Information is reseted.", "gd-star-rating"); ?></strong></p></div> <?php
    }

?>
<script>
    function areYouSure() {
        return confirm("<?php _e("Are you sure? Operation is not reversible.", "gd-star-rating"); ?>");
    }
</script>

<div class="wrap"><h2 class="gdptlogopage">GD Star Rating: <?php _e("Setup", "gd-star-rating"); ?></h2>
<div id="gdsr_tabs" class="gdsrtabs">
<ul>
    <li><a href="#fragment-1"><span><?php _e("Database Maintenance", "gd-star-rating"); ?></span></a></li>
    <li><a href="#fragment-2"><span><?php _e("Global Maintenance", "gd-star-rating"); ?></span></a></li>
    <li><a href="#fragment-3"><span><?php _e("Full Uninstall", "gd-star-rating"); ?></span></a></li>
</ul>
<div style="clear: both"></div>
<div id="fragment-1">
<?php include STARRATING_PATH."options/setup/setup_database.php"; ?>
</div>
<div id="fragment-2">
<?php include STARRATING_PATH."options/setup/setup_global.php"; ?>
</div>
<div id="fragment-3">
<?php include STARRATING_PATH."options/setup/setup_uninstall.php"; ?>
</div>
</div>
</div>