<?php

class GDSRDBMulti {
    function get_multisets_for_auto_insert() {
        global $wpdb, $table_prefix;

        $sql = sprintf("select * from %sgdsr_multis where auto_insert != 'none'", $table_prefix);
        return $wpdb->get_results($sql);
    }

    function recalculate_trend_averages($trend_id, $set) {
        global $wpdb, $table_prefix;

        $multi_data = GDSRDBMulti::get_trend_values($trend_id);
        $weight_norm = array_sum($set->weight);
        $total_users = $total_visitors = $total_votes = 0;
        $user_weighted = $visitors_weighted = $weighted = 0;
        $i = 0;
        foreach ($multi_data as $md) {
            $v_user = $v_visitor = $s_user = $s_visitor = $r_user = $r_visitor = 0;

            $v_visitor = $md->visitor_voters;
            $s_visitor = $md->visitor_votes;
            $v_user = $md->user_voters;
            $s_user = $md->user_votes;

            if ($v_visitor > 0) $r_visitor = $s_visitor / $v_visitor;
            if ($v_user > 0) $r_user = $s_user / $v_user;
            if ($r_visitor > $set->stars) $r_visitor = $set->stars;
            if ($r_user > $set->stars) $r_user = $set->stars;

            $r_visitor = @number_format($r_visitor, 1);
            $r_user = @number_format($r_user, 1);
            $visitors_weighted += ($r_visitor * $set->weight[$i]) / $weight_norm;
            $user_weighted += ($r_user * $set->weight[$i]) / $weight_norm;
            $total_visitors += $v_visitor;
            $total_users += $v_user;

            $i++;
        }
        $rating_users = @number_format($user_weighted, 1);
        $rating_visitors = @number_format($visitors_weighted, 1);
        $total_users = @number_format($total_users / $i, 0);
        $total_visitors = @number_format($total_visitors / $i, 0);

        $sql = sprintf("update %sgdsr_multis_trend set average_rating_users = '%s', average_rating_visitors = '%s', total_votes_users = '%s', total_votes_visitors = '%s' where id = %s",
            $table_prefix, $rating_users, $rating_visitors, $total_users, $total_visitors, $trend_id);
        $wpdb->query($sql);
    }

    function recalculate_all_sets() {
        global $wpdb, $table_prefix;
        $set = null;
        $prev_set = 0;

        $sql = sprintf("select id, post_id, multi_id from %sgdsr_multis_data order by multi_id asc", $table_prefix);
        $posts = $wpdb->get_results($sql);
        foreach ($posts as $post) {
            if ($prev_set != $post->multi_id) $set = gd_get_multi_set($post->multi_id);
            GDSRDBMulti::recalculate_multi_averages($post->post_id, $post->multi_id, "", $set);
            GDSRDBMulti::recalculate_multi_review_db($post->post_id, $post->id, $set);
        }

        $prev_set = 0;

        $sql = sprintf("select id, multi_id from %sgdsr_multis_trend order by multi_id asc", $table_prefix);
        $ids = $wpdb->get_results($sql);
        foreach ($ids as $id) {
            if ($prev_set != $id->multi_id) $set = gd_get_multi_set($id->multi_id);
            foreach ($ids as $id) GDSRDBMulti::recalculate_trend_averages($id->id, $set);
        }
    }

    function recalculate_set($set_id) {
        global $wpdb, $table_prefix;
        $set = gd_get_multi_set($set_id);

        $sql = sprintf("select id, post_id from %sgdsr_multis_data where multi_id = %s", $table_prefix, $set_id);
        $posts = $wpdb->get_results($sql);
        foreach ($posts as $post) {
            GDSRDBMulti::recalculate_multi_averages($post->post_id, $set_id, "", $set);
            GDSRDBMulti::recalculate_multi_review_db($post->post_id, $post->id, $set);
        }

        $sql = sprintf("select id from %sgdsr_multis_trend where multi_id = %s", $table_prefix, $set_id);
        $ids = $wpdb->get_results($sql);
        foreach ($ids as $id) GDSRDBMulti::recalculate_trend_averages($id->id, $set);
    }

    function get_multi_rating_data($set_id, $post_id) {
        global $wpdb, $table_prefix;
        $sql = sprintf("select * from %sgdsr_multis_data where post_id = %s and multi_id = %s", $table_prefix, $post_id, $set_id);
        return $wpdb->get_row($sql);
    }

