<table class="form-table"><tbody>
<tr><th scope="row"><?php _e("Import Templates", "gd-star-rating"); ?></th>
    <td>
        <form method="post">
        <?php _e("This will import templates from alternative location:", "gd-star-rating"); ?>
        <strong> 'wp-content/gd-star-rating/data/gdsr_templates_cstm.txt'</strong><br />
        <input type="submit" class="inputbutton" value="<?php _e("Import", "gd-star-rating"); ?>" name="gdsr_t2_import" id="gdsr_t2_import" />
        <div class="gdsr-table-split"></div>
        <?php _e("Templates with same name as the templates already in database will be skipped.", "gd-star-rating"); ?>
        </form>
    </td>
</tr>
</tbody></table>
