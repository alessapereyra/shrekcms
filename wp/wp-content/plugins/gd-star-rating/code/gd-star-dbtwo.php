<?php

class GDSRDBTools {
    function clean_invalid_log_articles() {
        global $wpdb, $table_prefix;
        $sql = sprintf("delete %s from %sgdsr_votes_log l left join %sposts o on o.ID = l.id where l.vote_type = 'article' and o.ID is null",
            gdFunctionsGDSR::mysql_pre_4_1() ? sprintf("%sgdsr_votes_log", $table_prefix) : "l",
            $table_prefix, $table_prefix);
        $wpdb->query($sql);
        return $wpdb->rows_affected;
    }

    function clean_invalid_log_comments() {
        global $wpdb, $table_prefix;
        $sql = sprintf("delete %s from %sgdsr_votes_log l left join %scomments o on o.comment_ID = l.id where l.vote_type = 'comment' and o.comment_ID is null",
            gdFunctionsGDSR::mysql_pre_4_1() ? sprintf("%sgdsr_votes_log", $table_prefix) : "l",
            $table_prefix, $table_prefix);
        $wpdb->query($sql);
        return $wpdb->rows_affected;
    }

    function clean_invalid_trend_articles() {
        global $wpdb, $table_prefix;
        $sql = sprintf("delete %s from %sgdsr_votes_trend l left join %sposts o on o.ID = l.id where l.vote_type = 'article' and o.ID is null",
            gdFunctionsGDSR::mysql_pre_4_1() ? sprintf("%sgdsr_votes_trend", $table_prefix) : "l",
            $table_prefix, $table_prefix);
        $wpdb->query($sql);
        return $wpdb->rows_affected;
    }

    function clean_invalid_trend_comments() {
        global $wpdb, $table_prefix;
        $sql = sprintf("delete %s from %sgdsr_votes_trend l left join %scomments o on o.comment_ID = l.id where l.vote_type = 'comment' and o.comment_ID is null",
            gdFunctionsGDSR::mysql_pre_4_1() ? sprintf("%sgdsr_votes_trend", $table_prefix) : "l",
            $table_prefix, $table_prefix);
        $wpdb->query($sql);
        return $wpdb->rows_affected;
    }

    function clean_dead_articles() {
        global $wpdb, $table_prefix;
        $sql = sprintf("delete %s from %sgdsr_data_article l left join %sposts o on o.ID = l.post_id where o.ID is null",
            gdFunctionsGDSR::mysql_pre_4_1() ? sprintf("%sgdsr_data_article", $table_prefix) : "l",
            $table_prefix, $table_prefix);
        $wpdb->query($sql);
        return $wpdb->rows_affected;
    }

    function clean_revision_articles() {
        global $wpdb, $table_prefix;
        $sql = sprintf("delete %s from %sgdsr_data_article l inner join %sposts o on o.ID = l.post_id where o.post_type = 'revision'",
            gdFunctionsGDSR::mysql_pre_4_1() ? sprintf("%sgdsr_data_article", $table_prefix) : "l",
            $table_prefix, $table_prefix);
        $wpdb->query($sql);
        return $wpdb->rows_affected;
    }

    function clean_dead_comments() {
        global $wpdb, $table_prefix;
        $sql = sprintf("delete %s from %sgdsr_data_comment l left join %scomments o on o.comment_ID = l.comment_id where o.comment_ID is null",
            gdFunctionsGDSR::mysql_pre_4_1() ? sprintf("%sgdsr_data_comment", $table_prefix) : "l",
            $table_prefix, $table_prefix);
        $wpdb->query($sql);
        return $wpdb->rows_affected;
    }
}

