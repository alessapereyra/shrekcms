<div id="commentsaggr_panel" class="panel">
<fieldset>
<legend><?php _e("Template", "gd-star-rating"); ?></legend>
    <?php GDSRHelper::render_templates_section("CAR", "srTemplateCAR", 0, 300); ?>
</fieldset>

<fieldset>
<legend><?php _e("Aggregated Comments Ratings", "gd-star-rating"); ?></legend>
    <table border="0" cellpadding="3" cellspacing="0" width="100%">
      <tr>
        <td class="gdsrleft"><?php _e("Calculate Votes From", "gd-star-rating"); ?>:</td>
        <td class="gdsrright"><label><select name="srCagShow" id="srCagShow" style="width: 130px">
            <option value="total"><?php _e("Everyone", "gd-star-rating"); ?></option>
            <option value="visitors"><?php _e("Visitors Only", "gd-star-rating"); ?></option>
            <option value="users"><?php _e("Users Only", "gd-star-rating"); ?></option>
        </select></label></td>
      </tr>
    </table>
</fieldset>
</div>