    function recalculate_multi_review_db($post_id, $record_id, $set) {
        global $wpdb, $table_prefix;
        $multi_data = GDSRDBMulti::get_values($record_id, 'rvw');
        if (count($multi_data) == 0) {
            GDSRDBMulti::add_empty_review_values($record_id, count($set->object));
            $multi_data = GDSRDBMulti::get_values($record_id, 'rvw');
        }
        $review = new GDSRArticleMultiReview($post_id);
        $review->set = $set;
        $i = 0;
        $weighted = 0;
        $weight_norm = array_sum($set->weight);
        foreach ($multi_data as $md) {
            $single_vote = array();
            $single_vote["votes"] = 1;
            $single_vote["score"] = $md->user_votes;
            $single_vote["rating"] = $single_vote["score"];
            $review->values = $single_vote;
            $weighted += ( $single_vote["rating"] * $set->weight[$i] ) / $weight_norm;
            $i++;
        }
        $review->rating = @number_format($weighted, 1);

        $sql = sprintf("update %sgdsr_multis_data set average_review = '%s' where id = %s", $table_prefix, $review->rating, $record_id);
        $wpdb->query($sql);

        return $review;
    }

    function recalculate_multi_review($record_id, $values, $set) {
        global $wpdb, $table_prefix;

        $weight_norm = array_sum($set->weight);
        $overall = 0;
        for ($i = 0; $i < count($values); $i++) {
            $overall += ($values[$i] * $set->weight[$i]) / $weight_norm;
        }
        $overall = @number_format($overall, 1);

        $sql = sprintf("update %sgdsr_multis_data set average_review = '%s' where id = %s", $table_prefix, $overall, $record_id);
        $wpdb->query($sql);

        return $overall;
    }

    function recalculate_multi_averages($post_id, $set_id, $rules = "", $set = null, $last_voted = false) {
        global $wpdb, $table_prefix;

        if ($set == null) $set = gd_get_multi_set($set_id);
        $multi_data = GDSRDBMulti::get_values_join($post_id, $set_id);
        $votes_js = array();
        $weight_norm = array_sum($set->weight);
        $total_users = $total_visitors = $total_votes = 0;
        $user_weighted = $visitors_weighted = $weighted = 0;
        $i = 0;
        foreach ($multi_data as $md) {
            $votes = $score = $rating = $v_user = $v_visitor = $s_user = $s_visitor = $r_user = $r_visitor = 0;

            $v_visitor = $md->visitor_voters;
            $s_visitor = $md->visitor_votes;
            $v_user = $md->user_voters;
            $s_user = $md->user_votes;

            if ($v_visitor > 0) $r_visitor = $s_visitor / $v_visitor;
            if ($v_user > 0) $r_user = $s_user / $v_user;
            if ($r_visitor > $set->stars) $r_visitor = $set->stars;
            if ($r_user > $set->stars) $r_user = $set->stars;

            $r_visitor = @number_format($r_visitor, 1);
            $r_user = @number_format($r_user, 1);
            $visitors_weighted += ($r_visitor * $set->weight[$i]) / $weight_norm;
            $user_weighted += ($r_user * $set->weight[$i]) / $weight_norm;
            $total_visitors += $v_visitor;
            $total_users += $v_user;

            if ($rules != "") {
                if ($rules == "A" || $rules == "N") {
                    $votes = $md->user_voters + $md->visitor_voters;
                    $score = $md->user_votes + $md->visitor_votes;
                }
                else if ($rules == "V") {
                    $votes = $md->visitor_voters;
                    $score = $md->visitor_votes;
                }
                else if ($rules == "U") {
                    $votes = $md->user_voters;
                    $score = $md->user_votes;
                }
                if ($votes > 0) $rating = $score / $votes;
                if ($rating > $set->stars) $rating = $set->stars;
                $rating = @number_format($rating, 1);
                $votes_js[] = $rating * $this->o["mur_size"];
                $weighted += ($rating * $set->weight[$i]) / $weight_norm;
                $total_votes += $votes;
            }
            $i++;
        }
        $rating_users = @number_format($user_weighted, 1);
        $rating_visitors = @number_format($visitors_weighted, 1);
        $total_users = @number_format($total_users / $i, 0);
        $total_visitors = @number_format($total_visitors / $i, 0);

        if ($rules != "") {
            $rating = @number_format($weighted, 1);
            $total_votes = @number_format($total_votes / $i, 0);
            $output["total"]["rating"] = $rating;
            $output["total"]["votes"] = $total_votes;
            $output["json"] = $votes_js;
        }

        $lastv = $last_voted ? ", last_voted = CURRENT_TIMESTAMP" : "";

        $sql = sprintf("update %sgdsr_multis_data set average_rating_users = '%s', average_rating_visitors = '%s', total_votes_users = '%s', total_votes_visitors = '%s'%s where post_id = %s and multi_id = %s",
            $table_prefix, $rating_users, $rating_visitors, $total_users, $total_visitors, $lastv, $post_id, $set_id);
        $wpdb->query($sql);

        $output["users"]["rating"] = $rating_users;
        $output["users"]["votes"] = $total_users;
        $output["visitors"]["rating"] = $rating_visitors;
        $output["visitors"]["votes"] = $total_visitors;

        return $output;
    }

