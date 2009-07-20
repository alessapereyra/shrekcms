<?php

class GDSRRenderT2 {
    function get_template($template_id, $section) {
        include(STARRATING_PATH.'code/t2/gd-star-t2-templates.php');

        if (intval($template_id) == 0) {
            $t = GDSRDB::get_templates($section, true, true);
            $template_id = $t->template_id;
        }

        return new gdTemplateRender($template_id, $section);
    }

    function prepare_wbr($widget) {
        global $gdsr, $wpdb;

        $sql = GDSRX::get_totals_standard($widget);
        $data = $wpdb->get_row($sql);

        $data->max_rating = $gdsr->o["stars"];
        if ($data->votes == null) {
            $data->votes = 0;
            $data->voters = 0;
        }
        if ($data->votes > 0) {
            $data->rating = @number_format($data->votes / $data->voters, 1);
            $data->bayes_rating = $gdsr->bayesian_estimate($data->voters, $data->rating);
            $data->percentage = floor((100 / $data->max_rating) * $data->rating);
        }

        return $data;
    }

    function prepare_data_retrieve($widget, $min = 0) {
        global $wpdb;
        if ($widget["source"] == "standard")
            $sql = GDSRX::get_widget_standard($widget, $min);
        else
            $sql = GDSRX::get_widget_multis($widget, $min);
        return $wpdb->get_results($sql);
    }