class GDSRDB {
    function get_database_tables() {
        global $table_prefix;
        $tables = array(
            "data_article" => $table_prefix.'gdsr_data_article',
            "data_comment" => $table_prefix.'gdsr_data_comment',
            "votes_log" => $table_prefix.'gdsr_votes_log',
            "votes_trend" => $table_prefix.'gdsr_votes_trend',
            "moderate" => $table_prefix.'gdsr_moderate',
            "multi_sets" => $table_prefix.'gdsr_multis',
            "banned_ips" => $table_prefix.'gdsr_ips'
        );
        return $tables;
    }

    function get_post_title($post_id) {
        global $wpdb;
        return $wpdb->get_var("select post_title from $wpdb->posts where ID = ".$post_id);
    }

    // conversion
    function convert_row($row) {
        switch ($row->moderate_articles) {
            case 'I':
                $row->moderate_articles = __("articles", "gd-star-rating").': <strong><span style="color: blue">'.__("inherited", "gd-star-rating").'</span></strong>';
                break;
            case 'A':
                $row->moderate_articles = __("articles", "gd-star-rating").': <strong><span style="color: red">'.__("all", "gd-star-rating").'</span></strong>';
                break;
            case 'V':
                $row->moderate_articles = __("articles", "gd-star-rating").': <strong><span style="color: red">'.__("visitors", "gd-star-rating").'</span></strong>';
                break;
            case 'U':
                $row->moderate_articles = __("articles", "gd-star-rating").': <strong><span style="color: red">'.__("users", "gd-star-rating").'</span></strong>';
                break;
            case 'N':
            default:
                $row->moderate_articles = __("articles", "gd-star-rating").': <strong>'.__("free", "gd-star-rating").'</strong>';
                break;
        }
        switch ($row->moderate_comments) {
            case 'I':
                $row->moderate_comments = __("comments", "gd-star-rating").': <strong><span style="color: blue">'.__("inherited", "gd-star-rating").'</span></strong>';
                break;
            case 'A':
                $row->moderate_comments = __("comments", "gd-star-rating").': <strong><span style="color: red">'.__("all", "gd-star-rating").'</span></strong>';
                break;
            case 'V':
                $row->moderate_comments = __("comments", "gd-star-rating").': <strong><span style="color: red">'.__("visitors", "gd-star-rating").'</span></strong>';
                break;
            case 'U':
                $row->moderate_comments = __("comments", "gd-star-rating").': <strong><span style="color: red">'.__("users", "gd-star-rating").'</span></strong>';
                break;
            case 'N':
            default:
                $row->moderate_comments = __("comments", "gd-star-rating").': <strong>'.__("free", "gd-star-rating").'</strong>';
                break;
        }
        switch ($row->rules_articles) {
            case 'I':
                $row->rules_articles = __("articles", "gd-star-rating").': <strong><span style="color: blue">'.__("inherited", "gd-star-rating").'</span></strong>';
                break;
            case 'H':
                $row->rules_articles = __("articles", "gd-star-rating").': <strong><span style="color: red">'.__("hidden", "gd-star-rating").'</span></strong>';
                break;
            case 'N':
                $row->rules_articles = __("articles", "gd-star-rating").': <strong><span style="color: red">'.__("locked", "gd-star-rating").'</span></strong>';
                break;
            case 'V':
                $row->rules_articles = __("articles", "gd-star-rating").': <strong>'.__("visitors", "gd-star-rating").'</strong>';
                break;
            case 'U':
                $row->rules_articles = __("articles", "gd-star-rating").': <strong>'.__("users", "gd-star-rating").'</strong>';
                break;
            default:
                $row->rules_articles = __("articles", "gd-star-rating").': <strong>'.__("everyone", "gd-star-rating").'</strong>';
                break;
        }
        switch ($row->rules_comments) {
            case 'I':
                $row->rules_comments = __("comments", "gd-star-rating").': <strong><span style="color: blue">'.__("inherited", "gd-star-rating").'</span></strong>';
                break;
            case 'H':
                $row->rules_comments = __("comments", "gd-star-rating").': <strong><span style="color: red">'.__("hidden", "gd-star-rating").'</span></strong>';
                break;
            case 'N':
                $row->rules_comments = __("comments", "gd-star-rating").': <strong><span style="color: red">'.__("locked", "gd-star-rating").'</span></strong>';
                break;
            case 'V':
                $row->rules_comments = __("comments", "gd-star-rating").': <strong>'.__("visitors", "gd-star-rating").'</strong>';
                break;
            case 'U':
                $row->rules_comments = __("comments", "gd-star-rating").': <strong>'.__("users", "gd-star-rating").'</strong>';
                break;
            default:
                $row->rules_comments = __("comments", "gd-star-rating").': <strong>'.__("everyone", "gd-star-rating").'</strong>';
                break;
        }

        $votes_v = '/';
        $count_v = '[ 0 ] ';
        if ($row->visitor_voters > 0) {
            $visitor_rating = @number_format($row->visitor_votes / $row->visitor_voters, 1);
            $row->rating_visitors = $visitor_rating;
            $votes_v = '<strong><span style="color: red">'.$visitor_rating.'</span></strong>';
            $count_v = sprintf('[ <a href="./admin.php?page=gd-star-rating-stats&gdsr=voters&pid=%s&vt=article&vg=visitors"> <strong style="color: red;">%s</strong> </a> ] ', $row->pid, $row->visitor_voters);
        }

        $votes_u = '/';
        $count_u = '[ 0 ] ';
        if ($row->user_voters > 0) {
            $user_rating = @number_format($row->user_votes / $row->user_voters, 1);
            $row->rating_users = $user_rating;
            $votes_u = '<strong><span style="color: red">'.$user_rating.'</span></strong>';
            $count_u = sprintf('[ <a href="./admin.php?page=gd-star-rating-stats&gdsr=voters&pid=%s&vt=article&vg=users"> <strong style="color: red;">%s</strong> </a> ] ', $row->pid, $row->user_voters);
        }

        if ($row->review == -1 || $row->review == '') $row->review = "/";
        $row->review = '<strong><span style="color: blue">'.$row->review.'</span></strong>';

        $total_votes = $row->visitor_votes + $row->user_votes;
        $total_voters = $row->visitor_voters + $row->user_voters;

        $votes_t = '/';
        $count_t = '[ 0 ] ';
        if ($total_voters > 0) {
            $total_rating =  @number_format($total_votes / $total_voters, 1);
            $row->rating_total = $total_rating;
            $votes_t = '<strong><span style="color: red">'.$total_rating.'</span></strong>';
            $count_t = sprintf('[ <a href="./admin.php?page=gd-star-rating-stats&gdsr=voters&pid=%s&vt=article&vg=total"> <strong style="color: red;">%s</strong> </a> ] ', $row->pid, $total_voters);
        }

        $row->total = $count_t.__("rating", "gd-star-rating").': <strong>'.$votes_t.'</strong><br />[ '.$row->views.' ] '.__("views", "gd-star-rating");
        $row->votes = $count_v.__("visitors", "gd-star-rating").': <strong>'.$votes_v.'</strong><br />'.$count_u.__("users", "gd-star-rating").': <strong>'.$votes_u.'</strong>';

        $row->title = sprintf('<a href="./post.php?action=edit&post=%s">%s</a>', $row->pid, $row->post_title);

        return $row;
    }