    function clean_revision_articles() {
        global $wpdb, $table_prefix;
        $sql = sprintf("delete %s from %sgdsr_multis_data l inner join %sposts o on o.ID = l.post_id where o.post_type = 'revision'",
            gdFunctionsGDSR::mysql_pre_4_1() ? sprintf("%sgdsr_multis_data", $table_prefix) : "l",
            $table_prefix, $table_prefix);
        $wpdb->query($sql);
        $posts = $wpdb->rows_affected;

        $sql = sprintf("delete %s from %sgdsr_multis_values l left join %sgdsr_multis_data o on o.id = l.id where o.id is null",
            gdFunctionsGDSR::mysql_pre_4_1() ? sprintf("%sgdsr_multis_values", $table_prefix) : "l",
            $table_prefix, $table_prefix);
        $wpdb->query($sql);

        return $posts;
    }

    function clean_dead_articles() {
        global $wpdb, $table_prefix;
        $sql = sprintf("delete %s from %sgdsr_multis_data l left join %sposts o on o.ID = l.post_id where o.ID is null",
            gdFunctionsGDSR::mysql_pre_4_1() ? sprintf("%sgdsr_multis_data", $table_prefix) : "l",
            $table_prefix, $table_prefix);
        $wpdb->query($sql);
        $posts = $wpdb->rows_affected;

        $sql = sprintf("delete %s from %sgdsr_multis_values l left join %sgdsr_multis_data o on o.id = l.id where o.id is null",
            gdFunctionsGDSR::mysql_pre_4_1() ? sprintf("%sgdsr_multis_values", $table_prefix) : "l",
            $table_prefix, $table_prefix);
        $wpdb->query($sql);

        return $posts;
    }

    function get_stats_count($set_id, $dates = "0", $cats = "0", $search = "") {
        global $table_prefix;
        $where = " and ms.multi_id = ".$set_id;

        if ($dates != "" && $dates != "0") {
            $where.= " and year(p.post_date) = ".substr($dates, 0, 4);
            $where.= " and month(p.post_date) = ".substr($dates, 4, 2);
        }
        if ($search != "")
            $where.= " and p.post_title like '%".$search."%'";

        if ($cats != "" && $cats != "0")
            $sql = sprintf("SELECT p.post_type, count(*) as count FROM %sterm_taxonomy t, %sterm_relationships r, %sposts p, %sgdsr_multis_data ms WHERE p.ID = ms.post_id and t.term_taxonomy_id = r.term_taxonomy_id AND r.object_id = p.ID AND t.term_id = %s AND p.post_status = 'publish'%s GROUP BY p.post_type",
                $table_prefix, $table_prefix, $table_prefix, $table_prefix, $cats, $where
            );
        else
            $sql = sprintf("select p.post_type, count(*) as count from %sposts p inner join %sgdsr_multis_data ms on p.ID = ms.post_id where p.post_status = 'publish'%s group by post_type",
                $table_prefix, $table_prefix, $where
            );
        return $sql;
    }

