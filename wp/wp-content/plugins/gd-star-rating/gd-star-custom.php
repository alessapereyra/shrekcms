<?php

    /**
    * Writes a object dump into the log file
    *
    * @param string $msg log entry message
    * @param mixed $object object to dump
    * @param string $block adds start or end dump limiters { none | start | end }
    * @param string $mode file open mode
    */
    function wp_gdsr_dump($msg, $obj, $block = "none", $mode = "a+") {
        if (STARRATING_DEBUG_ACTIVE == 1) {
            global $gd_debug;
            $gd_debug->dump($msg, $obj, $block, $mode);
        }
    }

    /**
    * Truncates log file to zero lenght deleting all data inside.
    */
    function wp_gdsr_debug_clean() {
        global $gd_debug;
        $gd_debug->truncate();
    }

    /**
     * Renders small 80x15 powered by GD Star Rating button.
     *
     * @global GDStarRating $gdsr main rating class instance
     * @param bool $echo echo results or return it as a string
     * @return string html with rendered contents
     */
    function wp_gdsr_render_powered_by($echo = true) {
        global $gdsr;

        if ($echo) echo $gdsr->powered_by();
        else return $gdsr->powered_by();
    }

    /**
     * Renders the rating stars. This function call must be withing the post loop.
     *
     * @global object $post post data
     * @global object $userdata user data
     * @global GDStarRating $gdsr main rating class instance
     * @param int $template_id standard rating block template id
     * @param bool $echo echo results or return it as a string
     * @return string html with rendered contents
     */
    function wp_gdsr_render_article($template_id = 0, $echo = true) {
        global $post, $userdata, $gdsr;

        if ($echo) echo $gdsr->render_article($post, $userdata, array("tpl" => $template_id));
        else return $gdsr->render_article($post, $userdata, array("tpl" => $template_id));
    }

    /**
     * Manual render of comment rating
     *
     * @global object $comment comment data
     * @global object $post post data
     * @global object $userdata user data
     * @global GDStarRating $gdsr main rating class instance
     * @param bool $echo echo results or return it as a string
     * @return string html with rendered contents
     */
    function wp_gdsr_render_comment($template_id = 0, $echo = true) {
        global $comment, $userdata, $gdsr, $post;
        if ($echo) echo $gdsr->render_comment($post, $comment, $userdata, array("tpl" => $template_id));
        else return $gdsr->render_comment($post, $comment, $userdata, array("tpl" => $template_id));
    }

    /**
     * Renders stars for comment review used in the comment form for the comment author to place it's review rating.
     *
     * @global GDStarRating $gdsr main rating class instance
     * @param int $value inital value for the review
     * @param bool $echo echo results or return it as a string
     * @return string html with rendered contents
     */
    function wp_gdsr_new_comment_review($value = 0, $echo = true) {
        global $gdsr;
        if ($echo) echo $gdsr->comment_review($value);
        else return $gdsr->comment_review($value);
    }

    /**
     * Renders multi rating block. This function call must be withing the post loop.
     *
     * @global object $post post data
     * @global object $userdata user data
     * @global GDStarRating $gdsr main rating class instance
     * @param int $multi_set_id id of the multi rating set to use
     * @param int $post_id id of the post rating will be attributed to
     * @param bool $echo echo results or return it as a string
     * @return string html with rendered contents
     */
    function wp_gdsr_render_multi($multi_set_id, $post_id = 0, $template_id = 0, $echo = true) {
        global $userdata, $gdsr;
        if ($post_id == 0) global $post;
        else $post = get_post($post_id);

        if ($echo) echo $gdsr->render_multi_rating($post, $userdata, array("id" => $multi_set_id, "tpl" => $template_id));
        else return $gdsr->render_multi_rating($post, $userdata, array("id" => $multi_set_id, "tpl" => $template_id));
    }

    /**
     * Renders multi rating review editor block.
     *
     * @global object $post post data
     * @global GDStarRating $gdsr main rating class instance
     * @param int $post_id id of the post rating will be attributed to
     * @param bool $echo echo results or return it as a string
     * @param array $settings override settings for rendering the block
     * @return string html with rendered contents
     */
    function wp_gdsr_multi_review_editor($multi_set_id, $post_id = 0, $template_id = 0, $echo = true) {
        global $gdsr;
        if ($post_id == 0) {
            global $post;
            $post_id = $post->ID;
        }

        if ($echo) echo $gdsr->blog_multi_review_editor($post_id, array("id" => $multi_set_id, "tpl" => $template_id), false);
        else return $gdsr->blog_multi_review_editor($post_id, array("id" => $multi_set_id, "tpl" => $template_id), false);
    }

    /**
     * Renders multi rating review header elements css and javascript.
     *
     * @global GDStarRating $gdsr main rating class instance
     * @param bool $echo echo results or return it as a string
     * @return string html with rendered contents
     */
    function wp_gdsr_multi_review_editor_header($echo = true) {
        global $gdsr;

        if ($echo) echo $gdsr->multi_rating_header();
        else return $gdsr->multi_rating_header();
    }

    /**
     * Renders multi rating review for a post.
     *
     * @global object $post post data
     * @global GDStarRating $gdsr main rating class instance
     * @param int $post_id id of the post rating will be attributed to
     * @param array $settings override settings for rendering the block
     * @param bool $echo echo results or return it as a string
     * @return string html with rendered contents
     */
    function wp_gdsr_show_multi_review($multi_set_id, $post_id = 0, $template_id = 0, $echo = true) {
        global $gdsr;
        if ($post_id == 0) {
            global $post;
            $post_id = $post->ID;
        }

        if ($echo) echo $gdsr->blog_multi_review_editor($post_id, array("id" => $multi_set_id, "tpl" => $template_id), false, false);
        else return $gdsr->blog_multi_review_editor($post_id, array("id" => $multi_set_id, "tpl" => $template_id), false, false);
    }

    /**
     * Renders single rating stars image with average rating for the multi rating review.
     *
     * @global object $post post data
     * @global GDStarRating $gdsr main rating class instance
     * @param int $set_id id of the multi rating set
     * @param int $post_id id of the post rating will be attributed to
     * @param string $show what data to use: total, visitors or users votes only
     * @param bool $echo echo results or return it as a string
     * @return string html with rendered contents
     */
    function wp_gdsr_multi_rating_average($multi_set_id, $post_id = 0, $show = "total", $echo = true) {
        global $gdsr;
        if ($post_id == 0) {
            global $post;
            $post_id = $post->ID;
        }
        $rating = $gdsr->get_multi_average_rendered($post_id, array("id" => $multi_set_id, "show" => $show, "render" => "rating"));
        if ($echo) echo $rating;
        else return $rating;
    }

    /**
     * Renders single rating stars image with average rating for the multi rating review.
     *
     * @global object $post post data
     * @global GDStarRating $gdsr main rating class instance
     * @param int $set_id id of the multi rating set
     * @param int $post_id id of the post rating will be attributed to
     * @param bool $echo echo results or return it as a string
     * @return string html with rendered contents
     */
    function wp_gdsr_multi_review_average($multi_set_id, $post_id = 0, $echo = true) {
        global $gdsr;
        if ($post_id == 0) {
            global $post;
            $post_id = $post->ID;
        }
        $review = $gdsr->get_multi_average_rendered($post_id, array("id" => $multi_set_id, "render" => "review"));
        if ($echo) echo $review;
        else return $review;
    }
    
    /**
     * Returns object with all needed rating properties for post or page.
     *
     * @global object $post post data
     * @global GDStarRating $gdsr main rating class instance
     * @param int $post_id post to get rating for, leave 0 to get post from loop
     * @return object rating post properties
     */
    function wp_gdsr_rating_article($post_id = 0) {
        global $post, $gdsr;
        if ($post_id < 1) $post_id = $post->ID;
        return $gdsr->get_ratings_post($post_id);
    }

    /**
     * Returns object with all needed rating properties for comment.
     *
     * @global object $comment comment data
     * @global GDStarRating $gdsr main rating class instance
     * @param int $post_id post to get rating for, leave 0 to get post from loop
     * @return object rating post properties
     */
    function wp_gdsr_rating_comment($comment_id = 0) {
        global $comment, $gdsr;
        if ($comment_id < 1) $comment_id = $comment->comment_ID;
        return $gdsr->get_ratings_comment($comment_id);
    }

    /**
     * Returns object with all needed multi rating properties for post or page.
     *
     * @global object $post post data
     * @global GDStarRating $gdsr main rating class instance
     * @param int $set_id id of the multi rating set
     * @param int $post_id post to get rating for, leave 0 to get post from loop
     * @return object rating post properties
     */
    function wp_gdsr_rating_multi($multi_set_id, $post_id = 0) {
        global $post, $gdsr;
        if ($post_id < 1) $post_id = $post->ID;
        return $gdsr->get_ratings_multi($multi_set_id, $post_id);
    }

    /**
     * Returns calculated data for average blog rating including bayesian estimate mean.
     *
     * @global class $gdsr
     * @param string $select articles to select postpage|post|page
     * @param string $show votes to use: total|users|visitors
     * @return object with average blog rating values
     */
    function wp_gdsr_blog_rating($select = "postpage", $show = "total") {
        $widget = array("select" => $select, "show" => $show);
        return GDSRRenderT2::prepare_wbr($widget);
    }

    /**
     *
     *
     * @global GDStarRating $gdsr main rating class instance
     * @param bool $echo echo results or return it as a string
     * @return string html with rendered contents
     */
    function wp_gdsr_render_review($echo = true) {
        global $gdsr;
        if ($echo) echo $gdsr->shortcode_starreview();
        else return $gdsr->shortcode_starreview();
    }

    /**
     * Renders widget-like element based on the $widget settings array
     *
     * @param array $widget settings to use for rendering
     * @param bool $echo echo results or return it as a string
     * @return string html with rendered contents
     */
    function wp_gdsr_render_star_rating_widget($widget = array(), $echo = true) {
        if ($echo) echo GDSRRenderT2::render_wsr($widget);
        else return GDSRRenderT2::render_wsr($widget);
    }

    /**
     * Renders blog rating widget element based on the $widget settings array
     *
     * @param array $widget settings to use for rendering
     * @param bool $echo echo results or return it as a string
     * @return string html with rendered contents
     */
    function wp_gdsr_render_blog_rating_widget($widget = array(), $echo = true) {
        if ($echo) echo GDSRRenderT2::render_wbr($widget);
        else return GDSRRenderT2::render_wbr($widget);
    }

    /**
     * Renders comments rating widget element based on the $widget settings array
     *
     * @param array $widget settings to use for rendering
     * @param bool $echo echo results or return it as a string
     * @return string html with rendered contents
     */
    function wp_gdsr_render_comments_rating_widget($widget = array(), $echo = true) {
        if ($echo) echo GDSRRenderT2::render_wcr($widget);
        else return GDSRRenderT2::render_wcr($widget);
    }

    /**
     * Shows stars with review rating of a comment.
     *
     * @global object $comment comment data
     * @global GDStarRating $gdsr main rating class instance
     * @param int $comment_id ID for the comment to display rating from. If this is set to 0, than it must be used within the comment loop, and id of current comment will be used.
     * @param bool $use_default set to true tell this function to render stars using default settings for stars set on settings panel, false tells to use $size and $style parameters.
     * @param int $size size of the stars to render, must be valid value: 12, 20, 30, 46
     * @param string $style name of the stars set to use, name of the folder for the set
     * @param bool $echo echo results or return it as a string
     * @return string html with rendered contents
     */
    function wp_gdsr_show_comment_review($comment_id = 0, $use_default = true, $size = 20, $style = "oxygen", $echo = true) {
        global $comment, $gdsr;
        if ($comment_id < 1) $comment_id = $comment->comment_ID;
        if ($echo) echo $gdsr->display_comment_review($comment_id, $use_default, $style, $size);
        else return $gdsr->display_comment_review($comment, $use_default, $style, $size);
    }
    
    /**
     * Shows review rating for the post with stars
     *
     * @global object $post post data
     * @global GDStarRating $gdsr main rating class instance
     * @param int $post_id ID for the article to display rating from. If this is set to 0, than it must be used within the loop, and id of current article will be used.
     * @param bool $use_default set to true tell this function to render stars using default settings for stars set on settings panel, false tells to use $size and $style parameters.
     * @param int $size size of the stars to render, must be valid value: 12, 20, 30, 46
     * @param string $style name of the stars set to use, name of the folder for the set
     * @param bool $echo echo results or return it as a string
     * @return string html with rendered contents
     */
    function wp_gdsr_show_article_review($post_id = 0, $use_default = true, $size = 20, $style = "oxygen", $echo = true) {
        global $post, $gdsr;
        if ($post_id < 1) $post_id = $post->ID;
        if ($echo) echo $gdsr->display_article_review($post_id, $use_default, $style, $size);
        else return $gdsr->display_article_review($post_id, $use_default, $style, $size);
    }

    /**
     * Shows rating for the post with stars
     *
     * @global object $post post data
     * @global GDStarRating $gdsr main rating class instance
     * @param int $post_id ID for the article to display rating from. If this is set to 0, than it must be used within the loop, and id of current article will be used.
     * @param bool $use_default set to true tell this function to render stars using default settings for stars set on settings panel, false tells to use $size and $style parameters.
     * @param int $size size of the stars to render, must be valid value: 12, 20, 30, 46
     * @param string $style name of the stars set to use, name of the folder for the set
     * @param bool $echo echo results or return it as a string
     * @return string html with rendered contents
     */
    function wp_gdsr_show_article_rating($post_id = 0, $use_default = true, $size = 20, $style = "oxygen", $echo = true) {
        global $post, $gdsr;
        if ($post_id < 1) $post_id = $post->ID;
        if ($echo) echo $gdsr->display_article_rating($post_id, $use_default, $style, $size);
        else return $gdsr->display_article_rating($post_id, $use_default, $style, $size);
    }

?>