    function convert_category_row($row) {
        switch ($row->moderate_articles) {
            case 'A':
                $row->moderate_articles = __("articles", "gd-star-rating").': <strong><span style="color: red">'.__("all", "gd-star-rating").'</span></strong>';
                break;
            case 'V':
                $row->moderate_articles = __("articles", "gd-star-rating").': <strong><span style="color: red">'.__("visitors", "gd-star-rating").'</span></strong>';
                break;
            case 'U':
                $row->moderate_articles = __("articles", "gd-star-rating").': <strong><span style="color: red">'.__("users", "gd-star-rating").'</span></strong>';
                break;
            default:
                $row->moderate_articles = __("articles", "gd-star-rating").': <strong>'.__("free", "gd-star-rating").'</strong>';
                break;
        }
        switch ($row->moderate_comments) {
            case 'A':
                $row->moderate_comments = __("comments", "gd-star-rating").': <strong><span style="color: red">'.__("all", "gd-star-rating").'</span></strong>';
                break;
            case 'V':
                $row->moderate_comments = __("comments", "gd-star-rating").': <strong><span style="color: red">'.__("visitors", "gd-star-rating").'</span></strong>';
                break;
            case 'U':
                $row->moderate_comments = __("comments", "gd-star-rating").': <strong><span style="color: red">'.__("users", "gd-star-rating").'</span></strong>';
                break;
            default:
                $row->moderate_comments = __("comments", "gd-star-rating").': <strong>'.__("free", "gd-star-rating").'</strong>';
                break;
        }
        switch ($row->rules_articles) {
            case 'H':
                $row->rules_articles = __("articles", "gd-star-rating").': <strong><span style="color: red">'.__("hidden", "gd-star-rating").'</span></strong>';
                break;
            case 'N':
                $row->rules_articles = __("articles", "gd-star-rating").': <strong><span style="color: red">'.__("locked", "gd-star-rating").'</span></strong>';
                break;
            case 'V':
                $row->rules_articles = __("articles", "gd-star-rating").': <strong>'.__("visitors", "gd-star-rating").'</strong>';
                break;
            case 'U':
                $row->rules_articles = __("articles", "gd-star-rating").': <strong>'.__("users", "gd-star-rating").'</strong>';
                break;
            default:
                $row->rules_articles = __("articles", "gd-star-rating").': <strong>'.__("everyone", "gd-star-rating").'</strong>';
                break;
        }
        switch ($row->rules_comments) {
            case 'H':
                $row->rules_comments = __("comments", "gd-star-rating").': <strong><span style="color: red">'.__("hidden", "gd-star-rating").'</span></strong>';
                break;
            case 'N':
                $row->rules_comments = __("comments", "gd-star-rating").': <strong><span style="color: red">'.__("locked", "gd-star-rating").'</span></strong>';
                break;
            case 'V':
                $row->rules_comments = __("comments", "gd-star-rating").': <strong>'.__("visitors", "gd-star-rating").'</strong>';
                break;
            case 'U':
                $row->rules_comments = __("comments", "gd-star-rating").': <strong>'.__("users", "gd-star-rating").'</strong>';
                break;
            default:
                $row->rules_comments = __("comments", "gd-star-rating").': <strong>'.__("everyone", "gd-star-rating").'</strong>';
                break;
        }
        return $row;
    }

