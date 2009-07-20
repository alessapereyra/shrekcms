<div id="general_panel" class="panel">
<fieldset>
<legend><?php _e("Display", "gd-star-rating"); ?></legend>
    <table border="0" cellpadding="3" cellspacing="0" width="100%">
      <tr>
        <td class="gdsrleft"><?php _e("Number Of Posts", "gd-star-rating"); ?>:</td>
        <td class="gdsrright"><input type="text" size="8" id="srRows" name="srRows" value="10" /></td>
      </tr>
      <tr>
        <td class="gdsrleft"><?php _e("Items Grouping", "gd-star-rating"); ?>:</td>
        <td class="gdsrright"><label><select name="srGrouping" id="srGrouping" style="width: 130px">
            <option value="post"<?php echo $wpno['grouping'] == 'post' ? ' selected="selected"' : ''; ?>><?php _e("No grouping", "gd-star-rating"); ?></option>
            <option value="user"<?php echo $wpno['grouping'] == 'user' ? ' selected="selected"' : ''; ?>><?php _e("User based", "gd-star-rating"); ?></option>
            <option value="category"<?php echo $wpno['grouping'] == 'category' ? ' selected="selected"' : ''; ?>><?php _e("Category based", "gd-star-rating"); ?></option>
        </select></label></td>
      </tr>
    </table>
</fieldset>

<fieldset>
<legend><?php _e("Source", "gd-star-rating"); ?></legend>
    <table border="0" cellpadding="3" cellspacing="0" width="100%">
      <tr>
        <td class="gdsrleft"><?php _e("Data Source", "gd-star-rating"); ?>:</td>
        <td class="gdsrright">
            <select name="srDataSource" style="width: 130px" id="srDataSource" onchange="gdsrChangeSource(this.options[this.selectedIndex].value, 'tinymce')">
                <option value="standard"><?php _e("Standard Rating", "gd-star-rating"); ?></option>
                <?php if (count($gdst_multis) > 0) { ?><option value="multis"><?php _e("Multi Rating", "gd-star-rating"); ?></option><?php } ?>
            </select>
        </td>
      </tr>
    </table>
    <div id="gdsr-src-multi[tinymce]" style="display: none">
    <table border="0" cellpadding="2" cellspacing="0" width="100%">
      <tr>
        <td class="gdsrleft"><?php _e("Multi Set", "gd-star-rating"); ?>:</td>
        <td class="gdsrright"><select name="srMultiSet" id="srMultiSet"><?php GDSRHelper::render_styles_select($gdst_multis); ?></select></td>
      </tr>
    </table>
    </div>
</fieldset>