    function prepare_wsr($widget, $template) {
        global $gdsr;
        $bayesian_calculated = !(strpos($template, "%BAYES_RATING%") === false);
        $t_rate = !(strpos($template, "%RATE_TREND%") === false);
        $t_vote = !(strpos($template, "%VOTE_TREND%") === false);
        $a_name = !(strpos($template, "%AUTHOR_NAME%") === false);
        $a_link = !(strpos($template, "%AUTHOR_LINK%") === false);

        if ($widget["column"] == "bayes" && !$bayesian_calculated) $widget["column"] == "rating";
        $all_rows = GDSRRenderT2::prepare_data_retrieve($widget, $gdsr->o["bayesian_minimal"]);

        if (count($all_rows) > 0) {
            $trends = array();
            $trends_calculated = false;
            if ($t_rate || $t_vote) {
                $idx = array();
                foreach ($all_rows as $row) {
                    switch ($widget["grouping"]) {
                        case "post":
                            $id = $row->post_id;
                            break;
                        case "category":
                            $id = $row->term_id;
                            break;
                        case "user":
                            $id = $row->id;
                            break;
                    }
                    $idx[] = $id;
                }
                $trends = GDSRX::get_trend_calculation(join(", ", $idx), $widget["grouping"], $widget['show'], $gdsr->o["trend_last"], $gdsr->o["trend_over"]);
                $trends_calculated = true;
            }

            $new_rows = array();
            foreach ($all_rows as $row) {
                if ($widget["image_from"] == "content") {
                    $row->image = gdFunctionsGDSR::get_image_from_text($row->post_content);
                }
                else if ($widget["image_from"] == "custom") {
                    $row->image = get_post_meta($row->post_id, $widget["image_custom"], true);
                }
                else $row->image = "";
                if ($widget['show'] == "total") {
                    $row->votes = $row->user_votes + $row->visitor_votes;
                    $row->voters = $row->user_voters + $row->visitor_voters;
                }
                if ($widget['show'] == "visitors") {
                    $row->votes = $row->visitor_votes;
                    $row->voters = $row->visitor_voters;
                }
                if ($widget['show'] == "users") {
                    $row->votes = $row->user_votes ;
                    $row->voters = $row->user_voters;
                }

                if ($row->voters == 0) $row->rating = 0;
                else $row->rating = @number_format($row->votes / $row->voters, 1);

                if ($bayesian_calculated)
                    $row->bayesian = $gdsr->bayesian_estimate($row->voters, $row->rating);
                else
                    $row->bayesian = -1;
                $new_rows[] = $row;
            }

            $tr_class = "odd";
            $set_rating = $set_voting = null;
            if ($trends_calculated) {
                $set_rating = $gdsr->g->find_trend($widget["trends_rating_set"]);
                $set_voting = $gdsr->g->find_trend($widget["trends_voting_set"]);
            }

            $all_rows = array();
            foreach ($new_rows as $row) {
                $row->table_row_class = $tr_class;
                if (strlen($row->title) > $widget["tpl_title_length"] - 3 && $widget["tpl_title_length"] > 0)
                    $row->title = substr($row->title, 0, $widget["tpl_title_length"] - 3)." ...";

                if ($a_link || $a_name && intval($row->author) > 0) {
                    $user = get_userdata($row->author);
                    $row->author_name = $user->display_name;
                    $row->author_url = get_bloginfo("url")."/author/".$user->user_login;
                }

                if ($trends_calculated) {
                    $empty = $gdsr->e;

                    switch ($widget["grouping"]) {
                        case "post":
                            $id = $row->post_id;
                            break;
                        case "category":
                            $id = $row->term_id;
                            break;
                        case "user":
                            $id = $row->id;
                            break;
                    }
                    $t = $trends[$id];
                    switch ($widget["trends_rating"]) {
                        case "img":
                            $rate_url = $set_rating->get_url();
                            $image_loc = "center";
                            switch ($t->trend_rating) {
                                case -1:
                                    $image_loc = "bottom";
                                    break;
                                case 0:
                                    $image_loc = "center";
                                    break;
                                case 1:
                                    $image_loc = "top";
                                    break;
                            }
                            $image_bg = sprintf('background: url(%s) %s no-repeat; height: %spx; width: %spx;', $rate_url, $image_loc, $set_rating->size, $set_rating->size);
                            $row->item_trend_rating = sprintf('<img class="trend" src="%s" style="%s" width="%s" height="%s"></img>', $gdsr->e, $image_bg, $set_rating->size, $set_rating->size);
                            break;
                        case "txt":
                            switch ($t->trend_rating) {
                                case -1:
                                    $row->item_trend_rating = $widget["trends_rating_fall"];
                                    break;
                                case 0:
                                    $row->item_trend_rating = $widget["trends_rating_same"];
                                    break;
                                case 1:
                                    $row->item_trend_rating = $widget["trends_rating_rise"];
                                    break;
                            }
                            break;
                    }
                    switch ($widget["trends_voting"]) {
                        case "img":
                            $vote_url = $set_voting->get_url();
                            $image_loc = "center";
                            switch ($t->trend_voting) {
                                case -1:
                                    $image_loc = "bottom";
                                    break;
                                case 0:
                                    $image_loc = "center";
                                    break;
                                case 1:
                                    $image_loc = "top";
                                    break;
                            }
                            $image_bg = sprintf('background: url(%s) %s no-repeat; height: %spx; width: %spx;', $vote_url, $image_loc, $set_voting->size, $set_voting->size);
                            $row->item_trend_voting = sprintf('<img class="trend" src="%s" style="%s" width="%s" height="%s"></img>', $gdsr->e, $image_bg, $set_voting->size, $set_voting->size);
                            break;
                        case "txt":
                            switch ($t->trend_voting) {
                                case -1:
                                    $row->item_trend_voting = $widget["trends_voting_fall"];
                                    break;
                                case 0:
                                    $row->item_trend_voting = $widget["trends_voting_same"];
                                    break;
                                case 1:
                                    $row->item_trend_voting = $widget["trends_voting_rise"];
                                    break;
                            }
                            break;
                    }
                }

                switch ($widget["grouping"]) {
                    case "post":
                        $row->permalink = get_permalink($row->post_id);
                        break;
                    case "category":
                        $row->permalink = get_category_link($row->term_id);
                        break;
                    case "user":
                        $row->permalink = get_bloginfo('url')."/index.php?author=".$row->id;
                        break;
                }

                if (!(strpos($template, "%STARS%") === false)) $row->rating_stars = GDSRRender::render_static_stars($widget['rating_stars'], $widget['rating_size'], $gdsr->o["stars"], $row->rating);
                if (!(strpos($template, "%BAYES_STARS%") === false) && $row->bayesian > -1) $row->bayesian_stars = GDSRRender::render_static_stars($widget['rating_stars'], $widget['rating_size'], $gdsr->o["stars"], $row->bayesian);
                if (!(strpos($template, "%REVIEW_STARS%") === false) && $row->review > -1) $row->review_stars = GDSRRender::render_static_stars($widget['rating_stars'], $widget['rating_size'], $gdsr->o["stars"], $row->review);

                if ($tr_class == "odd") $tr_class = "even";
                else $tr_class = "odd";

                $all_rows[] = $row;
            }
        }

        if ($widget["column"] == "votes") $widget["column"] = "voters";
        if ($widget["column"] == "post_title") $widget["column"] = "title";
        if ($widget["column"] == "count") $widget["column"] = "counter";
        if ($widget["column"] == "bayes") $widget["column"] = "bayesian";
        if ($widget["column"] == "id") $widget["column"] = "post_id";

        $properties = array();
        $properties[] = array("property" => $widget["column"], "order" => $widget["order"]);
        if ($widget["column"] == "rating")
            $properties[] = array("property" => "voters", "order" => $widget["order"]);
        $sort = new gdSortObjectsArray($all_rows, $properties);
        $all_rows = $sort->sorted;

        $all_rows = apply_filters('gdsr_widget_data_prepare', $all_rows);
        return $all_rows;
    }