    function convert_moderation_row($row) {
        if ($row->user_id == 0)
            $row->username = '<span style="color: red">visitor</span>';
        else
            $row->username = sprintf('<a href="./user-edit.php?user_id=%s">%s</a>', $row->user_id, $row->username);
        
        return $row;
    }

    function convert_comment_row($row) {
        $votes_v = '/';
        $count_v = '[ 0 ] ';
        if ($row->visitor_voters > 0) {
            $visitor_rating = @number_format($row->visitor_votes / $row->visitor_voters, 1);
            $row->rating_visitors = $visitor_rating;
            $votes_v = '<strong><span style="color: red">'.$visitor_rating.'</span></strong>';
            $count_v = sprintf('[ <a href="./admin.php?page=gd-star-rating-stats&gdsr=voters&pid=%s&vt=comment&vg=visitors"> <strong style="color: red;">%s</strong> </a> ] ', $row->comment_id, $row->visitor_voters);
        }

        $votes_u = '/';
        $count_u = '[ 0 ] ';
        if ($row->user_voters > 0) {
            $user_rating = @number_format($row->user_votes / $row->user_voters, 1);
            $row->rating_users = $user_rating;
            $votes_u = '<strong><span style="color: red">'.$user_rating.'</span></strong>';
            $count_u = sprintf('[ <a href="./admin.php?page=gd-star-rating-stats&gdsr=voters&pid=%s&vt=comment&vg=users"> <strong style="color: red;">%s</strong> </a> ] ', $row->comment_id, $row->user_voters);
        }

        $total_votes = $row->visitor_votes + $row->user_votes;
        $total_voters = $row->visitor_voters + $row->user_voters;

        $votes_t = '/';
        $count_t = '[ 0 ] ';
        if ($total_voters > 0) {
            $total_rating = @number_format($total_votes / $total_voters, 1);
            $row->rating_total = $total_rating;
            $votes_t = '<strong><span style="color: red">'.$total_rating.'</span></strong>';
            $count_t = sprintf('[ <a href="./admin.php?page=gd-star-rating-stats&gdsr=voters&pid=%s&vt=comment&vg=total"> <strong style="color: red;">%s</strong> </a> ] ', $row->comment_id, $total_voters);
        }

        $row->total = $count_t.__("votes", "gd-star-rating").': <strong>'.$votes_t.'</strong>';
        $row->votes = $count_v.__("visitors", "gd-star-rating").': <strong>'.$votes_v.'</strong><br />'.$count_u.__("users", "gd-star-rating").': <strong>'.$votes_u.'</strong>';

        if ($row->review == -1) $row->review = "/";
        $row->review = '<strong><span style="color: blue">'.$row->review.'</span></strong>';

        return $row;
    }
    // conversion

