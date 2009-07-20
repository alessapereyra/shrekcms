function gdsrChangeShortcode() {
    var shortcode = document.getElementById("srShortcode").selectedIndex;
    document.getElementById("general_tab").style.display = "none";
    document.getElementById("filter_tab").style.display = "none";
    document.getElementById("styles_tab").style.display = "none";
    document.getElementById("multis_tab").style.display = "none";
    document.getElementById("multisreview_tab").style.display = "none";
    document.getElementById("articlesreview_tab").style.display = "none";
    document.getElementById("articlesrater_tab").style.display = "none";
    document.getElementById("commentsaggr_tab").style.display = "none";
    switch (shortcode) {
        case 0:
            document.getElementById("general_tab").style.display = "block";
            document.getElementById("filter_tab").style.display = "block";
            document.getElementById("styles_tab").style.display = "block";
            break;
        case 2:
            document.getElementById("multis_tab").style.display = "block";
            break;
        case 3:
            document.getElementById("multisreview_tab").style.display = "block";
            break;
        case 5:
            document.getElementById("articlesreview_tab").style.display = "block";
            break;
        case 6:
            document.getElementById("articlesrater_tab").style.display = "block";
            break;
        case 8:
            document.getElementById("commentsaggr_tab").style.display = "block";
            break;
    }
}

function gdsrChangeTrend(trend, el, index) {
    document.getElementById("gdsr-"+trend+"-txt["+index+"]").style.display = el == "txt" ? "block" : "none";
    document.getElementById("gdsr-"+trend+"-img["+index+"]").style.display = el == "img" ? "block" : "none";
}

function gdsrChangeSource(el, index) {
    document.getElementById("gdsr-src-multi["+index+"]").style.display = el == "multis" ? "block" : "none";
}

function gdsrChangeDate(el, index) {
    document.getElementById("gdsr-pd-lastd["+index+"]").style.display = el == "lastd" ? "block" : "none";
    document.getElementById("gdsr-pd-month["+index+"]").style.display = el == "month" ? "block" : "none";
    document.getElementById("gdsr-pd-range["+index+"]").style.display = el == "range" ? "block" : "none";
}

function gdsrChangeImage(el, index) {
    document.getElementById("gdsr-pi-none["+index+"]").style.display = el == "none" ? "block" : "none";
    document.getElementById("gdsr-pi-custom["+index+"]").style.display = el == "custom" ? "block" : "none";
    document.getElementById("gdsr-pi-content["+index+"]").style.display = el == "content" ? "block" : "none";
}

function init() {
	tinyMCEPopup.resizeToInnerSize();
}