    function prepare_wcr($widget, $template) {
        global $gdsr, $wpdb;

        $post_id = $gdsr->widget_post_id;
        $sql = GDSRX::get_widget_comments($widget, $post_id);
        $all_rows = $wpdb->get_results($sql);

        if (count($all_rows) > 0) {
            $new_rows = array();
            foreach ($all_rows as $row) {
                if ($widget['show'] == "total") {
                    $row->votes = $row->user_votes + $row->visitor_votes;
                    $row->voters = $row->user_voters + $row->visitor_voters;
                }
                if ($widget['show'] == "visitors") {
                    $row->votes = $row->visitor_votes;
                    $row->voters = $row->visitor_voters;
                }
                if ($widget['show'] == "users") {
                    $row->votes = $row->user_votes ;
                    $row->voters = $row->user_voters;
                }
                if ($row->voters == 0) $row->rating = 0;
                else $row->rating = @number_format($row->votes / $row->voters, 1);
                $new_rows[] = $row;
            }

            $tr_class = "odd";
            $all_rows = array();
            $pl = get_permalink($post_id);
            foreach ($new_rows as $row) {
                $row->table_row_class = $tr_class;
                $row->comment_content = strip_tags($row->comment_content);
                if (strlen($row->comment_content) > $widget["text_max"] - 3 && $widget["text_max"] > 0)
                    $row->comment_content = substr($row->comment_content, 0, $widget["text_max"] - 3)." ...";

                $row->comment_author_email = get_avatar($row->comment_author_email, $widget["avatar"]);

                if (!(strpos($template, "%CMM_STARS%") === false)) $row->rating_stars = GDSRRender::render_static_stars($widget['rating_stars'], $widget['rating_size'], $gdsr->o["cmm_stars"], $row->rating);
                $row->permalink = $pl."#comment-".$row->comment_id;

                if ($tr_class == "odd") $tr_class = "even";
                else $tr_class = "odd";

                $all_rows[] = $row;
            }
        }

        if ($widget["column"] == "votes") $widget["column"] = "voters";
        if ($widget["column"] == "id") $widget["column"] = "comment_id";

        $properties = array();
        $properties[] = array("property" => $widget["column"], "order" => $widget["order"]);
        if ($widget["column"] == "rating")
            $properties[] = array("property" => "voters", "order" => $widget["order"]);
        $sort = new gdSortObjectsArray($all_rows, $properties);
        $all_rows = $sort->sorted;

        $all_rows = apply_filters('gdsr_comments_widget_data_prepare', $all_rows);
        return $all_rows;
    }

    function render_mrb($style, $template_id, $allow_vote, $votes, $post_id, $set, $height, $header_text, $tags_css, $avg_style, $avg_size, $time_restirctions = "N", $time_remaining = 0, $time_date = "", $button_active = true, $button_text = "Submit", $debug = '', $wait_msg = '') {
        $template = GDSRRenderT2::get_template($template_id, "MRB");
        $tpl_render = $template->elm["normal"];
        $tpl_render = html_entity_decode($tpl_render);
        foreach ($tags_css as $tag => $value) $tpl_render = str_replace('%'.$tag.'%', $value, $tpl_render);
        $tpl_render = str_replace("%MUR_HEADER_TEXT%", html_entity_decode($header_text), $tpl_render);
        $rater = '<div id="gdsr_mur_block_'.$post_id.'_'.$set->multi_id.'" class="ratingmulti '.$tags_css["MUR_CSS_BLOCK"].'">';;

        $empty_value = str_repeat("0X", count($set->object));
        $empty_value = substr($empty_value, 0, strlen($empty_value) - 1);
        if ($debug != '') $rater.= '<div style="display: none">'.$debug.'</div>';
        if ($allow_vote) $rater.= '<input type="hidden" id="gdsr_multi_'.$post_id.'_'.$set->multi_id.'" name="gdsrmulti['.$post_id.']['.$set->id.']" value="'.$empty_value.'" />';

        $i = 0;
        $weighted = 0;
        $total_votes = 0;
        $weight_norm = array_sum($set->weight);
        $rating_stars = "";
        $table_row_class = $template->dep["MRS"]->dep["ETR"];
        foreach ($set->object as $el) {
            $single_row = html_entity_decode($template->dep["MRS"]->elm["item"]);
            $single_row = str_replace('%ELEMENT_NAME%', $el, $single_row);
            $single_row = str_replace('%ELEMENT_ID%', $i, $single_row);
            $single_row = str_replace('%ELEMENT_STARS%', GDSRRender::rating_stars_multi($style, $post_id, $template_id, $set->multi_id, $i, $height, $set->stars, $allow_vote, $votes[$i]["rating"]), $single_row);
            $single_row = str_replace('%TABLE_ROW_CLASS%', is_odd($i) ? $table_row_class->elm["odd"] : $table_row_class->elm["even"], $single_row);
            $rating_stars.= $single_row;

            $weighted += ($votes[$i]["rating"] * $set->weight[$i]) / $weight_norm;
            $total_votes += $votes[$i]["votes"];
            $i++;
        }
        $rating = @number_format($weighted, 1);
        $total_votes = @number_format($total_votes / $i, 0);
        if (in_array("%MUR_RATING_TEXT%", $template->tag["normal"])) {
            $rating_text = GDSRRenderT2::render_mrt($template->dep["MRT"], $rating, $set->stars, $total_votes, $post_id, $time_restirctions, $time_remaining, $time_date);
            if ($allow_vote) $rating_wait = GDSRRender::rating_wait("gdsr_mur_loader_".$post_id."_".$set->multi_id, "100%", "", $wait_msg);
            $rating_text = $rating_wait.'<div id="gdsr_mur_text_'.$post_id.'_'.$set->multi_id.'">'.$rating_text.'</div>';
            $tpl_render = str_replace("%MUR_RATING_TEXT%", $rating_text, $tpl_render);
        }

        if (in_array("%BUTTON%", $template->tag["normal"])) {
            if ($button_active) $rating_button = '<div class="ratingbutton gdinactive gdsr_multisbutton_as '.$tags_css["MUR_CSS_BUTTON"].'" id="gdsr_button_'.$post_id.'_'.$set->multi_id.'_'.$template_id.'"><a rel="nofollow">'.$button_text.'</a></div>';
            else $rating_button = "";

            $tpl_render = str_replace("%BUTTON%", $rating_button, $tpl_render);
        }

        $tpl_render = str_replace("%MUR_RATING_STARS%", $rating_stars, $tpl_render);
        $tpl_render = str_replace("%AVG_RATING%", $rating, $tpl_render);
        if (in_array("%AVG_RATING_STARS%", $template->tag["normal"])) {
            $avg_id = "gdsr_mur_avgstars_".$post_id."_".$set->multi_id;
            $tpl_render = str_replace("%AVG_RATING_STARS%", GDSRRender::render_static_stars($avg_style, $avg_size, $set->stars, $rating, $avg_id, "DIV"), $tpl_render);
        }
        $rater.= $tpl_render."</div>";
        return $rater;
    }

