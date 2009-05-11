<div class="wrap">
    <h2 class="gdptlogopage">GD Star Rating: <?php _e("Export Data", "gd-star-rating"); ?></h2>
<div class="gdsr">

<div id="gdsr_tabs" class="gdsrtabs">
<ul>
    <li><a href="#fragment-1"><span><?php _e("Users Data", "gd-star-rating"); ?></span></a></li>
    <li><a href="#fragment-2"><span><?php _e("T2 Templates", "gd-star-rating"); ?></span></a></li>
</ul>
<div style="clear: both"></div>

<div id="fragment-1">
<?php include STARRATING_PATH."options/export/export_users.php"; ?>
</div>

<div id="fragment-2">
<?php include STARRATING_PATH."options/export/export_t2.php"; ?>
</div>

</div>

</div>
</div>