    // moderation
    function moderation_approve($ids, $ids_array) {
        global $wpdb, $table_prefix;

        $sql = sprintf("select * from %s where record_id in %s", $table_prefix."gdsr_moderate", $ids);
        $rows = $wpdb->get_results($sql);
        foreach ($rows as $row) {
            if ($row->vote_type == "article")
                GDSRDatabase::add_vote($row->id, $row->user_id, $row->ip, $row->user_agent, $row->vote);
            if ($row->vote_type == "comment")
                GDSRDatabase::add_vote_comment($row->id, $row->user_id, $row->ip, $row->user_agent, $row->vote);
        }

        GDSRDB::moderation_delete($ids);
    }

    function moderation_delete($ids) {
        global $wpdb, $table_prefix;

        $sql = sprintf("delete from %s where record_id in %s", $table_prefix."gdsr_moderate", $ids);
        $wpdb->query($sql);
    }
    // moderation

    // templates
    function get_templates($section = '', $default_sort = false, $only_default = false) {
        global $wpdb, $table_prefix;
        if ($section != '') $section = sprintf(" WHERE section = '%s'", $section);
        $default_sort = $default_sort ? "`default` desc, preinstalled desc, " : "";
        $default_limit = $only_default ? " LIMIT 0, 1" : "";

        $sql = sprintf("select * from %sgdsr_templates%s order by %stemplate_id asc%s", $table_prefix, $section, $default_sort, $default_limit);
        if ($only_default) return $wpdb->get_row($sql);
        return $wpdb->get_results($sql);
    }

    function set_templates_defaults($post) {
        global $wpdb, $table_prefix;

        foreach ($post as $code => $value) {
            $sql = sprintf("update %sgdsr_templates set `default` = '0' where section = '%s'", $table_prefix, $code);
            $wpdb->query($sql);
            $sql = sprintf("update %sgdsr_templates set `default` = '1' where template_id = %s", $table_prefix, $value);
            $wpdb->query($sql);
        }
    }

    function get_template($id) {
        global $wpdb, $table_prefix;
        $sql = sprintf("SELECT * FROM %sgdsr_templates WHERE `template_id` = %s",
            $table_prefix, $id);
        return $wpdb->get_row($sql);
    }