    function render_mre($style, $template_id, $allow_vote, $votes, $post_id, $set, $height) {
        $template = GDSRRenderT2::get_template($template_id, "MRE");
        $tpl_render = $template->elm["normal"];
        $tpl_render = html_entity_decode($tpl_render);
        $rater = '<div id="gdsr_mur_block_'.$post_id.'_'.$set->multi_id.'" class="ratingmulti gdsr-review-block">';

        $empty_value = str_repeat("0X", count($set->object));
        $empty_value = substr($empty_value, 0, strlen($empty_value) - 1);

        $original_value = "";
        foreach($votes as $vote) $original_value.= number_format($vote["rating"], 0)."X";
        $original_value = substr($original_value, 0, strlen($original_value) - 1);
        $rater.= '<input type="hidden" id="gdsr_mur_review_'.$post_id.'_'.$set->multi_id.'" name="gdsrmurreview['.$post_id.']['.$set->id.']" value="'.$original_value.'" />';
        $empty_value = $original_value;
        if ($allow_vote) $rater.= '<input type="hidden" id="gdsr_multi_'.$post_id.'_'.$set->multi_id.'" name="gdsrmulti['.$post_id.']['.$set->id.']" value="'.$empty_value.'" />';

        $i = 0;
        $weighted = 0;
        $total_votes = 0;
        $weight_norm = array_sum($set->weight);
        $rating_stars = "";
        $table_row_class = $template->dep["MRS"]->dep["ETR"];
        foreach ($set->object as $el) {
            $single_row = html_entity_decode($template->dep["MRS"]->elm["item"]);
            $single_row = str_replace('%ELEMENT_NAME%', $el, $single_row);
            $single_row = str_replace('%ELEMENT_ID%', $i, $single_row);
            $single_row = str_replace('%ELEMENT_STARS%', GDSRRender::rating_stars_multi($style, $post_id, $template_id, $set->multi_id, $i, $height, $set->stars, $allow_vote, $votes[$i]["rating"], "", true), $single_row);
            $single_row = str_replace('%TABLE_ROW_CLASS%', is_odd($i) ? $table_row_class->elm["odd"] : $table_row_class->elm["even"], $single_row);
            $rating_stars.= $single_row;

            $weighted += ($votes[$i]["rating"] * $set->weight[$i]) / $weight_norm;
            $total_votes += $votes[$i]["votes"];
            $i++;
        }

        $tpl_render = str_replace("%MUR_RATING_STARS%", $rating_stars, $tpl_render);
        $rater.= $tpl_render."</div>";
        return $rater;
    }