    function get_stats($set_id, $select = "", $start = 0, $limit = 20, $dates = "0", $cats = "0", $search = "", $sort_column = 'id', $sort_order = 'desc', $additional = '') {
        global $table_prefix;
        $where = " and ms.multi_id = ".$set_id;

        if ($dates != "" && $dates != "0") {
            $where.= " and year(p.post_date) = ".substr($dates, 0, 4);
            $where.= " and month(p.post_date) = ".substr($dates, 4, 2);
        }
        if ($search != "")
            $where.= " and p.post_title like '%".$search."%'";

        if ($select != "" && $select != "postpage")
            $where.= " and post_type = '".$select."'";

        if ($sort_column == 'post_title' || $sort_column == 'id')
            $order = " ORDER BY p.".$sort_column." ".$sort_order;
        else
            $order = " ORDER BY ".$sort_column." ".$sort_order;

        if ($cats != "" && $cats != "0")
            $sql = sprintf("SELECT p.id as pid, p.post_title, p.post_type, ms.* FROM %sterm_taxonomy t, %sterm_relationships r, %sposts p, %sgdsr_multis_data ms WHERE ms.post_id = p.id and t.term_taxonomy_id = r.term_taxonomy_id AND r.object_id = p.id AND t.term_id = %s AND p.post_status = 'publish'%s%s%s LIMIT %s, %s",
                 $table_prefix, $table_prefix, $table_prefix, $table_prefix, $cats, $where, $additional, $order, $start, $limit
            );
        else
            $sql = sprintf("select p.id as pid, p.post_title, p.post_type, ms.* from %sposts p left join %sgdsr_multis_data ms on p.id = ms.post_id WHERE p.post_status = 'publish'%s%s%s limit %s, %s",
                $table_prefix, $table_prefix, $where, $additional, $order, $start, $limit
            );
        return $sql;
    }

    function delete_sets($ids) {
        global $wpdb, $table_prefix;
        $sql = sprintf("delete from %sgdsr_multis where multi_id in %s", $table_prefix, $ids);
        $wpdb->query($sql);
    }

    function save_vote($post_id, $set_id, $user_id, $ip, $ua, $values, $post_data) {
        global $wpdb, $table_prefix;
        $ua = str_replace("'", "''", $ua);
        $ua = substr($ua, 0, 250);

        if ($post_data->moderate_articles == "" || $post_data->moderate_articles == "N" || ($post_data->moderate_articles == "V" && $user > 0) || ($post_data->moderate_articles == "U" && $user == 0)) {
            GDSRDBMulti::add_vote($post_id, $set_id, $user_id, $ip, $ua, $values);
            GDSRDBMulti::add_to_log($post_id, $set_id, $user_id, $ip, $ua, $values);
        }
        else {
            $modsql = sprintf("INSERT INTO %sgdsr_moderate (id, vote_type, multi_id, user_id, object, voted, ip, user_agent) VALUES (%s, 'multis', %s, %s, '%s', '%s', '%s', '%s')",
                $table_prefix, $post_id, $set_id, $user_id, serialize($values), str_replace("'", "''", current_time('mysql')), $ip, $ua);
            wp_gdsr_dump("MOD", $modsql);
            $wpdb->query($modsql);
        }
    }

    function add_to_log($post_id, $set_id, $user_id, $ip, $ua, $values) {
        global $wpdb, $table_prefix;
            $modsql = sprintf("INSERT INTO %sgdsr_votes_log (id, vote_type, multi_id, user_id, object, voted, ip, user_agent) VALUES (%s, 'multis', %s, %s, '%s', '%s', '%s', '%s')",
                $table_prefix, $post_id, $set_id, $user_id, serialize($values), str_replace("'", "''", current_time('mysql')), $ip, $ua);
            wp_gdsr_dump("LOG", $modsql);
            $wpdb->query($modsql);
    }

    function add_vote($post_id, $set_id, $user_id, $ip, $ua, $votes) {
        global $wpdb, $table_prefix;
        $set = gd_get_multi_set($set_id);
        $data = $table_prefix.'gdsr_multis_data';
        $trend = $table_prefix.'gdsr_multis_trend';

        $trend_date = date("Y-m-d");

        $sql_trend = sprintf("SELECT id FROM %s WHERE vote_date = '%s' and post_id = %s and multi_id = %s", $trend, $trend_date, $post_id, $set_id);
        wp_gdsr_dump("TREND_CHECK", $sql_trend);
        $trend_data = intval($wpdb->get_var($sql_trend));
        wp_gdsr_dump("TREND_ID", $trend_data);
        
        $trend_added = false;
        if ($trend_data == 0) {
            $trend_added = true;
            $sql = sprintf("INSERT INTO %s (post_id, multi_id, vote_date) VALUES (%s, %s, '%s')", $trend, $post_id, $set_id, $trend_date);
            $wpdb->query($sql);
            $trend_id = $wpdb->insert_id;
        }
        else $trend_id = $trend_data;

        GDSRDBMulti::add_values($trend_id, $user_id, $votes, "trd", $trend_added ? "add" : "edit");
        GDSRDBMulti::recalculate_trend_averages($trend_id, $set);

        $data_id = GDSRDBMulti::get_vote($post_id, $set_id, count($set->object));

        GDSRDBMulti::add_values($data_id, $user_id, $votes);
    }