    function edit_template($general, $elements) {
        global $wpdb, $table_prefix;
        $sql = sprintf("UPDATE %sgdsr_templates SET `section` = '%s', `name` = '%s', `description` = '%s', `elements` = '%s', `dependencies` = '%s', `preinstalled` = '%s' WHERE `template_id` = %s",
            $table_prefix, $general["section"], $general["name"], $general["description"], serialize($elements), serialize($general["dependencies"]), $general["preinstalled"], $general["id"]);
        $wpdb->query($sql);
        return $general["id"];
    }

    function delete_template($id) {
        global $wpdb, $table_prefix;
        $sql = sprintf("DELETE FROM %sgdsr_templates WHERE `template_id` = %s",
            $table_prefix, $id);
        return $wpdb->query($sql);
    }

    function add_template($general, $elements) {
        global $wpdb, $table_prefix;
        $sql = sprintf("INSERT INTO %sgdsr_templates (`section`, `name`, `description`, `elements`, `dependencies`, `preinstalled`, `default`) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '0')",
            $table_prefix, $general["section"], $general["name"], $general["description"], serialize($elements), serialize($general["dependencies"]), $general["preinstalled"]);
        $wpdb->query($sql);
        return $wpdb->insert_id;
    }

    function insert_extras_templates($path, $default = true) {
        global $wpdb, $table_prefix;
        $templates = array();

        if ($default) $path.= "install/data/gdsr_templates_xtra.txt";
        else $path.= "data/gdsr_templates_cstm.txt";

        if (file_exists($path)) {
            $tpls = file($path);
            foreach ($tpls as $tpl) {
                $pipe = strpos($tpl, "|");
                $tpl_check = substr($tpl, 0, $pipe);
                $tpl_section = substr($tpl, $pipe + 1, 3);
                $tpl_insert = substr($tpl, $pipe + 5);
                $sql = sprintf("select template_id from %sgdsr_templates where name = '%s' and preinstalled = '2'", $table_prefix, $tpl_check);
                $tpl_id = intval($wpdb->get_var($sql));
                if ($tpl_id == 0) {
                    $sql = str_replace("%sgdsr_templates", $table_prefix."gdsr_templates", $tpl_insert);
                    $wpdb->query($sql);
                    $tpl_id = $wpdb->insert_id;
                }
                $template["section"] = $tpl_section;
                $template["tpl_id"] = sprintf("%s", $tpl_id);
                $templates[] = $template;
            }
        }
        if (count($templates) > 0) {
            include(STARRATING_PATH.'code/t2/gd-star-t2-templates.php');
            $depend = array();
            foreach ($tpls->tpls as $tpl) {
                $section = $tpl->code;
                $sql = sprintf("select template_id from %sgdsr_templates where section = '%s' and preinstalled = '1'", $table_prefix, $section);
                $tpl_id = intval($wpdb->get_var($sql));
                $depend[$section] = $tpl_id;
            }
            foreach ($templates as $tpl) {
                $dep = array();
                $t = $tpls->get_list($tpl["section"]);
                foreach ($t->tpls as $tag) {
                    $s = $tag->code;
                    $dep[$s] = sprintf("%s", $depend[$s]);
                }
                if (count($dep) > 0) {
                    $sql = sprintf("update %sgdsr_templates set dependencies = '%s' where template_id = %s",
                        $table_prefix, serialize($dep), $tpl["tpl_id"]);
                    $wpdb->query($sql);
                }
            }
        }
    }