<fieldset>
<legend><?php _e("Trend", "gd-star-rating"); ?></legend>
    <table border="0" cellpadding="3" cellspacing="0" width="100%">
      <tr>
        <td class="gdsrleft"><?php _e("Rating trend display as", "gd-star-rating"); ?>:</td>
        <td class="gdsrright">
            <select name="trendRating" style="width: 110px" id="trendRating" onchange="gdsrChangeTrend('tr', this.options[this.selectedIndex].value, 'tinymce')">
                <option value="txt"><?php _e("Text", "gd-star-rating"); ?></option>
                <option value="img"><?php _e("Image", "gd-star-rating"); ?></option>
            </select>
        </td>
      </tr>
    </table>
    <div id="gdsr-tr-txt[tinymce]" style="display: block">
        <table border="0" cellpadding="3" cellspacing="0" width="100%">
          <tr>
            <td class="gdsrleft"></td>
            <td class="gdsrreg"><?php _e("Up", "gd-star-rating"); ?>:</td>
            <td width="40" class="gdsrright"><input class="widefat" style="width: 35px" type="text" name="trendRatingRise" id="trendRatingRise" value="+" /></td>
            <td class="gdsrreg"><?php _e("Equal", "gd-star-rating"); ?>:</td>
            <td width="40" class="gdsrright"><input class="widefat" style="width: 35px" type="text" name="trendRatingSame" id="trendRatingSame" value="=" /></td>
            <td class="gdsrreg"><?php _e("Down", "gd-star-rating"); ?>:</td>
            <td width="40" class="gdsrright"><input class="widefat" style="width: 35px" type="text" name="trendRatingFall" id="trendRatingFall" value="-" /></td>
          </tr>
        </table>
    </div>
    <div id="gdsr-tr-img[tinymce]" style="display: none">
        <table border="0" cellpadding="3" cellspacing="0" width="100%">
          <tr>
            <td class="gdsrleft"><?php _e("Image set", "gd-star-rating"); ?>:</td>
            <td class="gdsrright">
                <select name="trendRatingSet" id="trendRatingSet">
                    <?php GDSRHelper::render_styles_select($gdsr_trends); ?>
                </select>
            </td>
          </tr>
        </table>
    </div>
    <table border="0" cellpadding="3" cellspacing="0" width="100%">
      <tr>
        <td class="gdsrleft"><?php _e("Voting trend display as", "gd-star-rating"); ?>:</td>
        <td class="gdsrright">
            <select name="trendVoting" style="width: 110px" id="trendVoting" onchange="gdsrChangeTrend('tv', this.options[this.selectedIndex].value, 'tinymce')">
                <option value="txt"><?php _e("Text", "gd-star-rating"); ?></option>
                <option value="img"><?php _e("Image", "gd-star-rating"); ?></option>
            </select>
        </td>
      </tr>
    </table>
    <div id="gdsr-tv-txt[tinymce]" style="display: block">
        <table border="0" cellpadding="3" cellspacing="0" width="100%">
          <tr>
            <td class="gdsrleft"></td>
            <td class="gdsrreg"><?php _e("Up", "gd-star-rating"); ?>:</td>
            <td width="40" class="gdsrright"><input class="widefat" style="width: 35px" type="text" name="trendVotingRise" id="trendVotingRise" value="+" /></td>
            <td class="gdsrreg"><?php _e("Equal", "gd-star-rating"); ?>:</td>
            <td width="40" class="gdsrright"><input class="widefat" style="width: 35px" type="text" name="trendVotingSame" id="trendVotingSame" value="=" /></td>
            <td class="gdsrreg"><?php _e("Down", "gd-star-rating"); ?>:</td>
            <td width="40" class="gdsrright"><input class="widefat" style="width: 35px" type="text" name="trendVotingFall" id="trendVotingFall" value="-" /></td>
          </tr>
        </table>
    </div>
    <div id="gdsr-tv-img[tinymce]" style="display: none">
        <table border="0" cellpadding="3" cellspacing="0" width="100%">
          <tr>
            <td class="gdsrleft"><?php _e("Image set", "gd-star-rating"); ?>:</td>
            <td class="gdsrright">
                <select name="trendVotingSet" id="trendVotingSet">
                    <?php GDSRHelper::render_styles_select($gdsr_trends); ?>
                </select>
            </td>
          </tr>
        </table>
    </div>
</fieldset>

<fieldset>
<legend><?php _e("Hiding", "gd-star-rating"); ?></legend>
    <input type="checkbox" size="5" id="srHidemptyBayes" name="srHidemptyBayes" value="on" /><label for="srHidemptyBayes"> <?php _e("Bayesian minumum votes required.", "gd-star-rating"); ?></label><br />
    <input type="checkbox" size="5" id="srHidempty" name="srHidempty" checked value="on" /><label for="srHidempty"> <?php _e("Hide articles with no recorded votes.", "gd-star-rating"); ?></label><br />
    <input type="checkbox" size="5" id="srHidemptyReview" name="srHidemptyReview" value="on" /><label for="srHidemptyReview"> <?php _e("Hide articles with no review values.", "gd-star-rating"); ?></label>
</fieldset>
</div>

<div id="filter_panel" class="panel">
<fieldset>
<legend><?php _e("Basic", "gd-star-rating"); ?></legend>
    <table border="0" cellpadding="3" cellspacing="0" width="100%">
      <tr>
        <td class="gdsrleft"><?php _e("Include Articles", "gd-star-rating"); ?>:</td>
        <td class="gdsrright">
            <label><select id="srSelect" name="srSelect" style="width: 130px">
                <option value="postpage"><?php _e("Posts And Pages", "gd-star-rating"); ?></option>
                <option value="post"><?php _e("Posts Only", "gd-star-rating"); ?></option>
                <option value="page"><?php _e("Pages Only", "gd-star-rating"); ?></option>
            </select></label>
        </td>
      </tr>
      <tr>
        <td class="gdsrleft"><?php _e("Display Votes From", "gd-star-rating"); ?>:</td>
        <td class="gdsrright"><label><select name="srShow" id="srShow" style="width: 130px">
            <option value="total"><?php _e("Everyone", "gd-star-rating"); ?></option>
            <option value="visitors"><?php _e("Visitors Only", "gd-star-rating"); ?></option>
            <option value="users"><?php _e("Users Only", "gd-star-rating"); ?></option>
        </select></label></td>
      </tr>
      <tr>
        <td class="gdsrleft"><?php _e("Category", "gd-star-rating"); ?>:</td>
        <td class="gdsrright"><?php GDSRDatabase::get_combo_categories('', 'srCategory'); ?></td>
      </tr>
      <tr>
        <td class="gdsrleft"><?php _e("Minimum Votes", "gd-star-rating"); ?>:</td>
        <td class="gdsrright"><input style="text-align: right;" type="text" size="8" id="srMinVotes" name="srMinVotes" value="5" /></td>
      </tr>
    </table>
