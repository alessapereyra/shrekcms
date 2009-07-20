    if (jQuery.browser.msie) jQuery(".gdsr_multisbutton_as > a").attr("href", "javascript:gdsrEmpty()");
<?php if ($button_active) { ?>
    jQuery(".gdsr_multisbutton_as > a").click(function() {
        if (jQuery(this).hasClass("active")) {
            block = jQuery(this).parent().attr("id").substring(12);
            multi_rating_vote(block);
        }
    });
<?php } ?>

    if (jQuery.browser.msie) jQuery(".gdsr_multis_as > a").attr("href", "javascript:gdsrEmpty()");
    jQuery(".gdsr_multis_as > a").click(function() {
        var el = jQuery(this).attr("id").split("X");
        var vote = el[4];
        var size = el[5];
        var new_width = vote * size;
        var current_id = '#gdsr_mur_stars_current_' + el[1] + '_' + el[2] + '_' + el[3];
        var input_id = '#gdsr_multi_' + el[1] + '_' + el[2];
        jQuery(current_id).css("width", new_width + "px");
        var rating_values = jQuery(input_id).val().split("X");
        rating_values[el[3]] = vote;
        var active = true;
        for (var i = 0; i < rating_values.length; i++) {
            if (rating_values[i] == 0) {
                active = false;
                break;
            }
        }
        jQuery(input_id).val(rating_values.join("X"));
        var button_block = el[1] + '_' + el[2] + '_' + el[6];
<?php if ($button_active) { ?>
        var button_id = '#gdsr_button_' + button_block;
        if (active) {
            jQuery(button_id).removeClass('gdinactive');
            jQuery(button_id).addClass('gdactive');
            jQuery(button_id + " a").addClass('active');
        }
        else {
            jQuery(button_id).removeClass('gdactive');
            jQuery(button_id).addClass('gdinactive');
            jQuery(button_id + " a").removeClass('active');
        }
<?php } else { ?>
        if (active) multi_rating_vote(button_block);
<?php } ?>
    });