    function render_ssb($template_id, $post_id, $votes, $score, $unit_set, $unit_width, $unit_count, $header_text) {
        $template = GDSRRenderT2::get_template($template_id, "SSB");
        $tpl_render = $template->elm["normal"];
        $tpl_render = html_entity_decode($tpl_render);
        $tpl_render = str_replace("%HEADER_TEXT%", html_entity_decode($header_text), $tpl_render);

        $rating2 = $votes > 0 ? $score / $votes : 0;
        if ($rating2 > $unit_count) $rating2 = $unit_count;
        $rating = @number_format($rating2, 1);

        $rater_stars = '<img src="'.STARRATING_URL.sprintf("gfx.php?value=%s", $rating).'" />';

        $rt = str_replace('%RATING%', $rating, $tpl_render);
        $rt = str_replace('%MAX_RATING%', $unit_count, $rt);
        $rt = str_replace('%VOTES%', $votes, $rt);
        $rt = str_replace('%RATING_STARS%', $rater_stars, $rt);
        $rt = str_replace('%ID%', $post_id, $rt);

        $word_votes = $template->dep["EWV"];
        $tense = $votes == 1 ? $word_votes->elm["singular"] : $word_votes->elm["plural"];
        $rt = str_replace('%WORD_VOTES%', __($tense), $rt);

        return $rt;
    }

    function render_srb($template_id, $post_id, $class, $type, $votes, $score, $style, $unit_width, $unit_count, $allow_vote, $user_id, $typecls, $tags_css, $header_text, $debug = '', $wait_msg = '', $time_restirctions = "N", $time_remaining = 0, $time_date = '') {
        $template = GDSRRenderT2::get_template($template_id, "SRB");
        $tpl_render = $template->elm["normal"];
        $tpl_render = html_entity_decode($tpl_render);
        foreach ($tags_css as $tag => $value) $tpl_render = str_replace('%'.$tag.'%', $value, $tpl_render);
        $tpl_render = str_replace("%HEADER_TEXT%", html_entity_decode($header_text), $tpl_render);

        $rating2 = $votes > 0 ? $score / $votes : 0;
        if ($rating2 > $unit_count) $rating2 = $unit_count;
        $rating = @number_format($rating2, 1);

        $rating_width = $rating2 * $unit_width;
        $rater_length = $unit_width * $unit_count;
        $rater_id = $typecls."_rater_".$post_id;
        $loader_id = $typecls."_loader_".$post_id;

        if (in_array("%RATING_STARS%", $template->tag["normal"])) {
            $rating_stars = GDSRRender::rating_stars($style, $unit_width, $rater_id, $class, $rating_width, $allow_vote, $unit_count, $type, $post_id, $user_id, $loader_id, $rater_length, $typecls, $wait_msg, $template_id);
            $tpl_render = str_replace("%RATING_STARS%", $rating_stars, $tpl_render);
        }

        if (in_array("%RATING_TEXT%", $template->tag["normal"])) {
            $rating_text = GDSRRenderT2::render_srt($template->dep["SRT"], $rating, $unit_count, $votes, $post_id, $time_restirctions, $time_remaining, $time_date);
            $rating_text = '<div id="gdr_text_'.$type.$post_id.'">'.$rating_text.'</div>';
            $tpl_render = str_replace("%RATING_TEXT%", $rating_text, $tpl_render);
        }

        $tpl_render = '<div class="ratingblock">'.$tpl_render;
        if ($debug != '') $tpl_render = '<div style="display: none">'.$debug.'</div>'.$tpl_render;
        $tpl_render.= '</div>';

        return $tpl_render;
    }

    function render_crb($template_id, $cmm_id, $class, $type, $votes, $score, $style, $unit_width, $unit_count, $allow_vote, $user_id, $typecls, $tags_css, $header_text, $debug = '', $wait_msg = '') {
        $template = GDSRRenderT2::get_template($template_id, "CRB");
        $tpl_render = $template->elm["normal"];
        $tpl_render = html_entity_decode($tpl_render);
        foreach ($tags_css as $tag => $value) $tpl_render = str_replace('%'.$tag.'%', $value, $tpl_render);
        $tpl_render = str_replace("%CMM_HEADER_TEXT%", html_entity_decode($header_text), $tpl_render);

        $rating2 = $votes > 0 ? $score / $votes : 0;
        if ($rating2 > $unit_count) $rating2 = $unit_count;
        $rating = @number_format($rating2, 1);

        $rating_width = $rating2 * $unit_width;
        $rater_length = $unit_width * $unit_count;
        $rater_id = $typecls."_rater_".$cmm_id;
        $loader_id = $typecls."_loader_".$cmm_id;

        if (in_array("%CMM_RATING_STARS%", $template->tag["normal"])) {
            $rating_stars = GDSRRender::rating_stars($style, $unit_width, $rater_id, $class, $rating_width, $allow_vote, $unit_count, $type, $cmm_id, $user_id, $loader_id, $rater_length, $typecls, $wait_msg, $template_id);
            $tpl_render = str_replace("%CMM_RATING_STARS%", $rating_stars, $tpl_render);
        }

        if (in_array("%CMM_RATING_TEXT%", $template->tag["normal"])) {
            $rating_text = GDSRRenderT2::render_crt($template->dep["CRT"], $rating, $unit_count, $votes, $cmm_id);
            $rating_text = '<div id="gdr_text_'.$type.$cmm_id.'">'.$rating_text.'</div>';
            $tpl_render = str_replace("%CMM_RATING_TEXT%", $rating_text, $tpl_render);
        }

        $tpl_render = '<div class="ratingblock">'.$tpl_render;
        if ($debug != '') $tpl_render = '<div style="display: none">'.$debug.'</div>'.$tpl_render;
        $tpl_render.= '</div>';

        return $tpl_render;
    }