</fieldset>

<fieldset>
<legend><?php _e("Sorting", "gd-star-rating"); ?></legend>
    <table border="0" cellpadding="3" cellspacing="0" width="100%">
      <tr>
        <td class="gdsrleft"><?php _e("Column", "gd-star-rating"); ?>:</td>
        <td class="gdsrright">
            <label><select id="srColumn" name="srColumn" style="width: 130px">
            <option value="rating"><?php _e("Rating", "gd-star-rating"); ?></option>
            <option value="votes"><?php _e("Total Votes", "gd-star-rating"); ?></option>
            <option value="id"><?php _e("ID", "gd-star-rating"); ?></option>
            <option value="post_title"><?php _e("Title", "gd-star-rating"); ?></option>
            <option value="review"><?php _e("Review", "gd-star-rating"); ?></option>
            <option value="count"><?php _e("Count", "gd-star-rating"); ?></option>
            <option value="bayes"><?php _e("Bayesian Rating", "gd-star-rating"); ?></option>
            </select></label>
        </td>
      </tr>
      <tr>
        <td class="gdsrleft"><?php _e("Order", "gd-star-rating"); ?>:</td>
        <td class="gdsrright">
            <label><select id="srOrder" name="srOrder" style="width: 130px">
                <option value="desc"><?php _e("Descending", "gd-star-rating"); ?></option>
                <option value="asc"><?php _e("Ascending", "gd-star-rating"); ?></option>
            </select></label>
        </td>
      </tr>
    </table>
</fieldset>

<fieldset>
<legend><?php _e("Last Voted", "gd-star-rating"); ?></legend>
<?php _e("Use only articles voted for in last # days.", "gd-star-rating") ?>
    <table border="0" cellpadding="3" cellspacing="0" width="100%">
      <tr>
        <td class="gdsrleft"><?php _e("Enter 0 for all", "gd-star-rating"); ?>:</td>
        <td class="gdsrright"><input style="text-align: right;" size="8" type="text" name="srLastDate" id="srLastDate" value="0" /></td>
      </tr>
    </table>
</fieldset>

<fieldset>
<legend><?php _e("Date", "gd-star-rating"); ?></legend>
    <table border="0" cellpadding="3" cellspacing="0" width="100%">
      <tr>
        <td class="gdsrleft"><?php _e("Publish Date", "gd-star-rating"); ?>:</td>
        <td class="gdsrright">
            <select name="publishDate" style="width: 130px" id="publishDate" class="gdsrleft" onchange="gdsrChangeDate(this.options[this.selectedIndex].value, 'tinymce')">
                <option value="lastd"><?php _e("Last # days", "gd-star-rating"); ?></option>
                <option value="month"><?php _e("Exact month", "gd-star-rating"); ?></option>
                <option value="range"><?php _e("Date range", "gd-star-rating"); ?></option>
            </select>
        </td>
      </tr>
    </table>
    <div id="gdsr-pd-lastd[tinymce]" style="display: block">
    <table border="0" cellpadding="2" cellspacing="0" width="100%">
      <tr>
        <td class="gdsrleft"><?php _e("Number Of Days", "gd-star-rating"); ?>:</td>
        <td class="gdsrright">
            <input style="text-align: right;" size="8" type="text" name="publishDays" id="publishDays" value="0" />
        </td>
      </tr>
    </table>
    </div>
    <div id="gdsr-pd-month[tinymce]" style="display: none">
    <table border="0" cellpadding="2" cellspacing="0" width="100%">
      <tr>
        <td class="gdsrleft"><?php _e("Month", "gd-star-rating"); ?>:</td>
        <td class="gdsrright">
            <?php GDSRDatabase::get_combo_months("0", "publishMonth"); ?>
        </td>
      </tr>
    </table>
    </div>
    <div id="gdsr-pd-range[tinymce]" style="display: none">
    <table border="0" cellpadding="2" cellspacing="0" width="100%">
      <tr>
        <td class="gdsrleft"><?php _e("Range", "gd-star-rating"); ?>:</td>
        <td align="right" width="85"><input class="widefat" style="text-align: right; width: 85px" type="text" name="publishRangeFrom" id="publishRangeFrom" value="YYYYMMDD" /></td>
        <td align="center" width="10">-</td>
        <td align="right" width="85"><input class="widefat" style="text-align: right; width: 85px" type="text" name="publishRangeTo" id="publishRangeTo" value="YYYYMMDD" /></td>
      </tr>
    </table>
    </div>
