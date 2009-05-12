<table class="form-table"><tbody>
<tr><th scope="row"><?php _e("Voting", "gd-star-rating"); ?></th>
    <td>
        <input type="checkbox" name="gdsr_use_nonce" id="gdsr_use_nonce"<?php if ($gdsr_options["use_nonce"] == 1) echo " checked"; ?> /><label style="margin-left: 5px;" for="gdsr_ajax"><?php _e("Use Nonce with AJAX for improved security.", "gd-star-rating"); ?></label>
        <div class="gdsr-table-split"></div>
        <input type="checkbox" name="gdsr_ip_filtering" id="gdsr_ip_filtering"<?php if ($gdsr_options["ip_filtering"] == 1) echo " checked"; ?> /><label style="margin-left: 5px;" for="gdsr_ip_filtering"><?php _e("Use banned IP's lists to filter out visitors.", "gd-star-rating"); ?></label>
        <br />
        <input type="checkbox" name="gdsr_ip_filtering_restrictive" id="gdsr_ip_filtering_restrictive"<?php if ($gdsr_options["ip_filtering_restrictive"] == 1) echo " checked"; ?> /><label style="margin-left: 5px;" for="gdsr_ip_filtering_restrictive"><?php _e("Don't even show rating stars to visitors comming from banned IP's.", "gd-star-rating"); ?></label>
    </td>
</tr>
<tr><th scope="row"><?php _e("Plugin Features", "gd-star-rating"); ?></th>
    <td>
        <input type="checkbox" name="gdsr_external_javascript" id="gdsr_external_javascript"<?php if ($gdsr_options["external_javascript"] == 1) echo " checked"; ?> /><label style="margin-left: 5px;" for="gdsr_external_javascript"><?php _e("Link external javascript rating code, instead of embeding it into the page.", "gd-star-rating"); ?></label>
        <br />
        <input type="checkbox" name="gdsr_external_rating_css" id="gdsr_external_rating_css"<?php if ($gdsr_options["external_rating_css"] == 1) echo " checked"; ?> /><label style="margin-left: 5px;" for="gdsr_external_rating_css"><?php _e("Link external CSS rating code, uncheck to embed all the CSS into the page.", "gd-star-rating"); ?></label>
        <br />
        <input type="checkbox" name="gdsr_external_css" id="gdsr_external_css"<?php if ($gdsr_options["external_css"] == 1) echo " checked"; ?> /><label style="margin-left: 5px;" for="gdsr_external_css"><?php _e("Link additional css file", "gd-star-rating"); ?>: <strong>'wp-content/gd-star-rating/css/rating.css'</strong></label>
        <div class="gdsr-table-split"></div>
        <table cellpadding="0" cellspacing="0" class="previewtable">
            <tr>
                <td width="350" valign="top">
                    <input type="checkbox" name="gdsr_timer" id="gdsr_timer"<?php if ($gdsr_options["timer_active"] == 1) echo " checked"; ?> /><label style="margin-left: 5px;" for="gdsr_timer"><?php _e("Time restriction for rating.", "gd-star-rating"); ?></label>
                    <br />
                    <input type="checkbox" name="gdsr_modactive" id="gdsr_modactive"<?php if ($gdsr_options["moderation_active"] == 1) echo " checked"; ?> /><label style="margin-left: 5px;" for="gdsr_modactive"><?php _e("Moderation options and handling.", "gd-star-rating"); ?></label>
                    <br />
                    <input type="checkbox" name="gdsr_multis" id="gdsr_multis"<?php if ($gdsr_options["multis_active"] == 1) echo " checked"; ?> /><label style="margin-left: 5px;" for="gdsr_multis"><?php _e("Multiple rating support.", "gd-star-rating"); ?></label>
                </td>
                <td width="10"></td>
                <td valign="top">
                    <input type="checkbox" name="gdsr_reviewactive" id="gdsr_reviewactive"<?php if ($gdsr_options["review_active"] == 1) echo " checked"; ?> /><label style="margin-left: 5px;" for="gdsr_reviewactive"><?php _e("Post And Page Review Rating.", "gd-star-rating"); ?></label>
                    <br />
                    <input type="checkbox" name="gdsr_commentsactive" id="gdsr_commentsactive"<?php if ($gdsr_options["comments_active"] == 1) echo " checked"; ?> /><label style="margin-left: 5px;" for="gdsr_commentsactive"><?php _e("Comments Rating.", "gd-star-rating"); ?></label>
                    <br />
                    <input type="checkbox" name="gdsr_cmmreviewactive" id="gdsr_cmmreviewactive"<?php if ($gdsr_options["comments_review_active"] == 1) echo " checked"; ?> /><label style="margin-left: 5px;" for="gdsr_cmmreviewactive"><?php _e("Comments Review Rating.", "gd-star-rating"); ?></label>
                </td>
            </tr>
        </table>
        <div class="gdsr-table-split"></div>
        <input type="checkbox" name="gdsr_gfx_generator_auto" id="gdsr_gfx_generator_auto"<?php if ($gdsr_options["gfx_generator_auto"] == 1) echo " checked"; ?> /><label style="margin-left: 5px;" for="gdsr_gfx_generator_auto"><?php _e("Use graphics generator to generate and display static stars images.", "gd-star-rating"); ?></label>
        <br />
        <input type="checkbox" name="gdsr_gfx_prevent_leeching" id="gdsr_gfx_prevent_leeching"<?php if ($gdsr_options["gfx_prevent_leeching"] == 1) echo " checked"; ?> /><label style="margin-left: 5px;" for="gdsr_gfx_prevent_leeching"><?php _e("Prevent outside access to graphics generator. Graphics integrated into RSS is not affected.", "gd-star-rating"); ?></label>
        <div class="gdsr-table-split"></div>
        <?php _e("This leeching prevention will only work if a referer is sent and your server is set up correctly with proper server name variable.", "gd-star-rating"); ?>
    </td>