function insertStarRatingCode() {
    var tagtext = "";
    var shortcode = document.getElementById('srShortcode').value;
    
    if (shortcode == 'starreview') {
        tagtext = "[starreview";
        tagtext = tagtext + " tpl=" + document.getElementById('srTemplateRSB').value;
        tagtext = tagtext + "]";
    }
    else if (shortcode == 'starcomments') {
        tagtext = "[starcomments";
        tagtext = tagtext + " tpl=" + document.getElementById('srTemplateCAR').value;
        if (document.getElementById('srCagShow').value != 'total')
            tagtext = tagtext + " show='" + document.getElementById('srCagShow').value + "'";
        tagtext = tagtext + "]";
    }
    else if (shortcode == 'starrater') {
        tagtext = "[starrater tpl=";
        tagtext = tagtext + document.getElementById('srRatingBlockTemplate').value;
        tagtext = tagtext + "]";
    }
    else if (shortcode == 'starreviewmulti') {
        tagtext = "[starreviewmulti id=";
        tagtext = tagtext + document.getElementById('srMultiRatingSet').value;
        tagtext = tagtext + " tpl=" + document.getElementById('srTemplateRMB').value;
        if (document.getElementById('srStarsStyleMRREl').value != 'oxygen')
            tagtext = tagtext + " element_stars='" + document.getElementById('srStarsStyleMRREl').value + "'";
        if (document.getElementById('srStarsSizeMRREl').value != '20')
            tagtext = tagtext + " element_size='" + document.getElementById('srStarsSizeMRREl').value + "'";
        if (document.getElementById('srStarsStyleMRRAv').value != 'oxygen')
            tagtext = tagtext + " average_stars='" + document.getElementById('srStarsStyleMRRAv').value + "'";
        if (document.getElementById('srStarsSizeMRRAv').value != '30')
            tagtext = tagtext + " average_size='" + document.getElementById('srStarsSizeMRRAv').value + "'";
        tagtext = tagtext + "]";
    }
    else if (shortcode == 'starratingmulti') {
        tagtext = '[starratingmulti id=';
        tagtext = tagtext + document.getElementById('srMultiRatingSet').value;
        tagtext = tagtext + " tpl=" + document.getElementById('srTemplateMRB').value;
        if (document.getElementById('srMultiRead').checked)
           tagtext = tagtext + " read_only=1";
        if (document.getElementById('srStarsStyleMURAv').value != 'oxygen')
            tagtext = tagtext + " average_stars='" + document.getElementById('srStarsStyleMURAv').value + "'";
        if (document.getElementById('srStarsSizeMURAv').value != '30')
            tagtext = tagtext + " average_size='" + document.getElementById('srStarsSizeMURAv').value + "'";
        tagtext = tagtext + "]";
    }
    else {
        tagtext = "[starrating";
        tagtext = tagtext + " template_id=" + document.getElementById('srTemplateSRR').value;
        if (document.getElementById('srRows').value != 10)
            tagtext = tagtext + " rows=" + document.getElementById('srRows').value;
        if (document.getElementById('srSelect').value != 'postpage')
            tagtext = tagtext + " select='" + document.getElementById('srSelect').value + "'";
        if (document.getElementById('srColumn').value != 'rating')
            tagtext = tagtext + " column='" + document.getElementById('srColumn').value + "'";
        if (document.getElementById('srOrder').value != 'desc')
            tagtext = tagtext + " order='" + document.getElementById('srOrder').value + "'";
        if (document.getElementById('srLastDate').value != 0)
            tagtext = tagtext + " last_voted_days=" + document.getElementById('srLastDate').value;
        if (document.getElementById('srCategory').value != '0')
            tagtext = tagtext + " category=" + document.getElementById('srCategory').value;
        if (document.getElementById('srGrouping').value != 'post')
            tagtext = tagtext + " grouping='" + document.getElementById('srGrouping').value + "'";
        if (document.getElementById('srShow').value != 'total')
            tagtext = tagtext + " show='" + document.getElementById('srShow').value + "'";

        if (document.getElementById('trendRating').value != 'txt') {
            tagtext = tagtext + " trends_rating='" + document.getElementById('trendRating').value + "'";
            if (document.getElementById('trendRatingSet').value != '+')
                tagtext = tagtext + " trends_rating_set='" + document.getElementById('trendRatingSet').value + "'";
        }
        else {
            if (document.getElementById('trendRatingRise').value != '+')
                tagtext = tagtext + " trends_rating_rise='" + document.getElementById('trendRatingRise').value + "'";
            if (document.getElementById('trendRatingSame').value != '=')
                tagtext = tagtext + " trends_rating_same='" + document.getElementById('trendRatingSame').value + "'";
            if (document.getElementById('trendRatingFall').value != '-')
                tagtext = tagtext + " trends_rating_fall='" + document.getElementById('trendRatingFall').value + "'";
        }

        if (document.getElementById('trendVoting').value != 'txt') {
            tagtext = tagtext + " trends_voting='" + document.getElementById('trendVoting').value + "'";
            if (document.getElementById('trendVotingSet').value != '+')
                tagtext = tagtext + " trends_voting_set='" + document.getElementById('trendVotingSet').value + "'";
        }
        else {
            if (document.getElementById('trendVotingRise').value != '+')
                tagtext = tagtext + " trends_voting_rise='" + document.getElementById('trendVotingRise').value + "'";
            if (document.getElementById('trendVotingSame').value != '=')
                tagtext = tagtext + " trends_voting_same='" + document.getElementById('trendVotingSame').value + "'";
            if (document.getElementById('trendVotingFall').value != '-')
                tagtext = tagtext + " trends_voting_fall='" + document.getElementById('trendVotingFall').value + "'";
        }

        if (!document.getElementById('srHidempty').checked)
           tagtext = tagtext + " hide_empty=0";
        if (document.getElementById('srHidemptyReview').checked)
           tagtext = tagtext + " hide_noreview=1";
        if (document.getElementById('srHidemptyBayes').checked)
           tagtext = tagtext + " bayesian_calculation=1";
        if (document.getElementById('srMinVotes').value != 5)
            tagtext = tagtext + " min_votes=" + document.getElementById('srMinVotes').value;

        if (document.getElementById('srDataSource').value != 'standard') {
            tagtext = tagtext + " source='" + document.getElementById('srDataSource').value + "'";
            tagtext = tagtext + " source_set=" + document.getElementById('srMultiSet').value;
        }

        if (document.getElementById('srImageFrom').value != 'none') {
            tagtext = tagtext + " image_from='" + document.getElementById('srImageFrom').value + "'";
            if (document.getElementById('srImageFrom').value == 'custom')
                tagtext = tagtext + " image_custom='" + document.getElementById('srImageCustom').value + "'";
        }

        if (document.getElementById('publishDate').value == 'lastd') {
            if (document.getElementById('publishDays').value > 0) {
                tagtext = tagtext + " publish_days=" + document.getElementById('publishDays').value;
            }
        }
        else if (document.getElementById('publishDate').value == 'month') {
            tagtext = tagtext + " publish_date='month'";
            tagtext = tagtext + " publish_month='" + document.getElementById('publishMonth').value + "'";
        }
        else {
            tagtext = tagtext + " publish_date='range'";
            tagtext = tagtext + " publish_range_from='" + document.getElementById('publishRangeFrom').value + "'";
            tagtext = tagtext + " publish_range_to='" + document.getElementById('publishRangeTo').value + "'";
        }

        if (document.getElementById('srStarsStyle').value != 'oxygen')
            tagtext = tagtext + " rating_stars='" + document.getElementById('srStarsStyle').value + "'";
        if (document.getElementById('srStarsSize').value != '20')
            tagtext = tagtext + " rating_size='" + document.getElementById('srStarsSize').value + "'";

        if (document.getElementById('srReviewStarsStyle').value != 'oxygen')
            tagtext = tagtext + " review_stars='" + document.getElementById('srReviewStarsStyle').value + "'";
        if (document.getElementById('srReviewStarsSize').value != '20')
            tagtext = tagtext + " review_size='" + document.getElementById('srReviewStarsSize').value + "'";

        tagtext = tagtext + "]";
	}

	if (window.tinyMCE) {
		window.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, tagtext);
		tinyMCEPopup.editor.execCommand('mceRepaint');
		tinyMCEPopup.close();
	}
	return;
}
