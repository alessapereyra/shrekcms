<?php

/*
Plugin Name: GD Star Rating
Plugin URI: http://www.gdstarrating.com/
Description: Star Rating plugin allows you to set up advanced rating and review system for posts, pages and comments in your blog using single and multi ratings.
Version: 1.3.1
Author: Milan Petrovic
Author URI: http://www.dev4press.com/

== Copyright ==

Copyright 2008-2009 Milan Petrovic (email: milan@gdragon.info)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

require_once(dirname(__FILE__)."/gd-star-config.php");
require_once(dirname(__FILE__)."/code/t2/gd-star-t2-classes.php");
require_once(dirname(__FILE__)."/code/gd-star-defaults.php");
require_once(dirname(__FILE__)."/code/gd-star-classes.php");
require_once(dirname(__FILE__)."/code/gd-star-functions.php");
require_once(dirname(__FILE__)."/code/gd-star-render.php");
require_once(dirname(__FILE__)."/code/gd-star-dbone.php");
require_once(dirname(__FILE__)."/code/gd-star-dbtwo.php");
require_once(dirname(__FILE__)."/code/gd-star-dbx.php");
require_once(dirname(__FILE__)."/code/gd-star-dbmulti.php");
require_once(dirname(__FILE__)."/code/gd-star-import.php");
require_once(dirname(__FILE__)."/code/gfx/gd-star-chart.php");
require_once(dirname(__FILE__)."/code/gfx/gd-star-gfx.php");
require_once(dirname(__FILE__)."/code/gfx/gd-star-generator.php");
require_once(dirname(__FILE__)."/code/gd-star-render-t2.php");
require_once(dirname(__FILE__)."/code/gd-star-widgets.php");
require_once(dirname(__FILE__)."/code/gd-star-widgets_wp28.php");
require_once(dirname(__FILE__)."/gdragon/gd_functions.php");
require_once(dirname(__FILE__)."/gdragon/gd_debug.php");
require_once(dirname(__FILE__)."/gdragon/gd_db_install.php");
require_once(dirname(__FILE__)."/gdragon/gd_wordpress.php");

if (!class_exists('GDStarRating')) {
    /**
    * Main plugin class
    */
    class GDStarRating {
        var $is_bot = false;
        var $is_ban = false;
        var $is_ie6 = false;
        var $use_nonce = true;
        var $extra_folders = false;
        var $safe_mode = false;
        var $is_cached = false;
        var $widget_post_id;

        var $loader_article = "";
        var $loader_comment = "";
        var $loader_multis = "";
        var $wpr8_available = false;
        var $admin_plugin = false;
        var $admin_plugin_page = '';
        var $admin_page;
        var $widgets;

        var $active_wp_page;
        var $wp_version;
        var $vote_status;
        var $rendering_sets;

        var $plugin_url;
        var $plugin_ajax;
        var $plugin_path;
        var $plugin_xtra_url;
        var $plugin_xtra_path;
        var $plugin_chart_url;
        var $plugin_chart_path;
        var $plugin_cache_path;
        var $plugin_wpr8_path;

        var $l; // language
        var $o; // options
        var $w; // widget options
        var $t; // database tables
        var $p; // post data
        var $e; // blank image
        var $i; // import
        var $g; // gfx

        var $wpr8;

        var $post_comment;

        var $shortcodes;
        var $default_shortcode_starrating;
        var $default_shortcode_starratercustom;
        var $default_shortcode_starratingmulti;
        var $default_shortcode_starreviewmulti;
        var $default_shortcode_starcomments;
        var $default_shortcode_starrater;
        var $default_shortcode_starreview;
        var $default_options;
        var $default_import;
        var $default_widget_comments;
        var $default_widget_top;
        var $default_widget;
        var $default_spiders;
        var $default_wpr8;

        /**
        * Constructor method
        */
        function GDStarRating() {
            $gdd = new GDSRDefaults();
            $this->shortcodes = $gdd->shortcodes;
            $this->default_spiders = $gdd->default_spiders;
            $this->default_wpr8 = $gdd->default_wpr8;
            $this->default_shortcode_starrating = $gdd->default_shortcode_starrating;
            $this->default_shortcode_starratercustom = $gdd->default_shortcode_starratercustom;
            $this->default_shortcode_starratingmulti = $gdd->default_shortcode_starratingmulti;
            $this->default_shortcode_starreviewmulti = $gdd->default_shortcode_starreviewmulti;
            $this->default_shortcode_starcomments = $gdd->default_shortcode_starcomments;
            $this->default_shortcode_starrater = $gdd->default_shortcode_starrater;
            $this->default_shortcode_starreview = $gdd->default_shortcode_starreview;
            $this->default_options = $gdd->default_options;
            $this->default_import = $gdd->default_import;
            $this->default_widget_comments = $gdd->default_widget_comments;
            $this->default_widget_top = $gdd->default_widget_top;
            $this->default_widget = $gdd->default_widget;
            define('STARRATING_INSTALLED', $this->default_options["version"]." ".$this->default_options["status"]);

            $this->tabpage = "front";
            $this->log_file = STARRATING_LOG_PATH;
            $this->active_wp_page();
            $this->plugin_path_url();
            $this->install_plugin();
            $this->actions_filters();
        }

        // shortcodes
        /**
        * Adds new button to tinyMCE editor toolbar
        *
        * @param mixed $buttons
        */
        function add_tinymce_button($buttons) {
            array_push($buttons, "separator", "StarRating");
            return $buttons;
        }

        /**
        * Adds plugin to tinyMCE editor
        *
        * @param mixed $plugin_array
        */
        function add_tinymce_plugin($plugin_array) {
            $plugin_array['StarRating'] = $this->plugin_url.'tinymce3/plugin.js';
            return $plugin_array;
        }

        /**
        * Adds shortcodes into WordPress instance
        *
        * @param string|array $scode one or more shortcode names
        */
        function shortcode_action($scode) {
            $sc_name = $scode;
            $sc_method = "shortcode_".$scode;
            if (is_array($scode)) {
                $sc_name = $scode["name"];
                $sc_method = $scode["method"];
            }
            add_shortcode(strtolower($sc_name), array(&$this, $sc_method));
            add_shortcode(strtoupper($sc_name), array(&$this, $sc_method));
        }

        /**
        * Code for StarRater shortcode implementation
        *
        * @param array $atts
        */
		function shortcode_starrater($atts = array()) {
            return $this->shortcode_starratingblock($atts);
		}

        /**
        * Code for StarRatingBlock shortcode implementation
        *
        * @param array $atts
        */
        function shortcode_starratingblock($atts = array()) {
            global $post, $userdata;
            $override = shortcode_atts($this->default_shortcode_starrater, $atts);
            return $this->render_article($post, $userdata, $override);
        }

        /**
        * Code for StarRating shortcode implementation
        *
        * @param array $atts
        */
        function shortcode_starrating($atts = array()) {
            $sett = shortcode_atts($this->default_shortcode_starrating, $atts);
            return GDSRRenderT2::render_srr($sett);
        }

        /**
        * Code for StarComments shortcode implementation
        *
        * @param array $atts
        */
        function shortcode_starcomments($atts = array()) {
            $rating = "";
            $sett = shortcode_atts($this->default_shortcode_starcomments, $atts);
            if ($sett["post"] == 0) {
                global $post;
                $sett["post"] = $post->ID;
                $sett["comments"] = $post->comment_count;
            } else {
                $post = get_post($sett["post"]);
                $sett["comments"] = $post->comment_count;
            }
            if ($post->ID > 0) {
                $rows = GDSRDatabase::get_comments_aggregation($sett["post"], $sett["show"]);
                $totel_comments = count($rows);
                $total_voters = 0;
                $total_votes = 0;
                $calc_rating = 0;
                foreach ($rows as $row) {
                    switch ($sett["show"]) {
                        default:
                        case "total":
                            $total_voters += $row->user_voters + $row->visitor_voters;
                            $total_votes += $row->user_votes + $row->visitor_votes;
                            break;
                        case "users":
                            $total_voters += $row->user_voters;
                            $total_votes += $row->user_votes;
                            break;
                        case "visitors":
                            $total_voters += $row->visitor_voters;
                            $total_votes += $row->visitor_votes;
                            break;
                    }
                }
                if ($total_voters > 0) $calc_rating = $total_votes / $total_voters;
                $calc_rating = number_format($calc_rating, 1);
                $rating = GDSRRenderT2::render_car($sett["tpl"], $total_voters, $calc_rating, $sett["comments"], ($this->is_ie6 ? $this->o["cmm_aggr_style_ie6"] : $this->o["cmm_aggr_style"]), $this->o['cmm_aggr_size'], $this->o["cmm_stars"]);
            }
            return $rating;
        }

        /**
        * Code for StarReview shortcode implementation
        *
        * @param array $atts
        */
        function shortcode_starreview($atts = array()) {
            $sett = shortcode_atts($this->default_shortcode_starreview, $atts);
            if ($sett["post"] == 0) {
                global $post;
                $sett["post"] = $post->ID;
            }

            $rating = GDSRDatabase::get_review($sett["post"]);
            if ($rating < 0) $rating = 0;
            return GDSRRenderT2::render_rsb($sett["tpl"], $rating, ($this->is_ie6 ? $this->o["review_style_ie6"] : $this->o["review_style"]), $this->o['review_size'], $this->o["review_stars"], $this->o["review_header_text"], $this->o["review_class_block"]);
		}

        /**
        * Code for StarReviewMulti shortcode implementation
        *
        * @param array $atts
        */
        function shortcode_starreviewmulti($atts = array()) {
            global $post;
            $settings = shortcode_atts($this->default_shortcode_starreviewmulti, $atts);

            $post_id = $post->ID;
            if ($settings["id"] == 0) $multi_id = $this->o["mur_review_set"];
            else $multi_id = $settings["id"];
            $set = gd_get_multi_set($multi_id);
            if ($multi_id > 0 && $post_id > 0) {
                $vote_id = GDSRDBMulti::get_vote($post_id, $multi_id, count($set->object));
                $multi_data = GDSRDBMulti::get_values($vote_id, 'rvw');
                $votes = array();
                foreach ($multi_data as $md) {
                    $single_vote = array();
                    $single_vote["votes"] = 1;
                    $single_vote["score"] = $md->user_votes;
                    $single_vote["rating"] = $md->user_votes;
                    $votes[] = $single_vote;
                }
                $avg_rating = GDSRDBMulti::get_multi_review_average($vote_id);
                return GDSRRenderT2::render_rmb($settings["tpl"], $votes, $post_id, $set, $avg_rating, $settings["element_stars"], $settings["element_size"], $settings["average_stars"], $settings["average_size"]);
            }
            else return '';
        }

        /**
        * Code for StarRatingMulti shortcode implementation
        *
        * @param array $atts
        */
        function shortcode_starratingmulti($atts = array()) {
            if ($this->o["multis_active"] == 1) {
                global $post, $userdata;
                $settings = shortcode_atts($this->default_shortcode_starratingmulti, $atts);
                return $this->render_multi_rating($post, $userdata, $settings);
            }
            else return '';
        }
        // shortcodes

        // various rendering
        /**
        * Renders comment review stars
        *
        * @param int $value initial rating value
        * @param bool $allow_vote render stars to support rendering or not to
        */
        function comment_review($value = 0, $allow_vote = true) {
            $stars = $this->o["cmm_review_stars"];
            $size = $this->o["cmm_review_size"];
            return GDSRRender::rating_stars_local($size, $stars, $allow_vote, $value * $size);
        }

        /**
         * Renders comment review stars for selected comment
         *
         * @param int $comment_id id of the comment you want displayed
         * @param bool $zero_render if set to false and $value is 0 then nothing will be rendered
         * @param bool $use_default rendering is using default rendering settings
         * @param string $style folder name of the stars set to use
         * @param int $size stars size 12, 20, 30, 46
         * @return string rendered stars for comment review
         */
        function display_comment_review($comment_id, $use_default = true, $style = "oxygen", $size = 20) {
            if ($use_default) {
                $style = ($this->is_ie6 ? $this->o["cmm_review_style_ie6"] : $this->o["cmm_review_style"]);
                $size = $this->o["cmm_review_size"];
            }
            $stars = $this->o["cmm_review_stars"];
            $review = GDSRDatabase::get_comment_review($comment_id);
            if ($review < 0) $review = 0;

            return GDSRRender::render_static_stars($style, $size, $stars, $review);
        }

        /**
         * Renders post review stars for selected post
         *
         * @param int $post_id id for the post you want review displayed
         * @param bool $zero_render if set to false and $value is 0 then nothing will be rendered
         * @param bool $use_default rendering is using default rendering settings
         * @param string $style folder name of the stars set to use
         * @param int $size stars size 12, 20, 30, 46
         * @return string rendered stars for article review
         */
        function display_article_review($post_id, $use_default = true, $style = "oxygen", $size = 20) {
            if ($use_default) {
                $style = ($this->is_ie6 ? $this->o["review_style_ie6"] : $this->o["review_style"]);
                $size = $this->o["review_size"];
            }
            $stars = $this->o["review_stars"];
            $review = GDSRDatabase::get_review($post_id);
            if ($review < 0) $review = 0;

            return GDSRRender::render_static_stars($style, $size, $stars, $review);
        }

        /**
         * Renders post rating stars for selected post
         *
         * @param int $post_id id for the post you want rating displayed
         * @param bool $zero_render if set to false and $value is 0 then nothing will be rendered
         * @param bool $use_default rendering is using default rendering settings
         * @param string $style folder name of the stars set to use
         * @param int $size stars size 12, 20, 30, 46
         * @return string rendered stars for article rating
         */
        function display_article_rating($post_id, $use_default = true, $style = "oxygen", $size = 20) {
            if ($use_default) {
                $style = ($this->is_ie6 ? $this->o["style_ie6"] : $this->o["style"]);
                $size = $this->o["size"];
            }
            $stars = $this->o["stars"];
            list($votes, $score) = $this->get_article_rating($post_id);
            if ($votes > 0) $rating = $score / $votes;
            else $rating = 0;
            $rating = @number_format($rating, 1);

            return GDSRRender::render_static_stars($style, $size, $stars, $rating);
        }

        /**
         * Renders single rating stars image with average rating for the multi rating post results from rating or review.
         *
         * @param int $post_id id of the post rating will be attributed to
         * @param bool $review if set to true average of review will be rendered
         * @param array $settings override settings for rendering the block
         */
        function get_multi_average_rendered($post_id, $settings = array()) {
            if ($settings["id"] == "") $multi_id = $this->o["mur_review_set"];
            else $multi_id = $settings["id"];
            if ($multi_id > 0 && $post_id > 0) {
                $set = gd_get_multi_set($multi_id);
                $data = GDSRDBMulti::get_averages($post_id, $multi_id);
                if ($set != null) {
                    if ($settings["render"] == "review") {
                        $review = GDSRRender::render_static_stars(($this->is_ie6 ? $this->o["mur_style_ie6"] : $this->o["mur_style"]), $this->o['mur_size'], $set->stars, $data->average_review);
                        return $review;
                    }
                    else {
                        switch ($settings["show"]) {
                            case "visitors":
                                $rating = $data->average_rating_visitors;
                                break;
                            case "users":
                                $rating = $data->average_rating_users;
                                break;
                            case "total":
                                $sum = $data->average_rating_users * $data->total_votes_users + $data->average_rating_visitors * $data->total_votes_visitors;
                                $votes = $data->total_votes_users + $data->total_votes_visitors;
                                $sum = $votes == 0 ? 0 : $sum / $votes;
                                $rating = number_format($sum, 1);
                                break;
                        }
                        $rating = GDSRRender::render_static_stars(($this->is_ie6 ? $this->o["mur_style_ie6"] : $this->o["mur_style"]), $this->o['mur_size'], $set->stars, $rating);
                        return $rating;
                    }
                }
            }
            $max = is_null($set) ? 10 : $set->stars;
            $rating = GDSRRender::render_static_stars(($this->is_ie6 ? $this->o["mur_style_ie6"] : $this->o["mur_style"]), $this->o['mur_size'], $max, 0);
            return $rating;
        }

        /**
         * Renders multi rating review editor block.
         *
         * @param int $post_id id of the post to render review editor for
         * @param bool $admin wheter the rendering is for admin edit post page or not
         * @return string rendered result
         */
        function blog_multi_review_editor($post_id, $settings = array(), $admin = true, $allow_vote = true) {
            if ($settings["id"] == "") $multi_id = $this->o["mur_review_set"];
            else $multi_id = $settings["id"];
            $set = gd_get_multi_set($multi_id);
            if ($multi_id > 0 && $post_id > 0) {
                $vote_id = GDSRDBMulti::get_vote($post_id, $multi_id, count($set->object));
                $multi_data = GDSRDBMulti::get_values($vote_id, 'rvw');
                if (count($multi_data) == 0) {
                    GDSRDBMulti::add_empty_review_values($vote_id, count($set->object));
                    $multi_data = GDSRDBMulti::get_values($vote_id, 'rvw');
                }
            } else $multi_data = array();

            $votes = array();
            foreach ($multi_data as $md) {
                $single_vote = array();
                $single_vote["votes"] = 1;
                $single_vote["score"] = $md->user_votes;
                $single_vote["rating"] = $md->user_votes;
                $votes[] = $single_vote;
            }
            if ($admin) include($this->plugin_path.'integrate/edit_multi.php');
            else return GDSRRenderT2::render_mre("oxygen", intval($settings["tpl"]), $allow_vote, $votes, $post_id, $set, 20);
        }
        // various rendering

        // edit boxes
        /**
         * Insert edit box for a comment on edit comment panel.
         */
        function editbox_comment() {
            if ($this->wp_version < 27)
                include($this->plugin_path.'integrate/editcomment26.php');
            else {
                if ($this->admin_page != "edit-comments.php") return;
                include($this->plugin_path.'integrate/editcomment27.php');
            }
        }

        /**
         * Insert box multi review on post edit panel.
         */
        function editbox_post_mur() {
            global $post;
            $post_id = $post->ID;
            $this->blog_multi_review_editor($post_id);
        }

        /**
         * Insert plugin box on post edit panel.
         */
        function editbox_post() {
            global $post;

            $gdsr_options = $this->o;
            $post_id = $post->ID;
            $default = false;

            $countdown_value = $gdsr_options["default_timer_countdown_value"];
            $countdown_type = $gdsr_options["default_timer_countdown_type"];
            if ($post_id == 0)
                $default = true;
            else {
                $post_data = GDSRDatabase::get_post_edit($post_id);
                if (count($post_data) > 0) {
                    $rating = explode(".", strval($post_data->review));
                    $rating_decimal = intval($rating[1]);
                    $rating = intval($rating[0]);
                    $vote_rules = $post_data->rules_articles;
                    $moderation_rules = $post_data->moderate_articles;
                    $cmm_vote_rules = $post_data->rules_comments;
                    $cmm_moderation_rules = $post_data->moderate_comments;
                    $timer_restrictions = $post_data->expiry_type;
                    if ($timer_restrictions == "T") {
                        $countdown_type = substr($post_data->expiry_value, 0, 1);
                        $countdown_value = substr($post_data->expiry_value, 1);
                    }
                    else if ($timer_restrictions == "D") {
                        $timer_date_value = $post_data->expiry_value;
                    }
                }
                else
                    $default = true;
            }

            if ($default) {
                $rating_decimal = -1;
                $rating = -1;
                $vote_rules = $gdsr_options["default_voterules_articles"];
                $moderation_rules = $gdsr_options["default_moderation_articles"];
                $timer_restrictions = $gdsr_options["default_timer_type"];
            }

            if ($this->wp_version < 27) {
                $box_width = "100%";
                include($this->plugin_path.'integrate/edit26.php');
            }
            else {
                $box_width = "260";
                include($this->plugin_path.'integrate/edit.php');
            }
        }
        // edit boxes

        // install
        /**
         * WordPress action for adding administration menu items
         */
        function admin_menu() {
            if ($this->wp_version < 27) {
                add_menu_page('GD Star Rating', 'GD Star Rating', 10, __FILE__, array(&$this,"star_menu_front"));
                if ($this->o["integrate_post_edit_mur"] == 1) {
                    add_meta_box("gdsr-meta-box", "GD Star Rating: ".__("Multi Ratings Review", "gd-star-rating"), array(&$this, 'editbox_post_mur'), "post", "advanced", "high");
                    add_meta_box("gdsr-meta-box", "GD Star Rating: ".__("Multi Ratings Review", "gd-star-rating"), array(&$this, 'editbox_post_mur'), "page", "advanced", "high");
                }
            }
            else {
                add_menu_page('GD Star Rating', 'GD Star Rating', 10, __FILE__, array(&$this,"star_menu_front"), plugins_url('gd-star-rating/gfx/menu.png'));
                if ($this->o["integrate_post_edit"] == 1) {
                    add_meta_box("gdsr-meta-box", "GD Star Rating", array(&$this, 'editbox_post'), "post", "side", "high");
                    add_meta_box("gdsr-meta-box", "GD Star Rating", array(&$this, 'editbox_post'), "page", "side", "high");
                }
                if ($this->o["integrate_post_edit_mur"] == 1) {
                    add_meta_box("gdsr-meta-box-mur", "GD Star Rating: ".__("Multi Ratings Review", "gd-star-rating"), array(&$this, 'editbox_post_mur'), "post", "advanced", "high");
                    add_meta_box("gdsr-meta-box-mur", "GD Star Rating: ".__("Multi Ratings Review", "gd-star-rating"), array(&$this, 'editbox_post_mur'), "page", "advanced", "high");
                }
                if ($this->o["integrate_comment_edit"] == 1) {
                    add_meta_box("gdsr-meta-box", "GD Star Rating", array(&$this, 'editbox_comment'), "comments", "side", "high");
                }
            }

            add_submenu_page(__FILE__, 'GD Star Rating: '.__("Front Page", "gd-star-rating"), __("Front Page", "gd-star-rating"), 10, __FILE__, array(&$this,"star_menu_front"));
            add_submenu_page(__FILE__, 'GD Star Rating: '.__("Articles", "gd-star-rating"), __("Articles", "gd-star-rating"), 10, "gd-star-rating-stats", array(&$this,"star_menu_stats"));
            if ($this->o["admin_category"] == 1) add_submenu_page(__FILE__, 'GD Star Rating: '.__("Categories", "gd-star-rating"), __("Categories", "gd-star-rating"), 10, "gd-star-rating-cats", array(&$this,"star_menu_cats"));
            if ($this->o["admin_users"] == 1) add_submenu_page(__FILE__, 'GD Star Rating: '.__("Users", "gd-star-rating"), __("Users", "gd-star-rating"), 10, "gd-star-rating-users", array(&$this,"star_menu_users"));
            if ($this->o["multis_active"] == 1)
                add_submenu_page(__FILE__, 'GD Star Rating: '.__("Multi Sets", "gd-star-rating"), __("Multi Sets", "gd-star-rating"), 10, "gd-star-rating-multi-sets", array(&$this,"star_multi_sets"));
            add_submenu_page(__FILE__, 'GD Star Rating: '.__("Settings", "gd-star-rating"), __("Settings", "gd-star-rating"), 10, "gd-star-rating-settings-page", array(&$this,"star_menu_settings"));
            add_submenu_page(__FILE__, 'GD Star Rating: '.__("Tools", "gd-star-rating"), __("Tools", "gd-star-rating"), 10, "gd-star-rating-tools", array(&$this,"star_menu_tools"));
            add_submenu_page(__FILE__, 'GD Star Rating: '.__("T2 Templates", "gd-star-rating"), __("T2 Templates", "gd-star-rating"), 10, "gd-star-rating-t2", array(&$this,"star_menu_t2"));
            if ($this->o["admin_ips"] == 1) add_submenu_page(__FILE__, 'GD Star Rating: '.__("IP's", "gd-star-rating"), __("IP's", "gd-star-rating"), 10, "gd-star-rating-ips", array(&$this,"star_menu_ips"));
            if ($this->o["admin_import"] == 1) add_submenu_page(__FILE__, 'GD Star Rating: '.__("Import", "gd-star-rating"), __("Import", "gd-star-rating"), 10, "gd-star-rating-import", array(&$this,"star_menu_import"));
            add_submenu_page(__FILE__, 'GD Star Rating: '.__("Export", "gd-star-rating"), __("Export", "gd-star-rating"), 10, "gd-star-rating-export", array(&$this,"star_menu_export"));
            $this->custom_actions('admin_menu');
            if ($this->o["admin_setup"] == 1) add_submenu_page(__FILE__, 'GD Star Rating: '.__("Setup", "gd-star-rating"), __("Setup", "gd-star-rating"), 10, "gd-star-rating-setup", array(&$this,"star_menu_setup"));
        }

        /**
         * WordPress action for adding administration header contents
         */
        function admin_head() {
            global $parent_file;
            $this->admin_page = $parent_file;
            $tabs_extras = "";
            $datepicker_date = "";

            if ($this->admin_plugin_page == "ips" && $_GET["gdsr"] == "iplist") $tabs_extras = ", selected: 1";
            if ($this->admin_plugin) {
                wp_admin_css('css/dashboard');
                echo('<link rel="stylesheet" href="'.$this->plugin_url.'css/admin/admin_main.css" type="text/css" media="screen" />');
                if ($this->wp_version >= 27 && $this->wp_version < 28) echo('<link rel="stylesheet" href="'.$this->plugin_url.'css/admin/admin_wp27.css" type="text/css" media="screen" />');
                if ($this->wp_version >= 28) echo('<link rel="stylesheet" href="'.$this->plugin_url.'css/admin/admin_wp28.css" type="text/css" media="screen" />');
                echo('<script type="text/javascript" src="'.$this->plugin_url.'js/jquery-ui.js"></script>');
                echo('<script type="text/javascript" src="'.$this->plugin_url.'js/jquery-ui-tabs.js"></script>');
                echo('<link rel="stylesheet" href="'.$this->plugin_url.'css/jquery/ui.tabs.css" type="text/css" media="screen" />');
                if ($this->admin_plugin_page == "t2" ||
                    $this->admin_plugin_page == "multi-sets") {
                    include(STARRATING_PATH."code/js/gd-star-jsf.php");
                }
            }
            if ($this->admin_plugin || $this->admin_page == "edit.php" || $this->admin_page == "post-new.php" || $this->admin_page == "themes.php") {
                echo('<link rel="stylesheet" href="'.$this->plugin_url.'css/jquery/ui.core.css" type="text/css" media="screen" />');
                echo('<link rel="stylesheet" href="'.$this->plugin_url.'css/jquery/ui.theme.css" type="text/css" media="screen" />');
                $datepicker_date = date("Y, n, j");
                echo('<script type="text/javascript" src="'.$this->plugin_url.'js/jquery-ui-datepicker.js"></script>');
                if(!empty($this->l)) {
                    $jsFile = $this->plugin_path.'js/i18n/jquery-ui-datepicker-'.$this->l.'.js';
                    if (@file_exists($jsFile) && is_readable($jsFile)) echo '<script type="text/javascript" src="'.$this->plugin_url.'js/i18n/jquery-ui-datepicker-'.$this->l.'.js"></script>';
                }
            }
            echo("\r\n");
            echo('<script type="text/javascript">jQuery(document).ready(function() {');
                echo("\r\n");
                if ($this->admin_page == "edit-comments.php") include ($this->plugin_path."code/js/gd-star-jsx.php");
                if ($this->admin_plugin) echo('jQuery("#gdsr_tabs > ul").tabs({fx: {height: "toggle"}'.$tabs_extras.' });');
                if ($this->admin_plugin || $this->admin_page == "edit.php" || $this->admin_page == "post-new.php" || $this->admin_page == "themes.php") echo('jQuery("#gdsr_timer_date_value").datepicker({duration: "fast", minDate: new Date('.$datepicker_date.'), dateFormat: "yy-mm-dd"});');
                if ($this->admin_plugin_page == "tools") echo('jQuery("#gdsr_lock_date").datepicker({duration: "fast", dateFormat: "yy-mm-dd"});');
                if ($this->admin_plugin_page == "settings-page") include(STARRATING_PATH."code/js/gd-star-jsa.php");
                if ($this->admin_page == "edit.php" && $this->o["integrate_post_edit_mur"] == 1) {
                    echo("\r\n");
                    include(STARRATING_PATH."code/js/gd-star-jsma.php");
                }
            echo('});');
            if ($this->admin_page == "edit.php") {
                $edit_std = $this->o["integrate_post_edit_mur"] == 1;
                $edit_mur = $this->o["integrate_post_edit"] == 1;
                echo("\r\n");
                include(STARRATING_PATH."code/js/gd-star-jse.php");
            }
            echo('</script>');
            if ($this->admin_page == "edit.php" && $this->o["integrate_post_edit_mur"] == 1) {
                $review_stars = "oxygen";
                $gfx_m = $this->g->find_stars($review_stars);
                $css_string = "#m".$review_stars."|20|20|".$gfx_m->type."|".$gfx_m->primary;
                echo("\r\n");
                echo('<link rel="stylesheet" href="'.$this->plugin_url.'css/gdstarating.css.php?s='.urlencode($css_string).'" type="text/css" media="screen" />');
            }
            if ($this->admin_page == "widgets.php" || $this->admin_page == "themes.php") {
                if ($this->wp_version < 28) echo('<script type="text/javascript" src="'.$this->plugin_url.'js/rating-widgets.js"></script>');
                else echo('<script type="text/javascript" src="'.$this->plugin_url.'js/rating-widgets-28.js"></script>');
                echo('<link rel="stylesheet" href="'.$this->plugin_url.'css/admin/admin_widgets.css" type="text/css" media="screen" />');
            }

            if ($this->admin_page == "edit-comments.php" || $this->admin_page == "comment.php") {
                $gfx_r = $this->g->find_stars($this->o["cmm_review_style"]);
                $comment_review = urlencode($this->o["cmm_review_style"]."|".$this->o["cmm_review_size"]."|".$this->o["cmm_review_stars"]."|".$gfx_r->type."|".$gfx_r->primary);
                echo('<link rel="stylesheet" href="'.$this->plugin_url.'css/admin/admin_comment.css.php?stars='.$comment_review.'" type="text/css" media="screen" />');
            }

            $this->custom_actions('admin_head');

            if ($this->admin_plugin && $this->wp_version < 26)
                echo('<link rel="stylesheet" href="'.get_option('home').'/wp-includes/js/thickbox/thickbox.css" type="text/css" media="screen" />');

            echo('<link rel="stylesheet" href="'.$this->plugin_url.'css/admin/admin_post.css" type="text/css" media="screen" />');
        }

        /**
         * Adding WordPress action and filter
         */
        function actions_filters() {
            add_action('init', array(&$this, 'init'));
            add_action('wp_head', array(&$this, 'wp_head'));
            add_action('widgets_init', array(&$this, 'widgets_init'));
            add_action('admin_menu', array(&$this, 'admin_menu'));
            add_action('admin_head', array(&$this, 'admin_head'));
            add_filter('plugin_action_links', array(&$this, 'plugin_links'), 10, 2 );
            if ($this->o["integrate_post_edit"] == 1) {
                if ($this->wp_version < 27) {
                    add_action('submitpost_box', array(&$this, 'editbox_post'));
                    add_action('submitpage_box', array(&$this, 'editbox_post'));
                }
            }
            if ($this->o["integrate_post_edit_mur"] == 1 || $this->o["integrate_post_edit"] == 1)
                add_action('save_post', array(&$this, 'saveedit_post'));
            if ($this->o["integrate_dashboard"] == 1) {
                add_action('wp_dashboard_setup', array(&$this, 'add_dashboard_widget'));
                if (!function_exists('wp_add_dashboard_widget'))
                    add_filter('wp_dashboard_widgets', array(&$this, 'add_dashboard_widget_filter'));
            }
            add_filter('comment_text', array(&$this, 'display_comment'));
            add_filter('the_content', array(&$this, 'display_article'));
            if ($this->o["comments_review_active"] == 1) {
                add_filter('preprocess_comment', array(&$this, 'comment_read_post'));
                add_filter('comment_post', array(&$this, 'comment_save_review'));
                if ($this->o["integrate_comment_edit"] == 1) {
                    if ($this->wp_version < 27)
                        add_action('submitcomment_box', array(&$this, 'editbox_comment'));

                    add_filter('comment_save_pre', array(&$this, 'comment_edit_review'));
                }
            }
            if ($this->o["integrate_tinymce"] == 1) {
                add_filter("mce_external_plugins", array(&$this, 'add_tinymce_plugin'), 5);
                add_filter('mce_buttons', array(&$this, 'add_tinymce_button'), 5);
            }

            if ($this->o["integrate_rss_powered"] == 1 || $this->o["rss_active"] == 1) {
                add_filter('the_excerpt_rss', array(&$this, 'rss_filter'));
                add_filter('the_content_rss', array(&$this, 'rss_filter'));
            }

            foreach ($this->shortcodes as $code) {
                $this->shortcode_action($code);
            }
        }

        /**
         * WordPress widgets init action
         */
        function widgets_init() {
            if ($this->wp_version < 28) {
                $this->widgets = new gdsrWidgets($this->g, $this->default_widget_comments, $this->default_widget_top, $this->default_widget);
                if ($this->o["widget_articles"] == 1) $this->widgets->widget_articles_init();
                if ($this->o["widget_top"] == 1) $this->widgets->widget_top_init();
                if ($this->o["widget_comments"] == 1) $this->widgets->widget_comments_init();
            }
            else {
                if ($this->o["widget_articles"] == 1) register_widget("gdsrWidgetRating");
                if ($this->o["widget_top"] == 1) register_widget("gdsrWidgetTop");
                if ($this->o["widget_comments"] == 1) register_widget("gdsrWidgetComments");
            }
        }

        /**
         * Adds Settings link to plugins panel grid
         */
        function plugin_links($links, $file) {
            static $this_plugin;
            if (!$this_plugin) $this_plugin = plugin_basename(__FILE__);

            if ($file == $this_plugin){
                $settings_link = '<a href="admin.php?page=gd-star-rating-settings-page">'.__("Settings", "gd-star-rating").'</a>';
                array_unshift($links, $settings_link);
            }
            return $links;
        }

        /**
         * WordPress rss content filter
         */
        function rss_filter($content) {
            if ($this->o["rss_active"] == 1) $content.= "<br />".$this->render_article_rss();
            if ($this->o["integrate_rss_powered"] == 1) $content.= "<br />".$this->powered_by();
            return $content."<br />";
        }

        /**
         * Renders tag with link and powered by button
         *
         * @return string rendered content
         */
        function powered_by() {
            return '<a target="_blank" href="http://www.gdstarrating.com/"><img src="'.STARRATING_URL.'gfx/powered.png" border="0" width="80" height="15" /></a>';
        }

        function add_dashboard_widget() {
            if (!function_exists('wp_add_dashboard_widget'))
                wp_register_sidebar_widget("dashboard_gdstarrating", "GD Star Rating", array(&$this, 'display_dashboard_widget'), array('all_link' => get_bloginfo('wpurl').'/wp-admin/admin.php?page=gd-star-rating/gd-star-rating.php', 'width' => 'half', 'height' => 'single'));
            else
                wp_add_dashboard_widget("dashboard_gdstarrating", "GD Star Rating", array(&$this, 'display_dashboard_widget'));
        }

        function add_dashboard_widget_filter($widgets) {
            global $wp_registered_widgets;

            if (!isset($wp_registered_widgets["dashboard_gdstarrating"])) return $widgets;

            array_splice($widgets, 2, 0, "dashboard_gdstarrating");
            return $widgets;
        }

        function display_dashboard_widget($sidebar_args) {
            if (!function_exists('wp_add_dashboard_widget')) {
                extract($sidebar_args, EXTR_SKIP);
                echo $before_widget.$before_title.$widget_name.$after_title;
            }
            include($this->plugin_path.'integrate/dashboard.php');
            if (!function_exists('wp_add_dashboard_widget')) {
                echo $after_widget;
            }
        }

        function comment_read_post($comment) {
			if (isset($_POST["gdsr_cmm_review"]))
				$this->post_comment["review"] = $_POST["gdsr_cmm_review"];
			else
				$this->post_comment["review"] = -1;
            $this->post_comment["post_id"] = $_POST["comment_post_ID"];
            return $comment;
        }

        function comment_save_review($comment_id) {
            $comment_data = GDSRDatabase::get_comment_data($comment_id);
            if (count($comment_data) == 0)
                GDSRDatabase::add_empty_comment($comment_id, $this->post_comment["post_id"], $this->post_comment["review"]);
            else
                GDSRDatabase::save_comment_review($comment_id, $this->post_comment["review"]);
        }

        function comment_edit_review($comment_content) {
            if ($_POST['gdsr_comment_edit'] == "edit") {
                $post_id = $_POST["comment_post_ID"];
                $comment_id = $_POST["comment_ID"];
				if (isset($_POST["gdsr_cmm_review"]))
					$value = $_POST["gdsr_cmm_review"];
				else
					$value = -1;
                $comment_data = GDSRDatabase::get_comment_data($comment_id);
                if (count($comment_data) == 0)
                    GDSRDatabase::add_empty_comment($comment_id, $post_id, $value);
                else
                    GDSRDatabase::save_comment_review($comment_id, $value);
            }
            return $comment_content;
        }

        /**
         * Triggers saving GD Star Rating data for post.
         *
         * @param int $post_id ID of the post saving
         */
        function saveedit_post($post_id) {
            $post_id = $_POST["post_ID"];

            if ($_POST['gdsr_post_edit'] == "edit") {

                if ($this->o["integrate_post_edit"] == 1) {
                    $set_id = $_POST["gdsrmultiactive"];
                    if ($set_id > 0) {
                        $mur = $_POST['gdsrmulti'];
                        $mur = $mur[$post_id][0];
                        $values = explode("X", $mur);
                        $set = gd_get_multi_set($set_id);
                        $record_id = GDSRDBMulti::get_vote($post_id, $set_id, count($set->object));
                        GDSRDBMulti::save_review($record_id, $values);
                        GDSRDBMulti::recalculate_multi_review($record_id, $values, $set);
                        $this->o["mur_review_set"] = $_POST["gdsrmultiset"];
                        update_option('gd-star-rating', $this->o);
                    }
                }

                $old = GDSRDatabase::check_post($post_id);

                $review = $_POST['gdsr_review'];
                if ($_POST['gdsr_review_decimal'] != "-1")
                    $review.= ".".$_POST['gdsr_review_decimal'];
                GDSRDatabase::save_review($post_id, $review, $old);
                $old = true;

                GDSRDatabase::save_article_rules($post_id, $_POST['gdsr_vote_articles'], $_POST['gdsr_mod_articles']);
                if ($this->o["comments_active"] == 1)
                    GDSRDatabase::save_comment_rules($post_id, $_POST['gdsr_cmm_vote_articles'], $_POST['gdsr_cmm_mod_articles']);
                $timer = $_POST['gdsr_timer_type'];
                GDSRDatabase::save_timer_rules(
                    $post_id,
                    $timer,
                    GDSRHelper::timer_value($timer,
                        $_POST['gdsr_timer_date_value'],
                        $_POST['gdsr_timer_countdown_value'],
                        $_POST['gdsr_timer_countdown_type'])
                );
            }
        }

        /**
         * Main installation method of the plugin
         */
        function install_plugin() {
            $this->o = get_option('gd-star-rating');
            $this->i = get_option('gd-star-rating-import');
            $this->g = get_option('gd-star-rating-gfx');
            $this->wpr8 = get_option('gd-star-rating-wpr8');

            if ($this->o["build"] < $this->default_options["build"]) {
                if (is_object($this->g)) {
                    $this->g = $this->gfx_scan();
                    update_option('gd-star-rating-gfx', $this->g);
                }

                gdDBInstallGDSR::delete_tables(STARRATING_PATH);
                gdDBInstallGDSR::create_tables(STARRATING_PATH);
                gdDBInstallGDSR::upgrade_tables(STARRATING_PATH);
                gdDBInstallGDSR::alter_tables(STARRATING_PATH);
                $this->o["database_upgrade"] = date("r");

                GDSRDB::insert_default_templates(STARRATING_PATH);
                GDSRDB::insert_extras_templates(STARRATING_PATH);
                GDSRDB::insert_extras_templates(STARRATING_XTRA_PATH, false);
                GDSRDB::update_default_templates(STARRATING_PATH);

                $this->o = gdFunctionsGDSR::upgrade_settings($this->o, $this->default_options);

                $this->o["version"] = $this->default_options["version"];
                $this->o["date"] = $this->default_options["date"];
                $this->o["status"] = $this->default_options["status"];
                $this->o["build"] = $this->default_options["build"];
                
                update_option('gd-star-rating', $this->o);
            }

            if (!is_array($this->o)) {
                update_option('gd-star-rating', $this->default_options);
                $this->o = get_option('gd-star-rating');
                gdDBInstallGDSR::create_tables(STARRATING_PATH);
            }

            if (!is_array($this->i)) {
                update_option('gd-star-rating-import', $this->default_import);
                $this->i = get_option('gd-star-rating-import');
            }
            else {
                $this->i = gdFunctionsGDSR::upgrade_settings($this->i, $this->default_import);
                update_option('gd-star-rating-import', $this->i);
            }

            if (!is_object($this->g)) {
                $this->g = $this->gfx_scan();
                update_option('gd-star-rating-gfx', $this->g);
            }

            if (!is_object($this->wpr8)) {
                update_option('gd-star-rating-wpr8', $this->default_wpr8);
                $this->wpr8 = get_option('gd-star-rating-wpr8');
            }
            else {
                $this->wpr8 = gdFunctionsGDSR::upgrade_settings($this->wpr8, $this->default_wpr8);
                update_option('gd-star-rating-wpr8', $this->wpr8);
            }

            $this->use_nonce = $this->o["use_nonce"] == 1;
            define("STARRATING_VERSION", $this->o["version"].'_'.$this->o["build"]);
            define("STARRATING_DEBUG_ACTIVE", $this->o["debug_active"]);
            define("STARRATING_STARS_GENERATOR", $this->o["gfx_generator_auto"] == 0 ? "DIV" : "GFX");
            $this->t = GDSRDB::get_database_tables();
        }

        /**
         * Scans main and additional graphics folders for stars and trends sets.
         *
         * @return GDgfxLib scanned graphics object
         */
        function gfx_scan() {
            $data = new GDgfxLib();

            $stars_folders = gdFunctionsGDSR::get_folders($this->plugin_path."stars/");
            foreach ($stars_folders as $f) {
                $gfx = new GDgfxStar($f);
                if ($gfx->imported)
                    $data->stars[] = $gfx;
            }
            if (is_dir($this->plugin_xtra_path."stars/")) {
                $stars_folders = gdFunctionsGDSR::get_folders($this->plugin_xtra_path."stars/");
                foreach ($stars_folders as $f) {
                    $gfx = new GDgfxStar($f, false);
                    if ($gfx->imported)
                        $data->stars[] = $gfx;
                }
            }
            $trend_folders = gdFunctionsGDSR::get_folders($this->plugin_path."trends/");
            foreach ($trend_folders as $f) {
                $gfx = new GDgfxTrend($f);
                if ($gfx->imported)
                    $data->trend[] = $gfx;
            }
            if (is_dir($this->plugin_xtra_path."trends/")) {
                $trend_folders = gdFunctionsGDSR::get_folders($this->plugin_xtra_path."trends/");
                foreach ($trend_folders as $f) {
                    $gfx = new GDgfxTrend($f, false);
                    if ($gfx->imported)
                        $data->trend[] = $gfx;
                }
            }
            return $data;
        }

        /**
         * Gest the name of active plugin page
         */
        function active_wp_page() {
            if (stripos($_GET["page"], "gd-star-rating") === false)
                $this->active_wp_page = false;
            else
                $this->active_wp_page = true;
        }

        /**
         * Calculates all needed paths and sets them as constants.
         *
         * @global string $wp_version wordpress version
         */
        function plugin_path_url() {
            global $wp_version;
            $this->wp_version = substr(str_replace('.', '', $wp_version), 0, 2);
            if ($this->wp_version < 26) {
                $this->plugin_url = get_option('siteurl').'/'.PLUGINDIR.'/gd-star-rating/';
                $this->plugin_ajax = get_option('siteurl').'/'.PLUGINDIR.'/gd-star-rating/ajax.php';
                $this->plugin_xtra_url = get_option('siteurl').'/wp-content/gd-star-rating/';
                $this->plugin_xtra_path = ABSPATH.'/wp-content/gd-star-rating/';
                $this->plugin_cache_path = $this->plugin_xtra_path."cache/";
            }
            else {
                $this->plugin_url = WP_PLUGIN_URL.'/gd-star-rating/';
                $this->plugin_ajax = get_option('siteurl').'/wp-content/plugins/gd-star-rating/ajax.php';
                $this->plugin_xtra_url = WP_CONTENT_URL.'/gd-star-rating/';
                $this->plugin_xtra_path = WP_CONTENT_DIR.'/gd-star-rating/';
                $this->plugin_cache_path = $this->plugin_xtra_path."cache/";
            }
            $this->plugin_path = dirname(__FILE__)."/";
            $this->e = $this->plugin_url."gfx/blank.gif";

            $this->plugin_wpr8_path = $this->plugin_path."wpr8/";
            $this->plugin_chart_path = $this->plugin_path."charts/";
            $this->plugin_chart_url = $this->plugin_url."charts/";

            if (is_dir($this->plugin_wpr8_path)) $this->wpr8_available = true;

            define('STARRATING_URL', $this->plugin_url);
            define('STARRATING_AJAX', $this->plugin_ajax);
            define('STARRATING_PATH', $this->plugin_path);
            define('STARRATING_XTRA_URL', $this->plugin_xtra_url);
            define('STARRATING_XTRA_PATH', $this->plugin_xtra_path);
            define('STARRATING_CACHE_PATH', $this->plugin_cache_path);

            define('STARRATING_CHART_URL', $this->plugin_chart_url);
            define('STARRATING_CHART_PATH', $this->plugin_chart_path);
            define('STARRATING_CHART_CACHE_URL', $this->plugin_xtra_url."charts/");
            define('STARRATING_CHART_CACHE_PATH', $this->plugin_xtra_path."charts/");
        }

        /**
         * Executes attached hook actions methods for plugin internal actions.
         * - init: executed after init method
         *
         * @param <type> $action name of the plugin action
         */
        function custom_actions($action) {
            do_action('gdsr_'.$action);
        }

        /**
         * Main init method executed as wordpress action 'init'.
         */
        function init() {
            $this->init_uninstall();

            define('STARRATING_ENCODING', $this->o["encoding"]);

            if (isset($_GET["page"])) {
                if (substr($_GET["page"], 0, 14) == "gd-star-rating") {
                    $this->admin_plugin = true;
                    $this->admin_plugin_page = substr($_GET["page"], 15);
                }
            }

            $this->init_operations();

            if (!is_admin()) {
                $this->is_bot = GDSRHelper::detect_bot($_SERVER['HTTP_USER_AGENT']);
                $this->is_ban = GDSRHelper::detect_ban();
                $this->render_wait_article();
                if ($this->o["comments_active"] == 1) $this->render_wait_comment();
                if ($this->o["multis_active"] == 1) $this->render_wait_multis();
            }
            else $this->cache_cleanup();

            if ($this->admin_plugin_page == "settings-page") {
                $gdsr_options = $this->o;
                include ($this->plugin_path."code/gd-star-settings.php");
                $this->o = $gdsr_options;
            }

            wp_enqueue_script('jquery');
            if ($this->admin_plugin) {
                if ($this->wp_version >= 26) add_thickbox();
                else wp_enqueue_script("thickbox");
                $this->safe_mode = gdFunctionsGDSR::php_in_safe_mode();
                if (!$this->safe_mode)
                    $this->extra_folders = GDSRHelper::create_folders($this->wp_version);
            }
            $this->l = get_locale();
            if(!empty($this->l)) {
                $moFile = dirname(__FILE__)."/languages/gd-star-rating-".$this->l.".mo";
                if (@file_exists($moFile) && is_readable($moFile)) load_textdomain('gd-star-rating', $moFile);
            }

            $this->is_cached = $this->o["cache_active"];
            $this->is_ie6 = is_msie6();
            $this->custom_actions('init');

            if (is_admin() && $this->o["mur_review_set"] == 0) {
                $set = GDSRDBMulti::get_multis(0, 1);
                if (count($set) > 0) {
                    $this->o["mur_review_set"] = $set[0]->multi_id;
                    update_option('gd-star-rating', $this->o);
                }
            }

            if (!is_admin() && !is_feed()) {
                $this->rendering_sets = GDSRDBMulti::get_multisets_for_auto_insert();
                if (!is_array($this->rendering_sets)) $this->rendering_sets = array();
            } else $this->rendering_sets = array();
        }

        /**
         * Method executing cleanup of the cache files
         */
        function cache_cleanup() {
            if ($this->o["cache_cleanup_auto"] == 1) {
                $clean = false;

                $pdate = strtotime($this->o["cache_cleanup_last"]);
                $next_clean = mktime(date("H", $pdate), date("i", $pdate), date("s", $pdate), date("m", $pdate) + $this->o["cache_cleanup_days"], date("j", $pdate), date("Y", $pdate));
                if (intval($next_clean) < intval(mktime())) $clean = true;

                if ($clean) {
                    GDSRHelper::clean_cache(substr(STARRATING_CACHE_PATH, 0, strlen(STARRATING_CACHE_PATH) - 1));
                    $this->o["cache_cleanup_last"] = date("r");
                    update_option('gd-star-rating', $this->o);
                }
            }
        }

        function init_uninstall() {
            if ($_POST["gdsr_full_uninstall"] == __("UNINSTALL", "gd-star-rating")) {
                delete_option('gd-star-rating');
                delete_option('widget_gdstarrating');
                delete_option('gd-star-rating-templates');
                delete_option('gd-star-rating-import');
                delete_option('gd-star-rating-gfx');

                gdDBInstallGDSR::drop_tables(STARRATING_PATH);
                GDSRHelper::deactivate_plugin();
                update_option('recently_activated', array("gd-star-rating/gd-star-rating.php" => time()) + (array)get_option('recently_activated'));
                wp_redirect('index.php');
                exit;
            }
        }

        function init_operations() {
            $msg = "";
            if ($_POST["gdsr_multi_review_form"] == "review") {
                $mur_all = $_POST['gdsrmulti'];
                $set_id = $this->o["mur_review_set"];
                foreach ($mur_all as $post_id => $data) {
                    $mur = $data[0];
                    $values = explode("X", $mur);
                    $set = gd_get_multi_set($set_id);
                    $record_id = GDSRDBMulti::get_vote($post_id, $set_id, count($set->object));
                    GDSRDBMulti::save_review($record_id, $values);
                    GDSRDBMulti::recalculate_multi_review($record_id, $values, $set);
                }
                $this->custom_actions('init_save_review');
                wp_redirect_self();
                exit;
            }

            if (isset($_POST["gdsr_editcss_rating"])) {
                $rating_css = STARRATING_XTRA_PATH."css/rating.css";
                if (is_writeable($rating_css)) {
                    $newcontent = stripslashes($_POST['gdsr_editcss_contents']);
                    $f = fopen($rating_css, 'w+');
                    fwrite($f, $newcontent);
                    fclose($f);
                }
                wp_redirect_self();
                exit;
            }

            if (isset($_POST['gdsr_debug_clean'])) {
                wp_gdsr_debug_clean();
                wp_redirect_self();
                exit;
            }

            if (isset($_POST['gdsr_cache_clean'])) {
                GDSRHelper::clean_cache(substr(STARRATING_CACHE_PATH, 0, strlen(STARRATING_CACHE_PATH) - 1));
                $this->o["cache_cleanup_last"] = date("r");
                update_option('gd-star-rating', $this->o);
                wp_redirect_self();
                exit;
            }

            if (isset($_POST['gdsr_preview_scan'])) {
                $this->g = $this->gfx_scan();
                update_option('gd-star-rating-gfx', $this->g);
                wp_redirect_self();
                exit;
            }

            if (isset($_POST['gdsr_t2_import'])) {
                GDSRDB::insert_extras_templates(STARRATING_XTRA_PATH, false);
                wp_redirect_self();
                exit;
            }

            if (isset($_POST['gdsr_upgrade_tool'])) {
                gdDBInstallGDSR::delete_tables(STARRATING_PATH);
                gdDBInstallGDSR::create_tables(STARRATING_PATH);
                gdDBInstallGDSR::upgrade_tables(STARRATING_PATH);
                gdDBInstallGDSR::alter_tables(STARRATING_PATH);
                $this->o["database_upgrade"] = date("r");
                update_option('gd-star-rating', $this->o);
                wp_redirect_self();
                exit;
            }

            if (isset($_POST['gdsr_mulitrecalc_tool'])) {
                $set_id = $_POST['gdsr_mulitrecalc_set'];
                if ($set_id > 0) GDSRDBMulti::recalculate_set($set_id);
                else GDSRDBMulti::recalculate_all_sets();
                wp_redirect_self();
                exit;
            }

            if (isset($_POST['gdsr_cleanup_tool'])) {
                if (isset($_POST['gdsr_tools_clean_invalid_log'])) {
                    $count = GDSRDBTools::clean_invalid_log_articles();
                    if ($count > 0) $msg.= $count." ".__("articles records from log table removed.", "gd-star-rating")." ";
                    $count = GDSRDBTools::clean_invalid_log_comments();
                    if ($count > 0) $msg.= $count." ".__("comments records from log table removed.", "gd-star-rating")." ";
                }
                if (isset($_POST['gdsr_tools_clean_invalid_trend'])) {
                    $count = GDSRDBTools::clean_invalid_trend_articles();
                    if ($count > 0) $msg.= $count." ".__("articles records from trends log table removed.", "gd-star-rating")." ";
                    $count = GDSRDBTools::clean_invalid_trend_comments();
                    if ($count > 0) $msg.= $count." ".__("comments records from trends log table removed.", "gd-star-rating")." ";
                }
                if (isset($_POST['gdsr_tools_clean_old_posts'])) {
                    $count = GDSRDBTools::clean_dead_articles();
                    if ($count > 0) $msg.= $count." ".__("dead articles records from articles table.", "gd-star-rating")." ";
                    $count = GDSRDBTools::clean_revision_articles();
                    if ($count > 0) $msg.= $count." ".__("post revisions records from articles table.", "gd-star-rating")." ";
                    $count = GDSRDBTools::clean_dead_comments();
                    if ($count > 0) $msg.= $count." ".__("dead comments records from comments table.", "gd-star-rating")." ";
                }
                if (isset($_POST['gdsr_tools_clean_old_posts'])) {
                    $count = GDSRDBMulti::clean_dead_articles();
                    if ($count > 0) $msg.= $count." ".__("dead articles records from multi ratings tables.", "gd-star-rating")." ";
                    $count = GDSRDBMulti::clean_revision_articles();
                    if ($count > 0) $msg.= $count." ".__("post revisions records from multi ratings tables.", "gd-star-rating")." ";
                }
                $this->o["database_cleanup"] = date("r");
                $this->o["database_cleanup_msg"] = $msg;
                update_option('gd-star-rating', $this->o);
                wp_redirect_self();
                exit;
            }

            if (isset($_POST['gdsr_post_lock'])) {
                $lock_date = $_POST['gdsr_lock_date'];
                GDSRDatabase::lock_post_massive($lock_date);
                $this->o["mass_lock"] = $lock_date;
                update_option('gd-star-rating', $this->o);
                wp_redirect_self();
                exit;
            }

            if (isset($_POST['gdsr_rules_set'])) {
                GDSRDatabase::update_settings_full($_POST["gdsr_article_moderation"], $_POST["gdsr_article_voterules"], $_POST["gdsr_comments_moderation"], $_POST["gdsr_comments_voterules"]);
                wp_redirect_self();
                exit;
            }

            if (isset($_GET["deltpl"])) {
                $del_id = $_GET["deltpl"];
                GDSRDB::delete_template($del_id);
                $url = remove_query_arg("deltpl");
                wp_redirect($url);
                exit;
            }

            if (isset($_POST["gdsr_save_tpl"])) {
                $general = array();
                $general["name"] = stripslashes(htmlentities($_POST['tpl_gen_name'], ENT_QUOTES, STARRATING_ENCODING));
                $general["desc"] = stripslashes(htmlentities($_POST['tpl_gen_desc'], ENT_QUOTES, STARRATING_ENCODING));
                $general["section"] = $_POST["tpl_section"];
                $general["dependencies"] = $_POST["tpl_tpl"];
                $general["id"] = $_POST["tpl_id"];
                $general["preinstalled"] = '0';
                $tpl_input = $_POST["tpl_element"];
                $elements = array();
                foreach ($tpl_input as $key => $value)
                    $elements[$key] = stripslashes(htmlentities($value, ENT_QUOTES, STARRATING_ENCODING));
                if ($general["id"] == 0) GDSRDB::add_template($general, $elements);
                else GDSRDB::edit_template($general, $elements);
                $url = remove_query_arg("tplid");
                $url = remove_query_arg("mode", $url);
                wp_redirect($url);
                exit;
            }
        }

        /**
         * Gets rating posts data for the post in the loop, used only when wordpress is rendering page or single post.
         *
         * @global object $post post from the loop
         */
        function init_post() {
            global $post;

            $this->p = GDSRDatabase::get_post_data($post->ID);
            if (count($this->p) == 0) {
                GDSRDatabase::add_default_vote($post->ID, $post->post_type == "page" ? "1" : "0");
                $this->p = GDSRDatabase::get_post_data($post->ID);
            }
        }

        function include_rating_css_xtra($external = true) {
            $elements = array();
            $presizes = "a".gdFunctionsGDSR::prefill_zeros($this->o["stars"], 2);
            $presizes.= "m".gdFunctionsGDSR::prefill_zeros(20, 2);
            $presizes.= "c".gdFunctionsGDSR::prefill_zeros($this->o["cmm_stars"], 2);
            $presizes.= "r".gdFunctionsGDSR::prefill_zeros($this->o["cmm_review_stars"], 2);
            $sizes = array(16, 20, 24, 30);
            $elements[] = $presizes;
            $elements[] = join("", $sizes);
            foreach($this->g->stars as $s) $elements[] = $s->primary.substr($s->type, 0, 1).$s->folder;
            $q = join("#", $elements);
            $url = $this->plugin_url.'css/gdsr.css.php?s='.urlencode($q);
            if ($external) echo('<link rel="stylesheet" href="'.$url.'" type="text/css" media="screen" />');
            else {
                echo('<style type="text/css" media=screen>');
                $inclusion = "internal";
                $base_url_local = $this->plugin_url;
                $base_url_extra = $this->plugin_xtra_url;
                include ($this->plugin_path."css/gdsr.css.php");
                echo('</style>');
            }
        }

        function include_rating_css($external = true) {
            $include_cmm_review = false;
            $include_mur_rating = false;

            $gfx_a = $this->g->find_stars($this->is_ie6 ? $this->o["style_ie6"] : $this->o["style"]);
            $css_string = "a".($this->is_ie6 ? $this->o["style_ie6"] : $this->o["style"])."|".$this->o["size"]."|".$this->o["stars"]."|".$gfx_a->type."|".$gfx_a->primary;
            if ($this->o["multis_active"] == 1) {
                $gfx_m = $this->g->find_stars($this->is_ie6 ? $this->o["mur_style_ie6"] : $this->o["mur_style"]);
                $css_string.= "#m".($this->is_ie6 ? $this->o["mur_style_ie6"] : $this->o["mur_style"])."|".$this->o["mur_size"]."|20|".$gfx_m->type."|".$gfx_m->primary;
                $include_mur_rating = true;
            }
            if (is_single() || is_page()) {
                if ($this->o["comments_active"] == 1) {
                    $gfx_c = $this->g->find_stars($this->is_ie6 ? $this->o["cmm_style_ie6"] : $this->o["cmm_style"]);
                    $css_string.= "#c".($this->is_ie6 ? $this->o["cmm_style_ie6"] : $this->o["cmm_style"])."|".$this->o["cmm_size"]."|".$this->o["cmm_stars"]."|".$gfx_c->type."|".$gfx_c->primary;
                }

                if ($this->o["comments_review_active"] == 1) {
                    $gfx_r = $this->g->find_stars($this->is_ie6 ? $this->o["cmm_review_style_ie6"] : $this->o["cmm_review_style"]);
                    $css_string.= "#r".($this->is_ie6 ? $this->o["cmm_review_style_ie6"] : $this->o["cmm_review_style"])."|".$this->o["cmm_review_size"]."|".$this->o["cmm_review_stars"]."|".$gfx_r->type."|".$gfx_r->primary;
                    $include_cmm_review = true;
                }
            }
            if ($external) echo('<link rel="stylesheet" href="'.$this->plugin_url.'css/gdstarating.css.php?s='.urlencode($css_string).'" type="text/css" media="screen" />');
            else {
                echo('<style type="text/css" media=screen>');
                $inclusion = "internal";
                $base_url_local = $this->plugin_url;
                $base_url_extra = $this->plugin_xtra_url;
                $q = $css_string;
                include ($this->plugin_path."css/gdstarating.css.php");
                echo('</style>');
            }
        }

        function multi_rating_header($external_css = true) {
            $this->include_rating_css($external_css);
            echo('<script type="text/javascript" src="'.$this->plugin_url.'script.js.php"></script>');
        }

        /**
         * WordPress action for adding blog header contents
         */
        function wp_head() {
            $include_cmm_review = $this->o["comments_review_active"] == 1;
            $include_mur_rating = $this->o["multis_active"] == 1;
            if (is_feed()) return;

            if ($this->o["external_rating_css"] == 1) $this->include_rating_css();
            else $this->include_rating_css(false);
            //if ($this->o["external_rating_css"] == 1) $this->include_rating_css_xtra();
            //else $this->include_rating_css_xtra(false);

            echo("\r\n");
            if ($this->o["external_css"] == 1 && file_exists($this->plugin_xtra_path."css/rating.css")) {
                echo('<link rel="stylesheet" href="'.$this->plugin_xtra_url.'css/rating.css" type="text/css" media="screen" />');
                echo("\r\n");
            }
            if ($this->o["external_javascript"] == 1)
                echo('<script type="text/javascript" src="'.$this->plugin_url.'script.js.php"></script>');
            else {
                echo('<script type="text/javascript">');
                if ($this->use_nonce) $nonce = wp_create_nonce('gdsr_ajax_r8');
                else $nonce = "";
                $button_active = $this->o["mur_button_active"] == 1;
                echo('//<![CDATA[');
                include ($this->plugin_path."code/js/gd-star-js.php");
                echo('// ]]>');
                echo('</script>');
            }
            echo("\r\n");

            $this->custom_actions('wp_head');

            if ($this->o["ie_opacity_fix"] == 1) GDSRHelper::ie_opacity_fix();
        }
        // install

        // vote
        function vote_multi_rating($votes, $post_id, $set_id, $tpl_id) {
            global $userdata;
            $ip = $_SERVER["REMOTE_ADDR"];
            if ($this->o["save_user_agent"] == 1) $ua = $_SERVER["HTTP_USER_AGENT"];
            else $ua = "";
            $user = intval($userdata->ID);
            $data = GDSRDatabase::get_post_data($post_id);
            $set = gd_get_multi_set($set_id);

wp_gdsr_dump("VOTE_MUR", "[POST: ".$post_id."|SET: ".$set_id."] --".$votes."-- [".$user."]");

            $values = explode("X", $votes);
            $allow_vote = true;
            foreach ($values as $v) {
                if ($v > $set->stars) {
                    $allow_vote = false;
                    break;
                }
            }

            if ($allow_vote) $allow_vote = $this->check_cookie($post_id."#".$set_id, "multis");
            if ($allow_vote) $allow_vote = GDSRDBMulti::check_vote($post_id, $user, $set_id, 'multis', $ip, $this->o["logged"] != 1, $this->o["mur_allow_mixed_ip_votes"] == 1);

            $rating = 0;
            $total_votes = 0;
            $json = array();

            if ($allow_vote) {
                GDSRDBMulti::save_vote($post_id, $set_id, $user, $ip, $ua, $values, $data);
                $summary = GDSRDBMulti::recalculate_multi_averages($post_id, $set_id, $data->rules_articles, $set, true);
                $this->save_cookie($post_id."#".$set_id, "multis");
                $rating = $summary["total"]["rating"];
                $total_votes = $summary["total"]["votes"];
                $json = $summary["json"];
            }

            include($this->plugin_path.'code/t2/gd-star-t2-templates.php');

            $template = new gdTemplateRender($tpl_id, "MRB");
            $rt = GDSRRenderT2::render_srt($template->dep["MRT"], $rating, $set->stars, $total_votes, $post_id);
            $enc_values = "[".join(",", $json)."]";

            return "{ status: 'ok', values: ".$enc_values.", rater: '".$rt."', average: '".$rating."' }";
        }

        function vote_article_ajax($votes, $id, $tpl_id) {
            global $userdata;
            $ip = $_SERVER["REMOTE_ADDR"];
            if ($this->o["save_user_agent"] == 1) $ua = $_SERVER["HTTP_USER_AGENT"];
            else $ua = "";
            $user = intval($userdata->ID);

wp_gdsr_dump("VOTE", "[POST: ".$id."] --".$votes."-- [".$user."]");

            $allow_vote = intval($votes) <= $this->o["stars"];

            if ($allow_vote) $allow_vote = $this->check_cookie($id);

            if ($allow_vote) $allow_vote = GDSRDatabase::check_vote($id, $user, 'article', $ip, $this->o["logged"] != 1, $this->o["allow_mixed_ip_votes"] == 1);

            if ($allow_vote) {
                GDSRDatabase::save_vote($id, $user, $ip, $ua, $votes);
                $this->save_cookie($id);
            }

            $data = GDSRDatabase::get_post_data($id);

            $unit_width = $this->o["size"];
            $unit_count = $this->o["stars"];

            $votes = 0;
            $score = 0;

            if ($data->rules_articles == "A" || $data->rules_articles == "N") {
                $votes = $data->user_voters + $data->visitor_voters;
                $score = $data->user_votes + $data->visitor_votes;
            }
            else if ($data->rules_articles == "V") {
                $votes = $data->visitor_voters;
                $score = $data->visitor_votes;
            }
            else {
                $votes = $data->user_voters;
                $score = $data->user_votes;
            }

            if ($votes > 0) $rating2 = $score / $votes;
            else $rating2 = 0;
            $rating1 = @number_format($rating2, 1);
            $rating_width = $rating2 * $unit_width;

            include($this->plugin_path.'code/t2/gd-star-t2-templates.php');

            $template = new gdTemplateRender($tpl_id, "SRB");
            $rt = GDSRRenderT2::render_srt($template->dep["SRT"], $rating1, $unit_count, $votes, $post_id);

            return "{ status: 'ok', value: ".$rating_width.", rater: '".$rt."' }";
        }

        function vote_comment_ajax($votes, $id, $tpl_id) {
            global $userdata;
            $ip = $_SERVER["REMOTE_ADDR"];
            if ($this->o["save_user_agent"] == 1) $ua = $_SERVER["HTTP_USER_AGENT"];
            else $ua = "";
            $user = intval($userdata->ID);

wp_gdsr_dump("VOTE_CMM", "[CMM: ".$id."] --".$votes."-- [".$user."]");

            $allow_vote = intval($votes) <= $this->o["cmm_stars"];

            if ($allow_vote) $allow_vote = $this->check_cookie($id, 'comment');

            if ($allow_vote) $allow_vote = GDSRDatabase::check_vote($id, $user, 'comment', $ip, $this->o["cmm_logged"] != 1, $this->o["cmm_allow_mixed_ip_votes"] == 1);

            if ($allow_vote) {
                GDSRDatabase::save_vote_comment($id, $user, $ip, $ua, $votes);
                $this->save_cookie($id, 'comment');
            }

            $data = GDSRDatabase::get_comment_data($id);
            $post_data = GDSRDatabase::get_post_data($data->post_id);

            $unit_width = $this->o["cmm_size"];
            $unit_count = $this->o["cmm_stars"];

            $votes = 0;
            $score = 0;

            if ($post_data->rules_comments == "A" || $post_data->rules_comments == "N") {
                $votes = $data->user_voters + $data->visitor_voters;
                $score = $data->user_votes + $data->visitor_votes;
            }
            else if ($post_data->rules_comments == "V") {
                $votes = $data->visitor_voters;
                $score = $data->visitor_votes;
            }
            else {
                $votes = $data->user_voters;
                $score = $data->user_votes;
            }

            if ($votes > 0) $rating2 = $score / $votes;
            else $rating2 = 0;
            $rating1 = @number_format($rating2, 1);
            $rating_width = $rating2 * $unit_width;

            include($this->plugin_path.'code/t2/gd-star-t2-templates.php');

            $template = new gdTemplateRender($tpl_id, "CRB");
            $rt = GDSRRenderT2::render_crt($template->dep["CRT"], $rating1, $unit_count, $votes, $post_id);

            return "{ status: 'ok', value: ".$rating_width.", rater: '".$rt."' }";
        }
        // vote

        /**
        * Calculates Bayesian Estimate Mean value for given number of votes and rating
        *
        * @param int $v number of votes
        * @param decimal $R rating value
        * @return decimal Bayesian rating value
        */
        function bayesian_estimate($v, $R) {
            $m = $this->o["bayesian_minimal"];
            $C = ($this->o["bayesian_mean"] / 100) * $this->o["stars"];

            $WR = ($v / ($v + $m)) * $R + ($m / ($v + $m)) * $C;
            return @number_format($WR, 1);
        }

        function get_ratings_post($post_id) {
            if ($this->p && $this->p->post_id == $post_id) $post_data = $this->p;
            else $post_data = GDSRDatabase::get_post_data($post_id);
            if (count($post_data) == 0) return null;
            return new GDSRArticleRating($post_data);
        }

        function get_ratings_comment($comment_id) {
            $comment_data = GDSRDatabase::get_comment_data($comment_id);
            if (count($comment_data) == 0) return null;
            return new GDSRCommentRating($comment_data);
        }

        function get_ratings_multi($set_id, $post_id) {
            $multis_data = GDSRDBMulti::get_multi_rating_data($set_id, $post_id);
            if (count($multis_data) == 0) return null;
            return new GDSRArticleMultiRating($multis_data, $set_id);
        }

        // menues
        function star_multi_sets() {
            $wpv = $this->wp_version;
            $gdsr_page = $_GET["gdsr"];

            $editor = true;
            if ($_POST['gdsr_action'] == 'save') {
                $editor = false;
                $eset = new GDMultiSingle(false);
                $eset->multi_id = $_POST["gdsr_ms_id"];
                $eset->name = stripslashes(htmlentities($_POST["gdsr_ms_name"], ENT_QUOTES, STARRATING_ENCODING));
                $eset->description = stripslashes(htmlentities($_POST["gdsr_ms_description"], ENT_QUOTES, STARRATING_ENCODING));
                $eset->stars = $_POST["gdsr_ms_stars"];
                $eset->auto_insert = $_POST["gdsr_ms_autoinsert"];
                $eset->auto_categories = $_POST["gdsr_ms_autocategories"];
                $eset->auto_location = $_POST["gdsr_ms_autolocation"];
                $elms = $_POST["gdsr_ms_element"];
                $elwe = $_POST["gdsr_ms_weight"];
                $i = 0;
                foreach ($elms as $el) {
                    if (($el != "" && $eset->multi_id == 0) || $eset->multi_id > 0) {
                        $eset->object[] = stripslashes(htmlentities($el, ENT_QUOTES, STARRATING_ENCODING));
                        $ew = $elwe[$i];
                        if (!is_numeric($ew)) $ew = 1;
                        $eset->weight[] = $ew;
                        $i++;
                    }
                }
                if ($eset->name != "") {
                    if ($eset->multi_id == 0) $set_id = GDSRDBMulti::add_multi_set($eset);
                    else {
                        $set_id = $eset->multi_id;
                        GDSRDBMulti::edit_multi_set($eset);
                    }
                }
            }
            $options = $this->o;
            if (($gdsr_page == "munew" || $gdsr_page == "muedit") && $editor) include($this->plugin_path.'options/multis/editor.php');
            else {
                switch ($gdsr_page) {
                    case "mulist":
                    default:
                        include($this->plugin_path.'options/multis/sets.php');
                        break;
                    case "murpost":
                        include($this->plugin_path.'options/multis/results_post.php');
                        break;
                    case "murset":
                        include($this->plugin_path.'options/multis/results_set.php');
                        break;
                }
            }
        }

        function star_multi_results() {
            $options = $this->o;
            $wpv = $this->wp_version;
            include($this->plugin_path.'options/multis/results.php');
        }

        function star_menu_front() {
            $options = $this->o;
            $wpv = $this->wp_version;
            include($this->plugin_path.'options/front.php');
        }

        function star_menu_settings() {
            if (isset($_POST['gdsr_preview_scan'])) {
                $this->g = $this->gfx_scan();
                update_option('gd-star-rating-gfx', $this->g);
            }

            $gdsr_styles = $this->styles;
            $gdsr_trends = $this->trends;
            $gdsr_options = $this->o;
            $gdsr_root_url = $this->plugin_url;
            $gdsr_gfx = $this->g;
            $gdsr_wpr8 = $this->wpr8_available;
            $extra_folders = $this->extra_folders;
            $safe_mode = $this->safe_mode;
            $wpv = $this->wp_version;

            $wpr8 = $this->wpr8;

            include($this->plugin_path.'options/settings.php');

            if ($recalculate_articles)
                GDSRDB::recalculate_articles($gdsr_oldstars, $gdsr_newstars);

            if ($recalculate_comment)
                GDSRDB::recalculate_comments($gdsr_cmm_oldstars, $gdsr_cmm_newstars);

            if ($recalculate_reviews)
                GDSRDB::recalculate_reviews($gdsr_review_oldstars, $gdsr_review_newstars);

            if ($recalculate_cmm_reviews)
                GDSRDB::recalculate_comments_reviews($gdsr_cmm_review_oldstars, $gdsr_cmm_review_newstars);
        }

        function star_menu_t2() {
            $options = $this->o;
            $wpv = $this->wp_version;

            include($this->plugin_path.'code/t2/gd-star-t2-templates.php');

            if (isset($_GET["tplid"])) {
                $id = $_GET["tplid"];
                $mode = $_GET["mode"];
                include($this->plugin_path.'options/templates/templates_editor.php');
            }
            else if (isset($_POST["gdsr_defaults"])) {
                include($this->plugin_path.'options/templates/templates_defaults.php');
            }
            else if (isset($_POST["gdsr_create"])) {
                $id = 0;
                $mode = "new";
                include($this->plugin_path.'options/templates/templates_editor.php');
            }
            else if (isset($_POST["gdsr_setdefaults"])) {
                GDSRDB::set_templates_defaults($_POST["gdsr_section"]);
                include($this->plugin_path.'options/templates/templates_list.php');
            }
            else {
                include($this->plugin_path.'options/templates/templates_list.php');
            }
        }

        function star_menu_setup() {
            $wpv = $this->wp_version;
            include($this->plugin_path.'options/setup.php');
        }

        function star_menu_ips() {
            $options = $this->o;
            $wpv = $this->wp_version;
            include($this->plugin_path.'options/ips.php');
        }

        function star_menu_tools() {
            $msg = "";

            $gdsr_options = $this->o;
            $gdsr_styles = $this->styles;
            $gdsr_trends = $this->trends;
            $gdsr_gfx = $this->g;
            $wpv = $this->wp_version;

            include($this->plugin_path.'options/tools.php');
        }

        function star_menu_import() {
            $options = $this->o;
            $imports = $this->i;
            $wpv = $this->wp_version;
            include($this->plugin_path.'options/import.php');
        }

        function star_menu_export() {
            $options = $this->o;
            $wpv = $this->wp_version;
            include($this->plugin_path.'options/export.php');
        }

        function star_menu_stats() {
            $options = $this->o;
            $wpv = $this->wp_version;
            $gdsr_page = $_GET["gdsr"];
            $use_nonce = $this->use_nonce;

            switch ($gdsr_page) {
                case "articles":
                default:
                    include($this->plugin_path.'options/articles.php');
                    break;
                case "moderation":
                    include($this->plugin_path.'options/moderation.php');
                    break;
                case "comments":
                    include($this->plugin_path.'options/comments.php');
                    break;
                case "voters":
                    include($this->plugin_path.'options/voters.php');
                    break;
            }
        }

        function star_menu_users(){
            $options = $this->o;
            $wpv = $this->wp_version;
            if ($_GET["gdsr"] == "userslog")
                include($this->plugin_path.'options/users_log.php');
            else
                include($this->plugin_path.'options/users.php');
        }

        function star_menu_cats(){
            $options = $this->o;
            $wpv = $this->wp_version;
            include($this->plugin_path.'options/categories.php');
        }
        // menues

        // cookies
        /**
        * Check the cookie for the given id and type to see if the visitor is already voted for it
        *
        * @param int $id post or comment id depending on $type
        * @param string $type article or comment
        * @return bool true if cookie exists for $id and $type, false if is not
        */
        function check_cookie($id, $type = "article") {
            if (
                ($type == "article" && $this->o["cookies"]) ||
                ($type == "multis" && $this->o["cookies"] == 1) ||
                ($type == "comment" && $this->o["cmm_cookies"])
                ) {
                if (isset($_COOKIE["wp_gdsr_".$type])) {
                    $cookie = $_COOKIE["wp_gdsr_".$type];
                    $cookie = substr($cookie, 7, strlen($cookie) - 7);
                    $cookie_ids = explode('|', $cookie);
                    if (in_array($id, $cookie_ids))
                        return false;
                }
            }
            return true;
        }

        /**
        * Saves the vote in the cookie for the given id and type
        *
        * @param int $id post or comment id depending on $type
        * @param string $type article or comment
        */
        function save_cookie($id, $type = "article") {
            if (
                ($type == "article" && $this->o["cookies"] == 1) ||
                ($type == "multis" && $this->o["cookies"] == 1) ||
                ($type == "comment" && $this->o["cmm_cookies"] == 1)
                ) {
                if (isset($_COOKIE["wp_gdsr_".$type])) {
                    $cookie = $_COOKIE["wp_gdsr_".$type];
                    $cookie = substr($cookie, 6, strlen($cookie) - 6);
                }
                else $cookie = '';
                $cookie.= "|".$id;
                setcookie("wp_gdsr_".$type, "voted_".$cookie, time() + 3600 * 24 * 365, '/');
            }
        }
        // ccookies

        // rendering
        function render_wait_article() {
            $cls = "loader ".$this->o["wait_loader_article"]." ";
            if ($this->o["wait_show_article"] == 1)
                $cls.= "width ";
            $cls.= $this->o["wait_class_article"];
            $div = '<div class="'.$cls.'" style="height: '.$this->o["size"].'px">';
            if ($this->o["wait_show_article"] == 0) {
                $padding = "";
                if ($this->o["size"] > 20) $padding = ' style="padding-top: '.(($this->o["size"] / 2) - 10).'px"';
                $div.= '<div class="loaderinner"'.$padding.'>'.__($this->o["wait_text_article"]).'</div>';
            }
            $div.= '</div>';
            $this->loader_article = $div;
        }

        function render_wait_multis() {
            $cls = "loader ".$this->o["wait_loader_multis"]." ";
            if ($this->o["wait_show_multis"] == 1)
                $cls.= "width ";
            $cls.= $this->o["wait_class_multis"];
            $div = '<div class="'.$cls.'" style="height: '.$this->o["mur_size"].'px">';
            if ($this->o["wait_show_multis"] == 0) {
                $padding = "";
                if ($this->o["size"] > 20) $padding = ' style="padding-top: '.(($this->o["mur_size"] / 2) - 10).'px"';
                $div.= '<div class="loaderinner"'.$padding.'>'.__($this->o["wait_text_multis"]).'</div>';
            }
            $div.= '</div>';
            $this->loader_multis = $div;
        }

        function render_wait_comment() {
            $cls = "loader ".$this->o["wait_loader_comment"]." ";
            if ($this->o["wait_show_comment"] == 1)
                $cls.= "width ";
            $cls.= $this->o["wait_class_comment"];
            $div = '<div class="'.$cls.'" style="height: '.$this->o["cmm_size"].'px">';
            if ($this->o["wait_show_comment"] == 0) {
                $padding = "";
                if ($this->o["cmm_size"] > 20) $padding = ' style="padding-top: '.(($this->o["cmm_size"] / 2) - 10).'px"';
                $div.= '<div class="loaderinner"'.$padding.'>'.__($this->o["wait_text_comment"]).'</div>';
            }
            $div.= '</div>';
            $this->loader_comment = $div;
        }

        function display_comment($content) {
            global $post, $comment, $userdata;

            if (is_admin()) return $content;
            if ($comment->comment_type == "pingback" && $this->o["display_trackback"] == 0) return $content;

            if (!is_feed()) {
                if ((is_single() && !is_admin() && $this->o["display_comment"] == 1) ||
                    (is_page() && !is_admin() && $this->o["display_comment_page"] == 1)
                ) {
                    $rendered = $this->render_comment($post, $comment, $userdata);
                    if ($this->o["auto_display_comment_position"] == "top" || $this->o["auto_display_comment_position"] == "both")
                        $content = $rendered.$content;
                    if ($this->o["auto_display_comment_position"] == "bottom" || $this->o["auto_display_comment_position"] == "both")
                        $content = $content.$rendered;
                }
            }

            return $content;
        }

        function display_article($content) {
            global $post, $userdata;

            if (is_admin()) return $content;
            if (!is_feed()) {
                if (is_single() || is_page()) {
                    GDSRDatabase::add_new_view($post->ID);
                    $this->widget_post_id = $post->ID;
                }

                if ((is_single() && $this->o["display_posts"] == 1) ||
                    (is_page() && $this->o["display_pages"] == 1) ||
                    (is_home() && $this->o["display_home"] == 1) ||
                    (is_archive() && $this->o["display_archive"] == 1) ||
                    (is_search() && $this->o["display_search"] == 1)
                ) {
                    $rendered = $this->render_article($post, $userdata);
                    if ($this->o["auto_display_position"] == "top" || $this->o["auto_display_position"] == "both")
                        $content = $rendered.$content;
                    if ($this->o["auto_display_position"] == "bottom" || $this->o["auto_display_position"] == "both")
                        $content = $content.$rendered;
                }
                $content = $this->display_multi_rating("top", $post, $userdata).$content;
                $content = $content.$this->display_multi_rating("bottom", $post, $userdata);
            }

            return $content;
        }

        function display_multi_rating($location, $post, $user) {
            $sets = $this->rendering_sets;
            $rendered = "";
            foreach ($sets as $set) {
                if ($set->auto_location == $location) {
                    $insert = false;
                    $auto = $set->auto_insert;

                    if (is_single() && ($auto == "apst" || $auto == "allp")) $insert = true;
                    if (!$insert && is_page() && ($auto == "apgs" || $auto == "allp")) $insert = true;
                    if (!$insert && is_single() && in_category($set->categories, $post->ID) && $auto == "cats") $insert = true;

                    if ($insert) {
                        $settings = array('id' => $set->multi_id, 'read_only' => 0);
                        $rendered.= $this->render_multi_rating($post, $user, $settings);
                    }
                }
            }
            return $rendered;
        }

        function get_article_rating($post_id, $is_page = '') {
            $post_data = GDSRDatabase::get_post_data($post_id);
            if (count($post_data) == 0) {
                GDSRDatabase::add_default_vote($post_id, $is_page);
                $post_data = GDSRDatabase::get_post_data($post_id);
            }

            $votes = 0;
            $score = 0;

            if ($post_data->rules_articles == "A" || $post_data->rules_articles == "N") {
                $votes = $post_data->user_voters + $post_data->visitor_voters;
                $score = $post_data->user_votes + $post_data->visitor_votes;
            }
            else if ($post_data->rules_articles == "V") {
                $votes = $post_data->visitor_voters;
                $score = $post_data->visitor_votes;
            }
            else {
                $votes = $post_data->user_voters;
                $score = $post_data->user_votes;
            }

            $out = array();
            $out[] = $votes;
            $out[] = $score;
            return $out;
        }

        function render_comment($post, $comment, $user, $override = array()) {
            if ($this->o["comments_active"] != 1) return "";
            if ($this->is_bot) return "";

            $dbg_allow = "F";
            $allow_vote = true;
            if ($this->is_ban && $this->o["ip_filtering"] == 1) {
                if ($this->o["ip_filtering_restrictive"] == 1) return "";
                else $allow_vote = false;
                $dbg_allow = "B";
            }

            $rd_unit_width = $this->o["cmm_size"];
            $rd_unit_count = $this->o["cmm_stars"];
            $rd_unit_style = $this->is_ie6 ? $this->o["cmm_style_ie6"] : $this->o["cmm_style"];
            $rd_post_id = intval($post->ID);
            $rd_user_id = intval($user->ID);
            $rd_comment_id = intval($comment->comment_ID);
            $rd_is_page = $post->post_type == "page" ? "1" : "0";

            if ($this->p)
                $post_data = $this->p;
            else if (is_single() || is_page()) {
                $this->init_post();
                $post_data = $this->p;
            }
            else {
                $post_data = GDSRDatabase::get_post_data($rd_post_id);
                if (count($post_data) == 0) {
                    GDSRDatabase::add_default_vote($rd_post_id, $rd_is_page);
                    $post_data = GDSRDatabase::get_post_data($rd_post_id);
                }
            }
            if ($post_data->rules_comments == "H")
                return "";

            $comment_data = GDSRDatabase::get_comment_data($rd_comment_id);
            if (count($comment_data) == 0) {
                GDSRDatabase::add_empty_comment($rd_comment_id, $rd_post_id);
                $comment_data = GDSRDatabase::get_comment_data($rd_comment_id);
            }

            if ($allow_vote) {
                if ($this->o["cmm_author_vote"] == 1 && $rd_user_id == $comment->user_id && $rd_user_id > 0) {
                    $allow_vote = false;
                    $dbg_allow = "A";
                }
            }

            if ($allow_vote) {
                if (
                    ($post_data->rules_comments == "") ||
                    ($post_data->rules_comments == "A") ||
                    ($post_data->rules_comments == "U" && $rd_user_id > 0) ||
                    ($post_data->rules_comments == "V" && $rd_user_id == 0)
                ) $allow_vote = true;
                else {
                    $allow_vote = false;
                    $dbg_allow = "R_".$post_data->rules_comments;
                }
            }

            if ($allow_vote) {
                $allow_vote = GDSRDatabase::check_vote($rd_comment_id, $rd_user_id, 'comment', $_SERVER["REMOTE_ADDR"], $this->o["cmm_logged"] != 1, $this->o["cmm_allow_mixed_ip_votes"] == 1);
                if (!$allow_vote) $dbg_allow = "D";
            }

            if ($allow_vote) {
                $allow_vote = $this->check_cookie($rd_comment_id, "comment");
                if (!$allow_vote) $dbg_allow = "C";
            }

            $votes = 0;
            $score = 0;

            if ($post_data->rules_comments == "A" || $post_data->rules_comments == "N") {
                $votes = $comment_data->user_voters + $comment_data->visitor_voters;
                $score = $comment_data->user_votes + $comment_data->visitor_votes;
            }
            else if ($post_data->rules_comments == "V") {
                $votes = $comment_data->visitor_voters;
                $score = $comment_data->visitor_votes;
            }
            else {
                $votes = $comment_data->user_voters;
                $score = $comment_data->user_votes;
            }

            $debug = $rd_user_id == 0 ? "V" : "U";
            $debug.= $rd_user_id == $comment->user_id ? "A" : "N";
            $debug.= ":".$dbg_allow." [".STARRATING_VERSION."]";

            $tags_css = array();
            $tags_css["CMM_CSS_BLOCK"] = $this->o["cmm_class_block"];
            $tags_css["CMM_CSS_HEADER"] = $this->o["srb_class_header"];
            $tags_css["CMM_CSS_STARS"] = $this->o["cmm_class_stars"];
            $tags_css["CMM_CSS_TEXT"] = $this->o["cmm_class_text"];

            if ($override["tpl"] > 0) $template_id = $override["tpl"];
            else $template_id = $this->o["default_crb_template"];

            $rating_block = GDSRRenderT2::render_crb($template_id, $rd_comment_id, "ratecmm", "c", $votes, $score, $rd_unit_style, $rd_unit_width, $rd_unit_count, $allow_vote, $rd_user_id, "comment", $tags_css, $this->o["cmm_header_text"], $debug, $this->loader_comment);
            return $rating_block;
        }

        function render_article_rss() {
            global $post;
            $rd_post_id = intval($post->ID);
            $post_data = GDSRDatabase::get_post_data($rd_post_id);

            $votes = 0;
            $score = 0;

            if ($post_data->rules_articles == "A" || $post_data->rules_articles == "N") {
                $votes = $post_data->user_voters + $post_data->visitor_voters;
                $score = $post_data->user_votes + $post_data->visitor_votes;
            }
            else if ($post_data->rules_articles == "V") {
                $votes = $post_data->visitor_voters;
                $score = $post_data->visitor_votes;
            }
            else {
                $votes = $post_data->user_voters;
                $score = $post_data->user_votes;
            }

            $template_id = $this->o["default_ssb_template"];

            $rating_block = GDSRRenderT2::render_ssb($template_id, $rd_post_id, $votes, $score, $this->o["rss_style"], $this->o["rss_size"], $this->o["stars"], $this->o["rss_header_text"]);
            return $rating_block;
        }

        function render_article($post, $user, $override = array("tpl" => 0)) {
            if ($this->is_bot) return "";

            $dbg_allow = "F";
            $allow_vote = true;
            if ($this->is_ban && $this->o["ip_filtering"] == 1) {
                if ($this->o["ip_filtering_restrictive"] == 1) return "";
                else $allow_vote = false;
                $dbg_allow = "B";
            }

            if (is_single() || (is_page() && $this->o["display_comment_page"] == 1)) $this->init_post();

            $rd_unit_width = $this->o["size"];
            $rd_unit_count = $this->o["stars"];
            $rd_unit_style = $this->is_ie6 ? $this->o["style_ie6"] : $this->o["style"];
            $rd_post_id = intval($post->ID);
            $rd_user_id = intval($user->ID);
            $rd_is_page = $post->post_type == "page" ? "1" : "0";

            if ($this->p)
                $post_data = $this->p;
            else {
                $post_data = GDSRDatabase::get_post_data($rd_post_id);
                if (count($post_data) == 0) {
                    GDSRDatabase::add_default_vote($rd_post_id, $rd_is_page);
                    $post_data = GDSRDatabase::get_post_data($rd_post_id);
                }
            }

            if ($post_data->rules_articles == "H") return "";

            if ($allow_vote) {
                if ($this->o["author_vote"] == 1 && $rd_user_id == $post->post_author) {
                    $allow_vote = false;
                    $dbg_allow = "A";
                }
            }

            if ($allow_vote) {
                if (
                    ($post_data->rules_articles == "") ||
                    ($post_data->rules_articles == "A") ||
                    ($post_data->rules_articles == "U" && $rd_user_id > 0) ||
                    ($post_data->rules_articles == "V" && $rd_user_id == 0)
                ) $allow_vote = true;
                else {
                    $allow_vote = false;
                    $dbg_allow = "R_".$post_data->rules_articles;
                }
            }

            $remaining = 0;
            $deadline = '';
            if ($allow_vote && ($post_data->expiry_type == 'D' || $post_data->expiry_type == 'T')) {
                switch($post_data->expiry_type) {
                    case "D":
                        $remaining = GDSRHelper::expiration_date($post_data->expiry_value);
                        $deadline = $post_data->expiry_value;
                        break;
                    case "T":
                        $remaining = GDSRHelper::expiration_countdown($post->post_date, $post_data->expiry_value);
                        $deadline = GDSRHelper::calculate_deadline($remaining);
                        break;
                }
                if ($remaining < 1) {
                    GDSRDatabase::lock_post($rd_post_id);
                    $allow_vote = false;
                    $dbg_allow = "T";
                }
            }

            if ($allow_vote) {
                $allow_vote = GDSRDatabase::check_vote($rd_post_id, $rd_user_id, 'article', $_SERVER["REMOTE_ADDR"], $this->o["logged"] != 1, $this->o["allow_mixed_ip_votes"] == 1);
                if (!$allow_vote) $dbg_allow = "D";
            }

            if ($allow_vote) {
                $allow_vote = $this->check_cookie($rd_post_id);
                if (!$allow_vote) $dbg_allow = "C";
            }

            $votes = 0;
            $score = 0;

            if ($post_data->rules_articles == "A" || $post_data->rules_articles == "N") {
                $votes = $post_data->user_voters + $post_data->visitor_voters;
                $score = $post_data->user_votes + $post_data->visitor_votes;
            }
            else if ($post_data->rules_articles == "V") {
                $votes = $post_data->visitor_voters;
                $score = $post_data->visitor_votes;
            }
            else {
                $votes = $post_data->user_voters;
                $score = $post_data->user_votes;
            }

            $debug = $rd_user_id == 0 ? "V" : "U";
            $debug.= $rd_user_id == $post->post_author ? "A" : "N";
            $debug.= ":".$dbg_allow." [".STARRATING_VERSION."]";

            $tags_css = array();
            $tags_css["CSS_BLOCK"] = $this->o["srb_class_block"];
            $tags_css["CSS_HEADER"] = $this->o["srb_class_header"];
            $tags_css["CSS_STARS"] = $this->o["srb_class_stars"];
            $tags_css["CSS_TEXT"] = $this->o["srb_class_text"];

            if ($override["tpl"] > 0) $template_id = $override["tpl"];
            else $template_id = $this->o["default_srb_template"];

            $rating_block = GDSRRenderT2::render_srb($template_id, $rd_post_id, "ratepost", "a", $votes, $score, $rd_unit_style, $rd_unit_width, $rd_unit_count, $allow_vote, $rd_user_id, "article", $tags_css, $this->o["header_text"], $debug, $this->loader_article, $post_data->expiry_type, $remaining, $deadline);
            return $rating_block;
        }

        function render_multi_rating($post, $user, $settings) {
            if ($this->is_bot) return "";
            if (is_feed()) return "";

            $set = gd_get_multi_set($settings["id"]);
            if ($set == null) return "";

            $dbg_allow = "F";
            $allow_vote = true;
            if ($this->is_ban && $this->o["ip_filtering"] == 1) {
                if ($this->o["ip_filtering_restrictive"] == 1) return "";
                else $allow_vote = false;
                $dbg_allow = "B";
            }

            if ($settings["read_only"] == 1) {
                $dbg_allow = "RO";
                $allow_vote = false;
            }

            if (is_single() || (is_page() && $this->o["display_comment_page"] == 1))
                $this->init_post();

            $rd_post_id = intval($post->ID);
            $rd_user_id = intval($user->ID);
            $rd_is_page = $post->post_type == "page" ? "1" : "0";
            $remaining = 0;
            $deadline = "";

            if ($this->p)
                $post_data = $this->p;
            else {
                $post_data = GDSRDatabase::get_post_data($rd_post_id);
                if (count($post_data) == 0) {
                    GDSRDatabase::add_default_vote($rd_post_id, $rd_is_page);
                    $post_data = GDSRDatabase::get_post_data($rd_post_id);
                }
            }
            if ($post_data->rules_articles == "H") return "";

            if ($allow_vote) {
                if ($this->o["author_vote"] == 1 && $rd_user_id == $post->post_author) {
                    $allow_vote = false;
                    $dbg_allow = "A";
                }
            }

            if ($allow_vote) {
                if (
                    ($post_data->rules_articles == "") ||
                    ($post_data->rules_articles == "A") ||
                    ($post_data->rules_articles == "U" && $rd_user_id > 0) ||
                    ($post_data->rules_articles == "V" && $rd_user_id == 0)
                ) $allow_vote = true;
                else {
                    $allow_vote = false;
                    $dbg_allow = "R_".$post_data->rules_articles;
                }
            }

            if ($allow_vote && ($post_data->expiry_type == 'D' || $post_data->expiry_type == 'T')) {
                switch($post_data->expiry_type) {
                    case "D":
                        $remaining = GDSRHelper::expiration_date($post_data->expiry_value);
                        $deadline = $post_data->expiry_value;
                        break;
                    case "T":
                        $remaining = GDSRHelper::expiration_countdown($post->post_date, $post_data->expiry_value);
                        $deadline = GDSRHelper::calculate_deadline($remaining);
                        break;
                }
                if ($remaining < 1) {
                    GDSRDatabase::lock_post($rd_post_id);
                    $allow_vote = false;
                    $dbg_allow = "T";
                }
            }

            if ($allow_vote) {
                $allow_vote = GDSRDBMulti::check_vote($rd_post_id, $rd_user_id, $set->multi_id, 'multis', $_SERVER["REMOTE_ADDR"], $this->o["logged"] != 1, $this->o["mur_allow_mixed_ip_votes"] == 1);
                if (!$allow_vote) $dbg_allow = "D";
            }

            if ($allow_vote) {
                $allow_vote = $this->check_cookie($rd_post_id."#".$set->multi_id, "multis");
                if (!$allow_vote) $dbg_allow = "C";
            }

            $multi_record_id = GDSRDBMulti::get_vote($rd_post_id, $set->multi_id, count($set->object));
            $multi_data = GDSRDBMulti::get_values($multi_record_id);

            $votes = array();
            foreach ($multi_data as $md) {
                $single_vote = array();
                $single_vote["votes"] = 0;
                $single_vote["score"] = 0;

                if ($post_data->rules_articles == "A" || $post_data->rules_articles == "N") {
                    $single_vote["votes"] = $md->user_voters + $md->visitor_voters;
                    $single_vote["score"] = $md->user_votes + $md->visitor_votes;
                }
                else if ($post_data->rules_articles == "V") {
                    $single_vote["votes"] = $md->visitor_voters;
                    $single_vote["score"] = $md->visitor_votes;
                }
                else {
                    $single_vote["votes"] = $md->user_voters;
                    $single_vote["score"] = $md->user_votes;
                }
                if ($single_vote["votes"] > 0) $rating = $single_vote["score"] / $single_vote["votes"];
                else $rating = 0;
                if ($rating > $set->stars) $rating = $set->stars;
                $single_vote["rating"] = @number_format($rating, 1);

                $votes[] = $single_vote;
            }

            $debug = $rd_user_id == 0 ? "V" : "U";
            $debug.= $rd_user_id == $post->post_author ? "A" : "N";
            $debug.= ":".$dbg_allow." [".STARRATING_VERSION."]";

            $tags_css = array();
            $tags_css["MUR_CSS_BLOCK"] = $this->o["mur_class_block"];
            $tags_css["MUR_CSS_HEADER"] = $this->o["mur_class_header"];
            $tags_css["MUR_CSS_TEXT"] = $this->o["mur_class_text"];
            $tags_css["MUR_CSS_BUTTON"] = $this->o["mur_class_button"];

            if ($settings["tpl"] > 0) $template_id = $settings["tpl"];
            else $template_id = $this->o["default_mrb_template"];

            return GDSRRenderT2::render_mrb($this->o["mur_style"], $template_id, $allow_vote, $votes, $rd_post_id, $set, $this->o["mur_size"], $this->o["mur_header_text"], $tags_css, $settings["average_stars"], $settings["average_size"], $post_data->expiry_type, $remaining, $deadline, $this->o["mur_button_active"] == 1, $this->o["mur_button_text"], $debug, $this->loader_multis);
        }
        // rendering
    }

    $gd_debug = new gdDebugGDSR(STARRATING_LOG_PATH);
    $gdsr = new GDStarRating();

    include(STARRATING_PATH."gd-star-custom.php");
}
