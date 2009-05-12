<table class="form-table"><tbody>
<tr><th scope="row"><?php _e("Display", "gd-star-rating"); ?></th>
    <td>
        <table cellpadding="0" cellspacing="0" class="previewtable">
            <tr>
                <td width="150"><?php _e("Maximum screen width", "gd-star-rating"); ?>:</td>
                <td width="200">
                    <select name="gdsr_admin_width" id="gdsr_admin_width" style="width: 180px; text-align: center">
                        <option value="980"<?php echo $gdsr_options["admin_width"] == '980' ? ' selected="selected"' : ''; ?>>1024 px</option>
                        <option value="1240"<?php echo $gdsr_options["admin_width"] == '1240' ? ' selected="selected"' : ''; ?>>1280 px</option>
                        <option value="1400"<?php echo $gdsr_options["admin_width"] == '1400' ? ' selected="selected"' : ''; ?>>1440 px</option>
                        <option value="1640"<?php echo $gdsr_options["admin_width"] == '1640' ? ' selected="selected"' : ''; ?>>1680 px</option>
                        <option value="1880"<?php echo $gdsr_options["admin_width"] == '1880' ? ' selected="selected"' : ''; ?>>1920 px</option>
                    </select>
                </td>
                <td width="10"></td>
                <td width="150"><?php _e("Rows for display", "gd-star-rating"); ?>:</td>
                <td width="200">
                    <select name="gdsr_admin_rows" id="gdsr_admin_rows" style="width: 180px; text-align: center">
                        <option value="5"<?php echo $gdsr_options["admin_rows"] == '5' ? ' selected="selected"' : ''; ?>>5</option>
                        <option value="10"<?php echo $gdsr_options["admin_rows"] == '10' ? ' selected="selected"' : ''; ?>>10</option>
                        <option value="20"<?php echo $gdsr_options["admin_rows"] == '20' ? ' selected="selected"' : ''; ?>>20</option>
                        <option value="50"<?php echo $gdsr_options["admin_rows"] == '50' ? ' selected="selected"' : ''; ?>>50</option>
                        <option value="100"<?php echo $gdsr_options["admin_rows"] == '100' ? ' selected="selected"' : ''; ?>>100</option>
                    </select>
                </td>
            </tr>
        </table>
    </td>
</tr>
<tr><th scope="row"><?php _e("Settings", "gd-star-rating"); ?></th>
    <td>
        <input type="checkbox" name="gdsr_news_feed_active" id="gdsr_news_feed_active"<?php if ($gdsr_options["news_feed_active"] == 1) echo " checked"; ?> /><label style="margin-left: 5px;" for="gdsr_news_feed_active"><?php _e("Update front page latest news feed.", "gd-star-rating"); ?></label>
    </td>
</tr>
<tr><th scope="row"><?php _e("Panels", "gd-star-rating"); ?></th>
    <td>
        <table cellpadding="0" cellspacing="0" class="previewtable">
            <tr>
                <td width="350" valign="top">
                    <input type="checkbox" name="gdsr_admin_category" id="gdsr_admin_category"<?php if ($gdsr_options["admin_category"] == 1) echo " checked"; ?> /><label style="margin-left: 5px;" for="gdsr_admin_category"><strong><?php _e("Categories", "gd-star-rating"); ?></strong>: <?php _e("Managment for default settings.", "gd-star-rating"); ?></label>
                    <br />
                    <input type="checkbox" name="gdsr_admin_users" id="gdsr_admin_users"<?php if ($gdsr_options["admin_users"] == 1) echo " checked"; ?> /><label style="margin-left: 5px;" for="gdsr_admin_users"><strong><?php _e("Users", "gd-star-rating"); ?></strong>: <?php _e("Users rating managment.", "gd-star-rating"); ?></label>
                    <br />
                    <input type="checkbox" name="gdsr_admin_setup" id="gdsr_admin_setup"<?php if ($gdsr_options["admin_setup"] == 1) echo " checked"; ?> /><label style="margin-left: 5px;" for="gdsr_admin_setup"><strong><?php _e("Setup", "gd-star-rating"); ?></strong>: <?php _e("Uninstall and maintenance.", "gd-star-rating"); ?></label>
                </td>
                <td width="10"></td>
                <td valign="top">
                    <input type="checkbox" name="gdsr_admin_import" id="gdsr_admin_import"<?php if ($gdsr_options["admin_import"] == 1) echo " checked"; ?> /><label style="margin-left: 5px;" for="gdsr_admin_import"><strong><?php _e("Import", "gd-star-rating"); ?></strong>: <?php _e("Importing data for other rating plugins.", "gd-star-rating"); ?></label>
                    <br />
                    <input type="checkbox" name="gdsr_admin_ips" id="gdsr_admin_ips"<?php if ($gdsr_options["admin_ips"] == 1) echo " checked"; ?> /><label style="margin-left: 5px;" for="gdsr_admin_ips"><strong><?php _e("IP's", "gd-star-rating"); ?></strong>: <?php _e("IP addresses managment.", "gd-star-rating"); ?></label>
                </td>
            </tr>
        </table>
    </td>
</tr>
</tbody></table>
