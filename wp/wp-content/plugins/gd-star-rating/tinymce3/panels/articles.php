<div id="articlesreview_panel" class="panel">
<fieldset>
<legend><?php _e("Articles Review Rating", "gd-star-rating"); ?></legend>
<p><?php _e("StarReview will render stars representing review value assigned to the post or page.", "gd-star-rating"); ?></p>
</fieldset>

<fieldset>
<legend><?php _e("Template", "gd-star-rating"); ?></legend>
    <?php GDSRHelper::render_templates_section("RSB", "srTemplateRSB", 0, 300); ?>
</fieldset>
</div>

<div id="articlesrater_panel" class="panel">
<fieldset>
<legend><?php _e("Articles Rating Block", "gd-star-rating"); ?></legend>
<p><?php _e("StarRater will render actual rating block if you choose not to have it automatically inserted. This way you can position it wherever you want in the contnents.", "gd-star-rating"); ?></p>
</fieldset>

<fieldset>
<legend><?php _e("Template", "gd-star-rating"); ?></legend>
    <?php GDSRHelper::render_templates_section("SRB", "srRatingBlockTemplate", 0, 300); ?>
</fieldset>
</div>
