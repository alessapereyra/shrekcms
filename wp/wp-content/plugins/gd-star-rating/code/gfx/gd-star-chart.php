<?php

class GDSRChart {
    function votes_counter($vote_type = 'article') {
        global $wpdb, $table_prefix;
        $sql = sprintf("SELECT vote, count(*) as counter FROM %sgdsr_votes_log where vote_type = '%s' group by vote order by vote desc", $table_prefix, $vote_type);
        return $wpdb->get_results($sql);
    }

    function votes_trend_daily($id, $vote_type = 'article', $days = 30) {
        global $wpdb, $table_prefix;
        $mysql4_strtodate = "date_add(vote_date, interval 0 day)";
        $mysql5_strtodate = "str_to_date(vote_date, '%Y-%m-%d')";

        $strtodate = "";
        switch(gdFunctionsGDSR::mysql_version()) {
            case "4":
                $strtodate = $mysql4_strtodate;
                break;
            case "5":
            default:
                $strtodate = $mysql5_strtodate;
                break;
        }
        $sql = sprintf("SELECT user_voters, user_votes, visitor_voters, visitor_votes, %s as vote_date FROM %sgdsr_votes_trend where vote_type = '%s' and id = %s and %s between DATE_SUB(NOW(), INTERVAL %s DAY) AND NOW() order by vote_date asc",
            $strtodate, $table_prefix, $vote_type, $id, $strtodate, $days);
        $results = $wpdb->get_results($sql);
        $data = array();
        for ($i = $days; $i > 0; $i--) {
            $day = date('Y-m-d', mktime(0, 0, 0, date("m"), date("d") - $i, date("Y")));
            $el = array();
            $el["date"] = $day;
            $el["visitor_voters"] = 0;
            $el["visitor_votes"] = 0;
            $el["user_voters"] = 0;
            $el["user_votes"] = 0;
            $data[$day] = $el;
        }
        foreach ($results as $row) {
            $data[$row->vote_date]["visitor_voters"] = $row->visitor_voters;
            $data[$row->vote_date]["visitor_votes"] = $row->visitor_votes;
            $data[$row->vote_date]["user_voters"] = $row->user_voters;
            $data[$row->vote_date]["user_votes"] = $row->user_votes;
        }
        return $data;
    }
}

?>