</fieldset>
</div>

<div id="styles_panel" class="panel">
<fieldset>
<legend><?php _e("Template", "gd-star-rating"); ?></legend>
    <?php GDSRHelper::render_templates_section("SRR", "srTemplateSRR", 0, 300); ?>
</fieldset>

<fieldset>
<legend><?php _e("Post Image", "gd-star-rating"); ?></legend>
    <table border="0" cellpadding="2" cellspacing="0" width="100%">
      <tr>
        <td class="gdsrleft"><?php _e("Get Image From", "gd-star-rating"); ?>:</td>
        <td class="gdsrright">
            <label><select id="srImageFrom" name="srImageFrom" onchange="gdsrChangeImage(this.options[this.selectedIndex].value, 'tinymce')">
            <option value="none"><?php _e("No image", "gd-star-rating"); ?></option>
            <option value="custom"><?php _e("Custom field", "gd-star-rating"); ?></option>
            <option value="content"><?php _e("Post content", "gd-star-rating"); ?></option>
            </select></label>
        </td>
      </tr>
    </table>
    <div id="gdsr-pi-none[tinymce]" style="display: block">
    <?php _e("If you use %IMAGE% tag in template and this option is selected, image will not be rendered.", "gd-star-rating"); ?>
    </div>
    <div id="gdsr-pi-custom[tinymce]" style="display: none">
    <table border="0" cellpadding="2" cellspacing="0" width="100%">
      <tr>
        <td class="gdsrleft"><?php _e("Custom Field", "gd-star-rating"); ?>:</td>
        <td class="gdsrright">
            <?php GDSRHelper::render_custom_fields("srImageCustom", "", 200); ?>
        </td>
      </tr>
    </table>
    </div>
    <div id="gdsr-pi-content[tinymce]" style="display: none">
    <?php _e("First image from post content will be used for %IMAGE% tag.", "gd-star-rating"); ?>
    </div>
</fieldset>

<fieldset>
<legend><?php _e("Rating Stars", "gd-star-rating"); ?></legend>
    <table border="0" cellpadding="2" cellspacing="0" width="100%">
      <tr>
        <td class="gdsrleft"><?php _e("Set", "gd-star-rating"); ?>:</td>
        <td class="gdsrright">
            <label><select id="srStarsStyle" name="srStarsStyle">
                <?php GDSRHelper::render_styles_select($gdsr_styles, 'oxygen'); ?>
            </select></label>
        </td>
      </tr>
      <tr>
        <td class="gdsrleft"><?php _e("Size", "gd-star-rating"); ?>:</td>
        <td class="gdsrright">
            <label><?php GDSRHelper::render_star_sizes_tinymce("srStarsSize"); ?></label>
        </td>
      </tr>
    </table>
</fieldset>

<fieldset>
<legend><?php _e("Review Stars", "gd-star-rating"); ?></legend>
    <table border="0" cellpadding="2" cellspacing="0" width="100%">
      <tr>
        <td class="gdsrleft"><?php _e("Set", "gd-star-rating"); ?>:</td>
        <td class="gdsrright">
            <label><select id="srReviewStarsStyle" name="srReviewStarsStyle">
                <?php GDSRHelper::render_styles_select($gdsr_styles, 'oxygen'); ?>
            </select></label>
        </td>
      </tr>
      <tr>
        <td class="gdsrleft"><?php _e("Size", "gd-star-rating"); ?>:</td>
        <td class="gdsrright">
            <label><?php GDSRHelper::render_star_sizes_tinymce("srReviewStarsSize"); ?></label>
        </td>
      </tr>
    </table>
</fieldset>
</div>