</tr>
<tr><th scope="row"><?php _e("Charset", "gd-star-rating"); ?></th>
    <td>
        <table cellpadding="0" cellspacing="0" class="previewtable">
            <tr>
                <td width="150"><?php _e("Character encoding", "gd-star-rating"); ?>:</td>
                <td><input type="text" name="gdsr_encoding" id="gdsr_encoding" value="<?php echo $gdsr_options["encoding"]; ?>" style="width: 170px;" /></td>
            </tr>
        </table>
        <?php _e("For list of supported charsets visit: ", "gd-star-rating"); ?><a href="http://www.php.net/manual/en/function.htmlentities.php" target="_blank">http://www.php.net/manual/en/function.htmlentities.php</a>
    </td>
</tr>
<tr><th scope="row"><?php _e("Rating Log", "gd-star-rating"); ?></th>
    <td>
        <input type="checkbox" name="gdsr_save_user_agent" id="gdsr_save_user_agent"<?php if ($gdsr_options["save_user_agent"] == 1) echo " checked"; ?> /><label style="margin-left: 5px;" for="gdsr_save_user_agent"><?php _e("Log user agent (browser) information.", "gd-star-rating"); ?></label>
        <br />
        <input type="checkbox" name="gdsr_save_cookies" id="gdsr_save_cookies"<?php if ($gdsr_options["save_cookies"] == 1) echo " checked"; ?> /><label style="margin-left: 5px;" for="gdsr_save_cookies"><?php _e("Save cookies with ratings.", "gd-star-rating"); ?></label>
    </td>
</tr>
<tr><th scope="row"><?php _e("Internet Explorer", "gd-star-rating"); ?></th>
    <td>
        <input type="checkbox" name="gdsr_ieopacityfix" id="gdsr_ieopacityfix"<?php if ($gdsr_options["ie_opacity_fix"] == 1) echo " checked"; ?> /><label style="margin-left: 5px;" for="gdsr_ieopacityfix"><?php _e("Use IE opacity fix for multi ratings.", "gd-star-rating"); ?></label>
    </td>
</tr>
</tbody></table>