    function add_values($record_id, $user_id, $votes, $source = "dta", $operation = "edit") {
        global $wpdb, $table_prefix;
        $values = $table_prefix.'gdsr_multis_values';
        $cl_voters = $user_id == 0 ? "visitor_voters" : "user_voters";
        $cl_votes = $user_id == 0 ? "visitor_votes" : "user_votes";

        if ($operation == "add")
            $sql = sprintf("INSERT INTO %s (id, source, %s, %s, item_id) VALUES (%s, '%s', 1, %s, %s)", 
                $values, $cl_voters, $cl_votes, $record_id, $source, "%s", "%s");
        else
            $sql = sprintf("UPDATE %s SET %s = %s + 1, %s = %s + %s WHERE id = %s and item_id = %s and source = '%s'", 
                $values, $cl_voters, $cl_voters, $cl_votes, $cl_votes, "%s", $record_id, "%s", $source);

        $i = 0;
        foreach ($votes as $vote) {
            $sql_insert = sprintf($sql, $vote, $i);
            wp_gdsr_dump("SAVE_VOTE", $sql_insert);
            $wpdb->query($sql_insert);
            $i++;
        }
    }

    function calculate_set_rating($set, $record_id) {
        $values = GDSRDBMulti::get_values($record_id);
        $weight_norm = array_sum($set->weight);
        $weighted = array();
        $weighted["users"]["rating"] = 0;
        $weighted["visitors"]["rating"] = 0;
        $weighted["total"]["rating"] = 0;
        $weighted["users"]["votes"] = 0;
        $weighted["visitors"]["votes"] = 0;
        $weighted["total"]["votes"] = 0;
        $votes = false;
        foreach ($values as $row) {
            if ($row->user_voters > 0) $weighted["users"]["rating"] += ( ( $row->user_votes / $row->user_voters ) * $set->weight[$row->item_id] ) / $weight_norm;
            if ($row->visitor_voters > 0) $weighted["visitors"]["rating"] += ( ( $row->visitor_votes / $row->visitor_voters ) * $set->weight[$row->item_id] ) / $weight_norm;
            if ($row->visitor_voters + $row->user_voters > 0) $weighted["total"]["rating"] += ( ( ($row->visitor_votes + $row->user_votes) / ($row->visitor_voters + $row->user_voters) ) * $set->weight[$row->item_id] ) / $weight_norm;
            if (!$votes) {
                $votes = true;
                $weighted["users"]["votes"] = $row->user_voters;
                $weighted["visitors"]["votes"] = $row->visitor_voters;
                $weighted["total"]["votes"] = $row->visitor_voters + $row->user_voters;
            }
        }

        $weighted["users"]["rating"] = @number_format($weighted["users"]["rating"], 1);
        $weighted["visitors"]["rating"] = @number_format($weighted["visitors"]["rating"], 1);
        $weighted["total"]["rating"] = @number_format($weighted["total"]["rating"], 1);

        return $weighted;
    }

    function get_values($id, $source = 'dta') {
        global $wpdb, $table_prefix;
        
        $sql = sprintf("SELECT * FROM %sgdsr_multis_values WHERE source = '%s' and id = %s ORDER BY item_id ASC", $table_prefix, $source, $id);
        return $wpdb->get_results($sql);
    }

    function add_empty_review_values($id, $values = 0) {
        global $wpdb, $table_prefix;

        for ($i = 0; $i < $values; $i++) {
            $sql = sprintf("INSERT INTO %sgdsr_multis_values (id, source, item_id) VALUES (%s, 'rvw', %s)",
                $table_prefix, $id, $i);
            $wpdb->query($sql);
        }
    }

    function get_trend_values($id) {
        global $wpdb, $table_prefix;

        $sql = sprintf("select * from %sgdsr_multis_values where source = 'trd' and id = %s order by item_id asc",
            $table_prefix, $id);
        return $wpdb->get_results($sql);
    }

