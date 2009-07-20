    <input type="hidden" id="gdsr_post_edit" name="gdsr_post_edit" value="edit" />
    <h4 class="gdsr-section-title"><?php _e("Post Review", "gd-star-rating"); ?>:</h4>
    <table width="<?php echo $box_width; ?>"><tr>
    <td style="height: 25px;"><label style="font-size: 12px;" for="gdsr_review"><?php _e("Value", "gd-star-rating"); ?>:</label></td>
    <td align="right" style="height: 25px;" valign="baseline">
    <select style="width: 50px; text-align: right;" name="gdsr_review" id="gdsr_review">
        <option value="-1">/</option>
        <?php GDSRHelper::render_stars_select_full($rating, $gdsr_options["review_stars"], 0); ?>
    </select><span style="vertical-align: bottom;">.</span>
    <select id="gdsr_review_decimal" name="gdsr_review_decimal" style="width: 50px; text-align: right;">
        <option value="-1">/</option>
        <?php GDSRHelper::render_stars_select_full($rating_decimal, 9, 0); ?>
    </select>
    </td></tr></table>
    <div class="gdsr-table-split-edit"></div>
    <h4 class="gdsr-section-title"><?php _e("Post Rating", "gd-star-rating"); ?>:</h4>
    <table width="<?php echo $box_width; ?>"><tr>
    <td style="height: 25px;"><label style="font-size: 12px;"><?php _e("Vote Rule", "gd-star-rating"); ?>:</label></td>
    <td align="right" style="height: 25px;" valign="baseline">
    <?php GDSRHelper::render_rules_combo("gdsr_vote_articles", $vote_rules, 110); ?>
    </td>
    <?php if ($gdsr_options["moderation_active"] == 1) { ?>
    </tr><tr>
    <td style="height: 25px;"><label style="font-size: 12px;"><?php _e("Moderate", "gd-star-rating"); ?>:</label></td>
    <td align="right" style="height: 25px;" valign="baseline">
    <?php GDSRHelper::render_moderation_combo("gdsr_mod_articles", $moderation_rules, 110); ?>
    </td>
    <?php } ?>
    </tr></table>
    <?php if ($gdsr_options["comments_active"] == 1) { ?>
    <div class="gdsr-table-split-edit"></div>
    <h4 class="gdsr-section-title"><?php _e("Comments Rating", "gd-star-rating"); ?>:</h4>
    <table width="<?php echo $box_width; ?>"><tr>
    <td style="height: 25px;"><label style="font-size: 12px;"><?php _e("Vote Rule", "gd-star-rating"); ?>:</label></td>
    <td align="right" style="height: 25px;" valign="baseline">
    <?php GDSRHelper::render_rules_combo("gdsr_cmm_vote_articles", $cmm_vote_rules, 110); ?>
    </td>
    <?php if ($gdsr_options["moderation_active"] == 1) { ?>
    </tr><tr>
    <td style="height: 25px;"><label style="font-size: 12px;"><?php _e("Moderate", "gd-star-rating"); ?>:</label></td>
    <td align="right" style="height: 25px;" valign="baseline">
    <?php GDSRHelper::render_moderation_combo("gdsr_cmm_mod_articles", $cmm_moderation_rules, 110); ?>
    </td>
    <?php } ?>
    </tr></table>
    <?php } ?>
    <?php if ($gdsr_options["timer_active"] == 1) { ?>
    <div class="gdsr-table-split-edit"></div>
    <h4 class="gdsr-section-title"><?php _e("Time Restriction", "gd-star-rating"); ?>:</h4>
    <table width="<?php echo $box_width; ?>"><tr>
    <td style="height: 25px;"><label style="font-size: 12px;" for="gdsr_review"><?php _e("Restriction", "gd-star-rating"); ?>:</label></td>
    <td align="right" style="height: 25px;" valign="baseline">
    <?php GDSRHelper::render_timer_combo("gdsr_timer_type", $timer_restrictions, 110, '', false, 'gdsrTimerChange()'); ?>
    </td>
    </tr></table>
    <div id="gdsr_timer_date" style="display: <?php echo $timer_restrictions == "D" ? "block" : "none" ?>">
        <table width="<?php echo $box_width; ?>"><tr>
        <td style="height: 25px;"><label style="font-size: 12px;" for="gdsr_review"><?php _e("Date", "gd-star-rating"); ?>:</label></td>
        <td align="right" style="height: 25px;" valign="baseline">
            <input type="text" value="<?php echo $timer_date_value; ?>" id="gdsr_timer_date_value" name="gdsr_timer_date_value" style="width: 100px; padding: 2px;" />
        </td>
        </tr></table>
    </div>
    <div id="gdsr_timer_countdown" style="display: <?php echo $timer_restrictions == "T" ? "block" : "none" ?>">
        <table width="<?php echo $box_width; ?>"><tr>
        <td style="height: 25px;"><label style="font-size: 12px;" for="gdsr_review"><?php _e("Countdown", "gd-star-rating"); ?>:</label></td>
        <td align="right" style="height: 25px;" valign="baseline">
            <input type="text" value="<?php echo $countdown_value; ?>" id="gdsr_timer_countdown_value" name="gdsr_timer_countdown_value" style="width: 35px; text-align: right; padding: 2px;" />
            <?php GDSRHelper::render_countdown_combo("gdsr_timer_countdown_type", $countdown_type, 60); ?>
        </td>
        </tr></table>
    </div>
    <?php } ?>