    function insert_default_templates($path) {
        global $wpdb, $table_prefix;
        $templates = array();
        $path.= "install/data/gdsr_templates_main.txt";
        if (file_exists($path)) {
            $tpls = file($path);
            foreach ($tpls as $tpl) {
                $tpl_check = substr($tpl, 0, 3);
                $tpl_insert = substr($tpl, 4);
                $sql = sprintf("select template_id from %sgdsr_templates where section = '%s' and preinstalled = '1'", $table_prefix, $tpl_check);
                $tpl_id = intval($wpdb->get_var($sql));
                if ($tpl_id == 0) {
                    $sql = str_replace("%sgdsr_templates", $table_prefix."gdsr_templates", $tpl_insert);
                    $wpdb->query($sql);
                    $tpl_id = $wpdb->insert_id;
                }
                $templates[$tpl_check] = sprintf("%s", $tpl_id);
            }
        }
        if (count($templates) > 0) {
            include(STARRATING_PATH.'code/t2/gd-star-t2-templates.php');
            foreach ($tpls->tpls as $tpl) {
                $depend = array();
                foreach ($tpl->elements as $el) {
                    if ($el->tpl > -1) {
                        $section = $tpl->tpls[$el->tpl]->code;
                        $depend[$section] = $templates[$section];
                    }
                }
                if (count($depend) > 0) {
                    $sql = sprintf("update %sgdsr_templates set dependencies = '%s' where template_id = %s",
                        $table_prefix, serialize($depend), $templates[$tpl->code]);
                    $wpdb->query($sql);
                }
            }
        }
    }

    function update_default_templates($path) {
        global $wpdb, $table_prefix;
        $path.= "install/data/gdsr_templates_rplc.txt";
        if (file_exists($path)) {
            $tpls = file($path);
            foreach ($tpls as $tpl) {
                $tpl_check = substr($tpl, 0, 3);
                $tpl_value = substr($tpl, 4);
                $sql = sprintf("update %sgdsr_templates set elements = '%s' where section = '%s' and preinstalled = '1'", $table_prefix, $tpl_value, $tpl_check);
                $wpdb->query($sql);
            }
        }
    }
    // templates

    // totals
    function front_page_article_totals() {
        global $wpdb, $table_prefix;
        return $wpdb->get_row(sprintf("select sum(visitor_voters) as votersv, sum(visitor_votes) as votesv, sum(user_voters) as votersu, sum(user_votes) as votesu from %s", $table_prefix."gdsr_data_article"));
    }

    function front_page_comment_totals() {
        global $wpdb, $table_prefix;
        return $wpdb->get_row(sprintf("select sum(visitor_voters) as votersv, sum(visitor_votes) as votesv, sum(user_voters) as votersu, sum(user_votes) as votesu from %s", $table_prefix."gdsr_data_comment"));
    }

    function front_page_moderation_totals() {
        global $wpdb, $table_prefix;
        return $wpdb->get_row(sprintf("select vote_type, count(*) as queue from %s group by vote_type", $table_prefix."gdsr_moderate"));
    }
    // totals

    // recalculate
    function recalculate_articles($gdsr_oldstars, $gdsr_newstars) {
        global $wpdb, $table_prefix;
        $rate = $gdsr_newstars / $gdsr_oldstars;
        $sql = "UPDATE ".$table_prefix."gdsr_data_article SET user_votes = user_votes * ".$rate.", visitor_votes = visitor_votes * ".$rate;
        $wpdb->query($sql);
    }

    function recalculate_comments($gdsr_oldstars, $gdsr_newstars) {
        global $wpdb, $table_prefix;
        $rate = $gdsr_newstars / $gdsr_oldstars;
        $sql = "UPDATE ".$table_prefix."gdsr_data_comment SET user_votes = user_votes * ".$rate.", visitor_votes = visitor_votes * ".$rate;
        $wpdb->query($sql);
    }

    function recalculate_reviews($gdsr_oldstars, $gdsr_newstars) {
        global $wpdb, $table_prefix;
        $rate = $gdsr_newstars / $gdsr_oldstars;
        $sql = "UPDATE ".$table_prefix."gdsr_data_article SET review = review * ".$rate." where review > -1";
        $wpdb->query($sql);
    }

    function recalculate_comments_reviews($gdsr_oldstars, $gdsr_newstars) {
        global $wpdb, $table_prefix;
        $rate = $gdsr_newstars / $gdsr_oldstars;
        $sql = "UPDATE ".$table_prefix."gdsr_data_comment SET review = review * ".$rate." where review > -1";
        $wpdb->query($sql);
    }
    // recalculate
}

?>