    function get_values_join($post_id, $set_id) {
        global $wpdb, $table_prefix;

        $sql = sprintf("select v.* from %sgdsr_multis_values v inner join %sgdsr_multis_data d on d.id = v.id where v.source = 'dta' and d.post_id = %s and d.multi_id = %s order by v.item_id asc",
            $table_prefix, $table_prefix, $post_id, $set_id);
        return $wpdb->get_results($sql);
    }

    function get_averages($post_id, $set_id) {
        global $wpdb, $table_prefix;
        
        $sql = sprintf("select * from %sgdsr_multis_data where post_id = %s and multi_id = %s", $table_prefix, $post_id, $set_id);
        return $wpdb->get_row($sql);
    }

    function get_vote($post_id, $set_id, $values) {
        global $wpdb, $table_prefix;

        $sql = sprintf("select id from %sgdsr_multis_data where post_id = %s and multi_id = %s", $table_prefix, $post_id, $set_id);
        $record_id = intval($wpdb->get_var($sql));

        if ($record_id == 0) {
            $sql = sprintf("INSERT INTO %sgdsr_multis_data (post_id, multi_id) VALUES (%s, %s)", $table_prefix, $post_id, $set_id);
            $wpdb->query($sql);
            $record_id = $wpdb->insert_id;
            for ($i = 0; $i < $values; $i++) {
                $sql = sprintf("INSERT INTO %sgdsr_multis_values (id, source, item_id) VALUES (%s, 'dta', %s)", $table_prefix, $record_id, $i);
                $wpdb->query($sql);
            }
        } else {
            $sql = sprintf("SELECT count(*) FROM %sgdsr_multis_values WHERE id = %s AND source = 'dta'", $table_prefix, $record_id);
            $counter = $wpdb->get_var($sql);
            if ($counter == 0) {
                for ($i = 0; $i < $values; $i++) {
                    $sql = sprintf("INSERT INTO %sgdsr_multis_values (id, source, item_id) VALUES (%s, 'dta', %s)", $table_prefix, $record_id, $i);
                    $wpdb->query($sql);
                }
            }
        }

        return $record_id;
    }

    function get_multi_review_average($record_id) {
        global $wpdb, $table_prefix;
        $sql = sprintf("select average_review from %sgdsr_multis_data where id = %s", $table_prefix, $record_id);
        return $wpdb->get_var($sql);
    }

    function save_review($record_id, $values) {
        global $wpdb, $table_prefix;

        $sql = sprintf("DELETE FROM %sgdsr_multis_values where id = %s and source = 'rvw'", $table_prefix, $record_id);
        $wpdb->query($sql);
        for ($i = 0; $i < count($values); $i++) {
            $sql = sprintf("INSERT INTO %sgdsr_multis_values (id, source, item_id, user_voters, user_votes) VALUES (%s, 'rvw', %s, 1, '%s')",
                $table_prefix, $record_id, $i, $values[$i]);
            wp_gdsr_dump("INSERT", $sql);
            $wpdb->query($sql);
        }
    }

    function check_vote($id, $user, $set, $type, $ip, $mod_only = false, $mixed = false) {
        $result = true;

        if (!$mod_only)
            $result = GDSRDBMulti::check_vote_logged($id, $user, $set, $type, $ip, $mixed);
        if ($result)
            $result = GDSRDBMulti::check_vote_moderated($id, $user, $set, $type, $ip, $mixed);

        return $result;
    }

    function check_vote_logged($id, $user, $set, $type, $ip, $mixed = false) {
        return GDSRDBMulti::check_vote_table('gdsr_votes_log', $id, $user, $set, $type, $ip, $mixed);
    }

    function check_vote_moderated($id, $user, $set, $type, $ip, $mixed = false) {
        return GDSRDBMulti::check_vote_table('gdsr_moderate', $id, $user, $set, $type, $ip, $mixed);
    }
    