    function render_mrt($template, $rating, $unit_count, $votes, $id, $time_restirctions = "N", $time_remaining = 0, $time_date = '') {
        return GDSRRenderT2::render_srt($template, $rating, $unit_count, $votes, $id, $time_restirctions, $time_remaining, $time_date);
    }

    function render_srt($template, $rating, $unit_count, $votes, $id, $time_restirctions = "N", $time_remaining = 0, $time_date = '') {
        if (($time_restirctions == 'D' || $time_restirctions == 'T') && $time_remaining > 0) {
            $time_parts = GDSRHelper::remaining_time_parts($time_remaining);
            $time_total = GDSRHelper::remaining_time_total($time_remaining);
            $tpl = $template->elm["time_active"];
            $rt = html_entity_decode($tpl);
            $rt = str_replace('%TR_DATE%', $time_date, $rt);
            $rt = str_replace('%TR_YEARS%', $time_parts["year"], $rt);
            $rt = str_replace('%TR_MONTHS%', $time_parts["month"], $rt);
            $rt = str_replace('%TR_DAYS%', $time_parts["day"], $rt);
            $rt = str_replace('%TR_HOURS%', $time_parts["hour"], $rt);
            $rt = str_replace('%TR_MINUTES%', $time_parts["minute"], $rt);
            $rt = str_replace('%TR_SECONDS%', $time_parts["second"], $rt);
            $rt = str_replace('%TOT_DAYS%', $time_total["day"], $rt);
            $rt = str_replace('%TOT_HOURS%', $time_total["hour"], $rt);
            $rt = str_replace('%TOT_MINUTES%', $time_total["minute"], $rt);
        }
        else {
            if ($time_restirctions == 'D' || $time_restirctions == 'T')
                $tpl = $template->elm["time_closed"];
            else
                $tpl = $template->elm["normal"];
            $rt = html_entity_decode($tpl);
        }
        $rt = str_replace('%RATING%', $rating, $rt);
        $rt = str_replace('%MAX_RATING%', $unit_count, $rt);
        $rt = str_replace('%VOTES%', $votes, $rt);
        $rt = str_replace('%ID%', $id, $rt);

        $word_votes = $template->dep["EWV"];
        $tense = $votes == 1 ? $word_votes->elm["singular"] : $word_votes->elm["plural"];
        $rt = str_replace('%WORD_VOTES%', __($tense), $rt);

        return $rt;
    }

    function render_crt($template, $rating, $unit_count, $votes, $id) {
        $tpl = $template->elm["normal"];

        $rt = html_entity_decode($tpl);
        $rt = str_replace('%CMM_RATING%', $rating, $rt);
        $rt = str_replace('%MAX_CMM_RATING%', $unit_count, $rt);
        $rt = str_replace('%CMM_VOTES%', $votes, $rt);
        $rt = str_replace('%ID%', $id, $rt);

        $word_votes = $template->dep["EWV"];
        $tense = $votes == 1 ? $word_votes->elm["singular"] : $word_votes->elm["plural"];
        $rt = str_replace('%WORD_VOTES%', __($tense), $rt);

        return $rt;
    }

