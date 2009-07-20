<?php

    require_once("./code/gd-star-export.php");
    require_once("./gd-star-config.php");
    $wpconfig = get_wpconfig();
    require($wpconfig);
    global $wpdb;

    if (isset($_GET["ex"])) {
        $export_type = $_GET["ex"];
        $get_data = $_GET;
        
        switch($export_type) {
            case "user":
                $export_name = $export_type.'_'.$_GET["de"];
                break;
            case "t2":
                $export_name = 't2';
                break;
        }

        header('Content-type: text/csv');
        header('Content-Disposition: attachment; filename="gdsr_export_'.$export_name.'.csv"');    

        switch($export_type) {
            case "user":
                $sql = GDSRExport::export_users($_GET["us"], $_GET["de"], $get_data);
                break;
            case "t2":
                $sql = GDSRExport::export_t2();
                break;
        }
        
        $rows = $wpdb->get_results($sql, ARRAY_N);
        if (count($rows) > 0) {
            foreach ($rows as $row) {
                echo '"'.join('", "', $row).'"';
                echo "\r\n";
            }
        }
    }
?>