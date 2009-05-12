<?php

class GDSRRender {
    function rating_stars_new($style, $unit_width, $rater_id, $class, $rating_width, $allow_vote, $unit_count, $type, $id, $user_id, $loader_id, $rater_length, $typecls, $wait_msg = '', $template_id = 0) {
        $css_style = " gdsr-".$style;
        $css_sizes = " gdsr-size-".$unit_width;
        $rater = '<div id="'.$rater_id.'" class="'.$class.$css_style.$css_sizes.'"><div class="starsbar'.$css_sizes.'">';
        $rater.= '<div class="gdouter" align="left"><div id="gdr_vote_'.$type.$id.'" style="width: '.$rating_width.'px;" class="gdinner"></div>';
        if ($allow_vote) {
            $rater.= '<div id="gdr_stars_'.$type.$id.'" class="gdsr_rating_as">';
            for ($ic = 0; $ic < $unit_count; $ic++) {
                $ncount = $unit_count - $ic;
                $url = $_SERVER['REQUEST_URI'];
                $url_pos = strpos($url, "?");
                if ($url_pos === false) $first_char = '?';
                else $first_char = '&amp;';
                $ajax_id = sprintf("gdsrX%sX%sX%sX%sX%sX%sX%s", $id, $ncount, $user_id, $type, $rater_id, $loader_id, $template_id);
                $rater.='<a id="'.$ajax_id.'" title="'.$ncount.' / '.$unit_count.'" class="s'.$ncount.'" rel="nofollow"></a>';
            }
            $rater.= '</div>';
        }
        $rater.= '</div></div></div>';
        if ($allow_vote) $rater.= GDSRRender::rating_wait($loader_id, $rater_length."px", $typecls, $wait_msg);
        return $rater;
    }

    function rating_wait($loader_id, $rater_length, $typecls, $wait_msg = '') {
        $loader = '<div id="'.$loader_id.'" style="display: none; width:'.$rater_length.';" class="ratingloader '.$typecls.'">';
        $loader.= $wait_msg;
        $loader.= '</div>';
        return $loader;
    }

    function render_static_stars($star_style, $star_size, $star_max, $rating, $id = "", $rendering = "") {
        if ($rendering == "") $rendering = STARRATING_STARS_GENERATOR;
        switch ($rendering) {
            case "GFX":
                return GDSRRender::render_static_stars_gfx($star_style, $star_size, $star_max, $rating, $id);
                break;
            default:
            case "DIV":
                return GDSRRender::render_static_stars_div($star_style, $star_size, $star_max, $rating, $id);
                break;
        }
    }

    function render_static_stars_div($star_style, $star_size, $star_max, $rating, $id = "") {
        global $gdsr;

        $gfx = $gdsr->g->find_stars($star_style);
        $star_path = $gfx->get_url($star_size);
        $full_width = $star_size * $star_max;
        $rate_width = $star_size * $rating;
        
        return sprintf('<div%s style="%s"><div style="%s"></div></div>',
            $id == "" ? '' : ' id="'.$id.'"',
            sprintf('text-align:left; padding: 0; margin: 0; background: url(%s); height: %spx; width: %spx;', $star_path, $star_size, $full_width),
            sprintf('background: url(%s) bottom left; padding: 0; margin: 0; height: %spx; width: %spx;', $star_path, $star_size, $rate_width)
        );
    }

    function render_static_stars_gfx($star_style, $star_size, $star_max, $rating, $id = "") {
        $url = STARRATING_URL.sprintf("gfx.php?value=%s&set=%s&size=%s&max=%s", $rating, $star_style, $star_size, $star_max);
        return sprintf('<img%s src="%s" />', $id == "" ? '' : ' id="'.$id.'"', $url);
    }

    function rating_stars_multi_new($style, $post_id, $tpl_id, $set_id, $id, $height, $unit_count, $allow_vote = true, $value = 0, $xtra_cls = '', $review_mode = false) {
        $css_style = " gdsr-".$style;
        $css_sizes = " gdsr-size-".$height;
        if ($review_mode) $current = $value;
        else $current = 0;
        $rater.= '<div id="gdsr_mur_stars_'.$post_id.'_'.$set_id.'_'.$id.'" class="ratemulti'.$css_style.$css_sizes.'"><div class="starsbar'.$css_sizes.'">';
        $rater.= '<div class="gdouter" align="left" style="width: '.($unit_count * $height).'px">';
        $rater.= '<div id="gdsr_mur_stars_rated_'.$post_id.'_'.$set_id.'_'.$id.'" style="width: '.($value * $height).'px;" class="gdinner"></div>';
        if ($allow_vote) {
            $rater.= '<div id="gdsr_mur_stars_current_'.$post_id.'_'.$set_id.'_'.$id.'" style="width: '.($current * $height).'px;" class="gdcurrent"></div>';
            $rater.= '<div id="gdr_stars_mur_rating_'.$post_id.'_'.$set_id.'_'.$id.'" class="gdsr_multis_as">';
            for ($ic = 0; $ic < $unit_count; $ic++) {
                $ncount = $unit_count - $ic;
                $rater.='<a id="gdsrX'.$post_id.'X'.$set_id.'X'.$id.'X'.$ncount.'X'.$height.'X'.$tpl_id.'" title="'.$ncount.' / '.$unit_count.'" class="s'.$ncount.' '.$xtra_cls.'" rel="nofollow"></a>';
            }
            $rater.= '</div>';
        }
        $rater.= '</div></div></div>';
        return $rater;
    }

