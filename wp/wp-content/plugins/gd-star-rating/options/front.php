<?php require_once(ABSPATH.WPINC.'/rss.php'); ?>

<div class="wrap">
    <div id="gdptlogo">
        <div class="gdpttitle">GD Star Rating<span><?php echo $options["version"]; ?></span></div>
        <h3>a wordpress rating system</h3>
    </div>

<table><tr><td valign="top">
<div class="metabox-holder">
<?php include(STARRATING_PATH.'options/front/front_left.php'); ?>
</div>
</td><td style="width: 20px"> </td><td valign="top">
<div class="metabox-holder">
<?php include(STARRATING_PATH.'options/front/front_right.php'); ?>
</div>
</td></tr></table>

</div>