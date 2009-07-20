<?php

    require_once("./gd-star-config.php");
    $wpconfig = get_wpconfig();
    require($wpconfig);
    global $gdsr;

    $input["value"] = $_GET["value"];
    if (isset($_GET["set"])) $input["set"] = $_GET["set"];
    else $input["set"] = $gdsr->o["rss_style"];
    if (isset($_GET["size"])) $input["size"] = $_GET["size"];
    else $input["size"] = $gdsr->o["rss_size"];
    if (isset($_GET["max"])) $input["stars"] = $_GET["max"];
    else $input["stars"] = $gdsr->o["stars"];

    if ($gdsr->o["gfx_prevent_leeching"] == 1 && (isset($_GET["set"]) || isset($_GET["size"]) || isset($_GET["max"]))) {
        $server_name = $_SERVER["SERVER_NAME"];
        if (substr($server_name, 0, 4) == "www.") $server_host = substr($server_name, 4);
        $domain = parse_url($_SERVER['HTTP_REFERER']);
        if ($domain['host'] == $server_name || $domain['host'] == $server_host) $allow = true;
        else $allow = false;
    } else $allow = true;

    if ($allow) {
        $gfx_set = $gdsr->g->find_stars($input["set"]);
        if ($gdsr->is_cached) {
            $image_name = GDSRGenerator::get_image_name($input["set"], $input["size"], $input["stars"], $input["value"]);
            $image_path = STARRATING_CACHE_PATH.$image_name.".".$gfx_set->type;
            GDSRGenerator::image($gfx_set->get_path($input["size"]), $input["size"], $input["stars"], $input["value"], $image_path);
        }
        else {
            GDSRGenerator::image_nocache($gfx_set->get_path($input["size"]), $input["size"], $input["stars"], $input["value"]);
        }
    }
    else header("Location: ".get_bloginfo("wpurl"));

?>
