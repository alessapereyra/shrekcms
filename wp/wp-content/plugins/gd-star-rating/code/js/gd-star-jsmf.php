
function multi_rating_vote(block) {
    var el = block.split("_");
    var post_id = el[0];
    var set_id = el[1];
    var tpl_id = el[2];
    var values = jQuery("#gdsr_multi_" + post_id + "_" + set_id).val();
    gdsrWait("gdsr_mur_text_" + post_id + "_" + set_id, "gdsr_mur_loader_" + post_id + "_" + set_id);
    jQuery.getJSON('<?php echo STARRATING_AJAX; ?>', {<?php echo $nonce; ?>vote_id: post_id, vote_set: set_id, vote_value: values, vote_tpl: tpl_id, vote_type: 'm' }, function(json) {
        jQuery("#gdsr_mur_block_" + post_id + "_" + set_id + " .gdsr_multis_as").remove();
        jQuery("#gdsr_mur_block_" + post_id + "_" + set_id + " .gdcurrent").remove();
        jQuery("#gdsr_mur_block_" + post_id + "_" + set_id + " input").remove();
        jQuery("#gdsr_mur_block_" + post_id + "_" + set_id + " .ratingbutton").remove();
        var height = jQuery("#gdsr_mur_avgstars_" + post_id + "_" + set_id + " div").css("height");
        if (height > 0)
            jQuery("#gdsr_mur_avgstars_" + post_id + "_" + set_id + " div").css("width", json.average * height.substring(0, 2));
        for (var i = 0; i < json.values.length; i++)
            jQuery("#gdsr_mur_stars_rated_" + post_id + "_" + set_id + "_" + i).css("width", json.values[i]);
        jQuery("#gdsr_mur_text_" + post_id + "_" + set_id).html(json.rater).addClass("voted");
        gdsrWait("gdsr_mur_loader_" + post_id + "_" + set_id, "gdsr_mur_text_" + post_id + "_" + set_id);
    });
}
