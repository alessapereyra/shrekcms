    if (jQuery.browser.msie) jQuery(".gdsr_review_as > a").attr("href", "javascript:gdsrEmpty()");
    jQuery(".gdsr_review_as > a").click(function() {
        var el = jQuery(this).attr("id").split("X");
        var vote = el[1];
        var size = el[2];
        var new_width = vote * size;
        jQuery("#gdsr_cmm_stars_rated").css("width", new_width + "px");
        jQuery("#gdsr_cmm_review").val(vote);
    });