    function render_wsr($widget, $section = "WSR") {
        global $gdsr;
        $template = GDSRRenderT2::get_template($widget["template_id"], $section);
        $tpl_render = html_entity_decode($template->elm["header"]);
        $rt = html_entity_decode($template->elm["item"]);
        $all_rows = GDSRRenderT2::prepare_wsr($widget, $rt);

        if (count($all_rows) > 0) {
            foreach ($all_rows as $row) {
                $rt = html_entity_decode($template->elm["item"]);
                $title = $row->title;
                if (strlen($title) == 0) $title = __("(no title)", "gd-star-rating");

                $rt = str_replace('%RATING%', $row->rating, $rt);
                $rt = str_replace('%MAX_RATING%', $gdsr->o["stars"], $rt);
                $rt = str_replace('%VOTES%', $row->voters, $rt);
                $rt = str_replace('%REVIEW%', $row->review, $rt);
                $rt = str_replace('%MAX_REVIEW%', $gdsr->o["review_stars"], $rt);
                $rt = str_replace('%TITLE%', __($title), $rt);
                $rt = str_replace('%PERMALINK%', $row->permalink, $rt);
                $rt = str_replace('%ID%', $row->post_id, $rt);
                $rt = str_replace('%COUNT%', $row->counter, $rt);
                $rt = str_replace('%BAYES_RATING%', $row->bayesian, $rt);
                $rt = str_replace('%BAYES_STARS%', $row->bayesian_stars, $rt);
                $rt = str_replace('%STARS%', $row->rating_stars, $rt);
                $rt = str_replace('%REVIEW_STARS%', $row->review_stars, $rt);
                $rt = str_replace('%RATE_TREND%', $row->item_trend_rating, $rt);
                $rt = str_replace('%VOTE_TREND%', $row->item_trend_voting, $rt);
                $rt = str_replace('%IMAGE%', $row->image, $rt);
                $rt = str_replace('%AUTHOR_NAME%', $row->author_name, $rt);
                $rt = str_replace('%AUTHOR_LINK%', $row->author_url, $rt);

                $word_votes = $template->dep["EWV"];
                $tense = $row->voters == 1 ? $word_votes->elm["singular"] : $word_votes->elm["plural"];
                $rt = str_replace('%WORD_VOTES%', __($tense), $rt);

                $table_row = $template->dep["ETR"];
                $row_css = $row->table_row_class == "odd" ? $table_row->elm["odd"] : $table_row->elm["even"];
                $rt = str_replace('%TABLE_ROW_CLASS%', $row_css, $rt);

                $tpl_render.= $rt;
            }
        }

        $tpl_render.= html_entity_decode($template->elm["footer"]);

        return $tpl_render;
    }

    function render_wcr($widget) {
        global $gdsr;
        $template = GDSRRenderT2::get_template($widget["template_id"], "WCR");
        $tpl_render = html_entity_decode($template->elm["header"]);
        $rt = html_entity_decode($template->elm["item"]);
        $all_rows = GDSRRenderT2::prepare_wcr($widget, $rt);

        if (count($all_rows) > 0) {
            foreach ($all_rows as $row) {
                $rt = html_entity_decode($template->elm["item"]);
                $rt = str_replace('%CMM_RATING%', $row->rating, $rt);
                $rt = str_replace('%MAX_RATING%', $gdsr->o["cmm_stars"], $rt);
                $rt = str_replace('%CMM_VOTES%', $row->voters, $rt);
                $rt = str_replace('%COMMENT%', $row->comment_content, $rt);
                $rt = str_replace('%PERMALINK%', $row->permalink, $rt);
                $rt = str_replace('%AUTHOR_NAME%', $row->comment_author, $rt);
                $rt = str_replace('%AUTHOR_AVATAR%', $row->comment_author_email, $rt);
                $rt = str_replace('%AUTHOR_LINK%', $row->comment_author_url, $rt);
                $rt = str_replace('%ID%', $row->comment_id, $rt);
                $rt = str_replace('%POST_ID%', $post->ID, $rt);
                $rt = str_replace('%CMM_STARS%', $row->rating_stars, $rt);

                $word_votes = $template->dep["EWV"];
                $tense = $row->voters == 1 ? $word_votes->elm["singular"] : $word_votes->elm["plural"];
                $rt = str_replace('%WORD_VOTES%', __($tense), $rt);

                $table_row = $template->dep["ETR"];
                $row_css = $row->table_row_class == "odd" ? $table_row->elm["odd"] : $table_row->elm["even"];
                $rt = str_replace('%TABLE_ROW_CLASS%', $row_css, $rt);

                $tpl_render.= $rt;
            }
        }

        $tpl_render.= html_entity_decode($template->elm["footer"]);

        return $tpl_render;
    }

    function render_wbr($widget) {
        $template = GDSRRenderT2::get_template($widget["template_id"], "WBR");
        $tpl_render = $template->elm["normal"];
        $tpl_render = html_entity_decode($tpl_render);
        $data = GDSRRenderT2::prepare_wbr($widget);
        
        $rt = str_replace('%PERCENTAGE%', $data->percentage, $tpl_render);
        $rt = str_replace('%RATING%', $data->rating, $rt);
        $rt = str_replace('%MAX_RATING%', $data->max_rating, $rt);
        $rt = str_replace('%VOTES%', $data->voters, $rt);
        $rt = str_replace('%COUNT%', $data->count, $rt);
        $rt = str_replace('%BAYES_RATING%', $data->bayes_rating, $rt);

        $word_votes = $template->dep["EWV"];
        $tense = $data->voters == 1 ? $word_votes->elm["singular"] : $word_votes->elm["plural"];
        $rt = str_replace('%WORD_VOTES%', __($tense), $rt);

        return $rt;
    }

    function render_srr($widget) {
        return GDSRRenderT2::render_wsr($widget, "SRR");
    }