    function rating_stars_local($height, $unit_count, $allow_vote = true, $value = 0, $xtra_cls = '') {
        $rater = '<input type="hidden" id="gdsr_cmm_review" name="gdsr_cmm_review" value="0" />';
        $rater.= '<div id="gdsr_cmm_stars" class="reviewcmm"><div class="starsbar">';
        $rater.= '<div class="gdouter" align="left"><div id="gdsr_cmm_stars_rated" style="width: '.$value.'px;" class="gdinner"></div>';
        if ($allow_vote) {
            $rater.= '<div id="gdr_stars_cmm_review" class="gdsr_review_as">';
            for ($ic = 0; $ic < $unit_count; $ic++) {
                $ncount = $unit_count - $ic;
                $rater.='<a id="gdsrX'.$ncount.'X'.$height.'" title="'.$ncount.' out of '.$unit_count.'" class="s'.$ncount.' '.$xtra_cls.'" rel="nofollow"></a>';
            }
            $rater.= '</div>';
        }
        $rater.= '</div></div></div>';
        return $rater;
    }

    function rating_stars($style, $unit_width, $rater_id, $class, $rating_width, $allow_vote, $unit_count, $type, $id, $user_id, $loader_id, $rater_length, $typecls, $wait_msg = '', $template_id = 0) {
        $rater = '<div id="'.$rater_id.'" class="'.$class.'"><div class="starsbar">';
        $rater.= '<div class="gdouter" align="left"><div id="gdr_vote_'.$type.$id.'" style="width: '.$rating_width.'px;" class="gdinner"></div>';
        if ($allow_vote) {
            $rater.= '<div id="gdr_stars_'.$type.$id.'" class="gdsr_rating_as">';
            for ($ic = 0; $ic < $unit_count; $ic++) {
                $ncount = $unit_count - $ic;
                $url = $_SERVER['REQUEST_URI'];
                $url_pos = strpos($url, "?");
                if ($url_pos === false) $first_char = '?';
                else $first_char = '&amp;';
                $ajax_id = sprintf("gdsrX%sX%sX%sX%sX%sX%sX%s", $id, $ncount, $user_id, $type, $rater_id, $loader_id, $template_id);
                $rater.='<a id="'.$ajax_id.'" title="'.$ncount.' / '.$unit_count.'" class="s'.$ncount.'" rel="nofollow"></a>';
            }
            $rater.= '</div>';
        }
        $rater.= '</div></div></div>';
        if ($allow_vote) $rater.= GDSRRender::rating_wait($loader_id, $rater_length."px", $typecls, $wait_msg);
        return $rater;
    }

    function rating_stars_multi($style, $post_id, $tpl_id, $set_id, $id, $height, $unit_count, $allow_vote = true, $value = 0, $xtra_cls = '', $review_mode = false) {
        if ($review_mode) $current = $value;
        else $current = 0;
        $rater.= '<div id="gdsr_mur_stars_'.$post_id.'_'.$set_id.'_'.$id.'" class="ratemulti"><div class="starsbar">';
        $rater.= '<div class="gdouter" align="left" style="width: '.($unit_count * $height).'px">';
        $rater.= '<div id="gdsr_mur_stars_rated_'.$post_id.'_'.$set_id.'_'.$id.'" style="width: '.($value * $height).'px;" class="gdinner"></div>';
        if ($allow_vote) {
            $rater.= '<div id="gdsr_mur_stars_current_'.$post_id.'_'.$set_id.'_'.$id.'" style="width: '.($current * $height).'px;" class="gdcurrent"></div>';
            $rater.= '<div id="gdr_stars_mur_rating_'.$post_id.'_'.$set_id.'_'.$id.'" class="gdsr_multis_as">';
            for ($ic = 0; $ic < $unit_count; $ic++) {
                $ncount = $unit_count - $ic;
                $rater.='<a id="gdsrX'.$post_id.'X'.$set_id.'X'.$id.'X'.$ncount.'X'.$height.'X'.$tpl_id.'" title="'.$ncount.' / '.$unit_count.'" class="s'.$ncount.' '.$xtra_cls.'" rel="nofollow"></a>';
            }
            $rater.= '</div>';
        }
        $rater.= '</div></div></div>';
        return $rater;
    }

}

?>