    function check_vote_table($table, $id, $user, $set, $type, $ip, $mixed = false) {
        global $wpdb, $table_prefix;

        if ($user > 0) {
            $votes_sql = sprintf("SELECT count(*) FROM %s WHERE vote_type = '%s' and multi_id = %s and id = %s and user_id = %s", $table_prefix.$table, $type, $set, $id, $user);
            $votes = $wpdb->get_var($votes_sql);
            return $votes == 0;
        }
        else {
            $votes_sql = sprintf("SELECT * FROM %s WHERE vote_type = '%s' and multi_id = %s and id = %s and ip = '%s'", $table_prefix.$table, $type, $set, $id, $ip);
            $votes = $wpdb->get_var($votes_sql);
            if ($votes > 0 && $mixed) {
                $votes_sql = sprintf("SELECT * FROM %s WHERE vote_type = '%s' and user_id > 0 and multi_id = %s and id = %s and ip = '%s'", $table_prefix.$table, $type, $set, $id, $ip);
                $votes_mixed = $wpdb->get_var($votes_sql);
                if ($votes_mixed > 0) $votes = 0;
            }
            return $votes == 0;
        }
    }

    function get_usage_count_posts($set_id) {
        global $wpdb, $table_prefix;
        return $wpdb->get_var(sprintf("select count(*) from %sgdsr_multis_data where multi_id = %s", $table_prefix, $set_id));
    }

    function get_usage_count_post_reviews($set_id) {
        global $wpdb, $table_prefix;
        return $wpdb->get_var(sprintf("select count(*) from %sgdsr_multis_data where average_review > 0 and multi_id = %s", $table_prefix, $set_id));
    }

    function get_usage_count_voters($set_id) {
        global $wpdb, $table_prefix;
        $sql = sprintf("select count(*) from %sgdsr_votes_log where multi_id = %s and vote_type = 'multis'",
            $table_prefix, $set_id);
        return $wpdb->get_var($sql);
    }

    function get_multis_count() {
        global $wpdb, $table_prefix;
        return $wpdb->get_var(sprintf("select count(*) from %sgdsr_multis", $table_prefix));
    }

    function get_multis_tinymce() {
        global $wpdb, $table_prefix;
        $sql = sprintf("select multi_id as folder, name from %sgdsr_multis", $table_prefix);
        return $wpdb->get_results($sql);
    }
    
    function get_multis($start = 0, $limit = 20) {
        global $wpdb, $table_prefix;
        $sql = sprintf("select * from %sgdsr_multis limit %s, %s", $table_prefix, $start, $limit);
        return $wpdb->get_results($sql);
    }
    
    function get_multi_set($id) {
        global $wpdb, $table_prefix;
        $sql = sprintf("select * from %sgdsr_multis where multi_id = %s", $table_prefix, $id);
        return $wpdb->get_row($sql);
    }
    
    function add_multi_set($set) {
        global $wpdb, $table_prefix;
        $sql = sprintf("insert into %sgdsr_multis (`name`, `description`, `stars`, `object`, `weight`, `auto_insert`, `auto_location`, `auto_categories`) values ('%s', '%s', %s, '%s', '%s', '%s', '%s', '%s')",
                $table_prefix, $set->name, $set->description, $set->stars, serialize($set->object), serialize($set->weight), $set->auto_insert, $set->auto_location, $set->auto_categories
            );
        $wpdb->query($sql);
        return $wpdb->insert_id;
    }
    
    function edit_multi_set($set) {
        global $wpdb, $table_prefix;
        
        $sql = sprintf("update %sgdsr_multis set `name` = '%s', `description` = '%s', `object` = '%s', `weight` = '%s', `auto_insert` = '%s', `auto_location` = '%s', `auto_categories` = '%s' where multi_id = %s",
                $table_prefix, $set->name, $set->description, serialize($set->object), serialize($set->weight), $set->auto_insert, $set->auto_location, $set->auto_categories, $set->multi_id
            );
        $wpdb->query($sql);
    }
}

/**
 * Multi Rating Set
 */
class GDMultiSingle {
    var $multi_id = 0;
    var $name = "";
    var $description = "";
    var $stars = 10;
    var $object = array();
    var $weight = array();

    /**
     * Constructor
     *
     * @param bool $fill_empty prefill set with empty elements
     * @param int $count number of elements in the set
     */
    function GDMultiSingle($fill_empty = true, $count = 20) {
        if ($fill_empty) {
            for ($i = 0; $i < $count; $i++) {
                $this->object[] = "";
                $this->weight[] = 1;
            }
        }
    }
}

/**
 * Gets the multi rating set.
 *
 * @param int $id set id
 * @return GDMultiSingle multi rating set
 */
function gd_get_multi_set($id) {
    $set = GDSRDBMulti::get_multi_set($id);
    if (count($set) > 0) {
        $set->object = unserialize($set->object);
        $set->weight = unserialize($set->weight);
        return $set;
    }
    else return null;
}

?>