    function render_rsb($template_id, $rating, $star_style, $star_size, $star_max, $header_text, $css) {
        $template = GDSRRenderT2::get_template($template_id, "RSB");
        $tpl_render = $template->elm["normal"];
        $tpl_render = html_entity_decode($tpl_render);

        $tpl_render = str_replace("%HEADER_TEXT%", html_entity_decode($header_text), $tpl_render);
        $tpl_render = str_replace("%CSS_BLOCK%", $css, $tpl_render);
        $tpl_render = str_replace("%MAX_RATING%", $star_max, $tpl_render);
        $tpl_render = str_replace("%RATING%", $rating, $tpl_render);

        $rating_stars = GDSRRender::render_static_stars($star_style, $star_size, $star_max, $rating);
        $tpl_render = str_replace("%RATING_STARS%", $rating_stars, $tpl_render);

        return $tpl_render;
    }

    function render_rcb($template_id, $rating, $star_style, $star_size, $star_max) {
        $template = GDSRRenderT2::get_template($template_id, "RCB");
        $tpl_render = $template->elm["normal"];
        $tpl_render = html_entity_decode($tpl_render);

        $tpl_render = str_replace("%MAX_MM_RATING%", $star_max, $tpl_render);
        $tpl_render = str_replace("%CMM_RATING%", $rating, $tpl_render);

        $rating_stars = GDSRRender::render_static_stars($star_style, $star_size, $star_max, $rating);
        $tpl_render = str_replace("%CMM_RATING_STARS%", $rating_stars, $tpl_render);

        return $tpl_render;
    }

    function render_rmb($template_id, $votes, $post_id, $set, $avg_rating, $style, $size, $avg_style, $avg_size) {
        $template = GDSRRenderT2::get_template($template_id, "RMB");
        $tpl_render = $template->elm["normal"];
        $tpl_render = html_entity_decode($tpl_render);
        $rater = '<div id="gdsr_mureview_block_'.$post_id.'_'.$set->multi_id.'" class="ratingmulti gdsr-review-block">';

        $i = 0;
        $weighted = 0;
        $total_votes = 0;
        $weight_norm = array_sum($set->weight);
        $rating_stars = "";
        $table_row_class = $template->dep["MRS"]->dep["ETR"];
        foreach ($set->object as $el) {
            $single_row = html_entity_decode($template->dep["MRS"]->elm["item"]);
            $single_row = str_replace('%ELEMENT_NAME%', $el, $single_row);
            $single_row = str_replace('%ELEMENT_ID%', $i, $single_row);
            $single_row = str_replace('%ELEMENT_STARS%', GDSRRender::render_static_stars($style, $size, $set->stars, $votes[$i]["rating"]), $single_row);
            $single_row = str_replace('%TABLE_ROW_CLASS%', is_odd($i) ? $table_row_class->elm["odd"] : $table_row_class->elm["even"], $single_row);
            $rating_stars.= $single_row;

            $weighted += ($votes[$i]["rating"] * $set->weight[$i]) / $weight_norm;
            $total_votes += $votes[$i]["votes"];
            $i++;
        }

        $tpl_render = str_replace("%MUR_RATING_STARS%", $rating_stars, $tpl_render);
        $tpl_render = str_replace("%AVG_RATING%", $avg_rating, $tpl_render);
        $tpl_render = str_replace("%MAX_RATING%", $set->stars, $tpl_render);

        if (in_array("%AVG_RATING_STARS%", $template->tag["normal"]))
            $tpl_render = str_replace("%AVG_RATING_STARS%", GDSRRender::render_static_stars($avg_style, $avg_size, $set->stars, $avg_rating), $tpl_render);

        $rater.= $tpl_render."</div>";
        return $rater;
    }

    function render_car($template_id, $votes, $rating, $comments, $star_style, $star_size, $star_max) {
        $template = GDSRRenderT2::get_template($template_id, "CAR");
        $tpl_render = $template->elm["normal"];
        $tpl_render = html_entity_decode($tpl_render);

        $tpl_render = str_replace("%CMM_COUNT%", $comments, $tpl_render);
        $tpl_render = str_replace("%CMM_VOTES%", $votes, $tpl_render);
        $tpl_render = str_replace("%MAX_CMM_RATING%", $star_max, $tpl_render);
        $tpl_render = str_replace("%CMM_RATING%", $rating, $tpl_render);

        $word_votes = $template->dep["EWV"];
        $tense = $votes == 1 ? $word_votes->elm["singular"] : $word_votes->elm["plural"];
        $tpl_render = str_replace('%WORD_VOTES%', __($tense), $tpl_render);

        $rating_stars = GDSRRender::render_static_stars($star_style, $star_size, $star_max, $rating);
        $tpl_render = str_replace("%CMM_STARS%", $rating_stars, $tpl_render);

        return $tpl_render;
    }
}

?>