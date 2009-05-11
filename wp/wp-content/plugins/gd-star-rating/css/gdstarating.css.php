<?php

if (!isset($inclusion)) {
    $base_url_local = "../";
    $base_url_extra = "../../../gd-star-rating/";
    header('Content-Type: text/css');
    $q = urldecode($_GET["s"]);
}

function insert_styles($css, $base_url_local, $base_url_extra) {
    $query = explode("|", $css["values"]);

    $style = $query[0];
    $stars = $query[2];
    $size = $query[1];
    $type = $query[3];
    $loc = $query[4];

    if ($loc == 1) $url = $base_url_local."stars/".$style."/stars".$size.".".$type;
    else $url = $base_url_extra."stars/".$style."/stars".$size.".".$type;

    echo "\r\n";
    if ($css["name"] != "ratemulti") echo ".".$css["name"]." { width: ".($stars * $size)."px; }\r\n";

    if ($css["name"] != "ratemulti") echo ".".$css["name"]." .starsbar .gdouter { width: ".($stars * $size)."px; height: ".$size."px; background: url('".$url."') repeat-x 0px 0px; }\r\n";
    else echo ".".$css["name"]." .starsbar .gdouter { height: ".$size."px; background: url('".$url."') repeat-x 0px 0px; }\r\n";

    echo ".".$css["name"]." .starsbar .gdinner { height: ".$size."px; background: url('".$url."') repeat-x 0px -".(2 * $size)."px; }\r\n";
    if ($css["name"] == "ratemulti") echo ".".$css["name"]." .starsbar .gdcurrent { height: ".$size."px; background: url('".$url."') repeat-x 0px -".($size)."px; }\r\n";

    echo ".".$css["name"]." .starsbar a:hover { background: url('".$url."') repeat-x 0px -".$size."px !important; }\r\n";
    echo ".".$css["name"]." .starsbar a { height: ".$size."px; }\r\n";

    for ($i = 1; $i < $stars + 1; $i++) echo ".".$css["name"]." .starsbar a.s".$i." { width: ".($i * $size)."px; }\r\n";
}

function get_class_head($head, $element) {
    $result = "";
    for ($i = 0; $i < count($head); $i++) {
        $result.= ".".$head[$i];
        if ($element != "") $result.= " ".$element;
        if ($i < count($head) - 1) $result.= ", ";
    }
    echo $result;
}

$csss = array();
$head = array();
$q = explode("#", $q);

foreach ($q as $cs) {
    $css["type"] = substr($cs, 0, 1);
    $css["values"] = substr($cs, 1);
    switch ($css["type"]) {
        case "a":
            $css["name"] = "ratepost";
            $head[] = "ratepost";
            break;
        case "c":
            $css["name"] = "ratecmm";
            $head[] = "ratecmm";
            break;
        case "r":
            $css["name"] = "reviewcmm";
            $head[] = "reviewcmm";
            break;
        case "m":
            $css["name"] = "ratemulti";
            $head[] = "ratemulti";
            break;
    }
    $csss[] = $css;
}

foreach ($csss as $css) insert_styles($css, $base_url_local, $base_url_extra);

?>

<?php get_class_head($head, ""); ?> { position: relative; display: block; }
<?php get_class_head($head, ".starsbar .gdinner"); ?> { width: 0; }
<?php get_class_head($head, ".starsbar a:active"); ?> { text-decoration: none; border: 0 !important; }
<?php get_class_head($head, ".starsbar a:visited"); ?> { text-decoration: none; border: 0 !important; }
<?php get_class_head($head, ".starsbar a:hover"); ?> { text-decoration: none; border: 0 !important; }
<?php get_class_head($head, ".starsbar a"); ?> { position: absolute; display: block; left: 0; top: 0; text-decoration: none; border: 0 !important; cursor: pointer; background: none !important; }

.ratemulti .starsbar .gdcurrent { width: 0; top: 0; position: absolute; opacity: 0.7; }
.starsbar .gdinner { padding: 0; }
.ratingblock td { vertical-align: middle; }
.raterclear { clear: both; }
.raterleft { float: left; }
.raterright { float: right; }
.voted {color: #999;}
.thanks {color: #36AA3D;}
.static {color: #5D3126;}
.rater { top: 0; }

.ratingtextmulti { float: left; }
.ratingbutton { float: right; padding: 1px 6px; }
.ratingbutton.gdinactive { border: 1px solid #9c5f5f; background-color: #e9e4d4; }
.ratingbutton.gdactive { border: 1px solid black; background-color: #f1ede5; cursor: pointer; }
.ratingbutton a { line-height: 14px; text-decoration: none !important; }
.ratingbutton.gdactive { cursor: pointer; }
.ratingbutton.gdactive a { color: #ad1b1b; cursor: pointer; }
.ratingbutton.gdinactive a { color: gray; cursor: default; }
.gdmultitable { padding: 3px; margin: 3px; border: 1px solid #999999; }
.gdtblbottom td { padding-top: 4px; }
.gdtblbottom { margin-top: 2px; background-color: #fffcf4; }
.mtrow { background-color: #fffcf4; }
.mtrow td.mtstars { text-align: right; }
.mtrow.alternate { background-color: #f7f4ea; }
.gdtblmuravg { background-color: #fffcf4; }
.gdtblmuravg td { border-top: 2px solid #dcdcdc; text-align: center; }
.gdmultitable td { vertical-align: middle; padding: 2px 4px; }
.ratingblock { padding-bottom: 4px; margin-bottom: 4px; margin-top: 8px; font-size: 12px; }
.ratingtext { padding-bottom: 2px; margin-bottom: 2px; margin-top: 0px; }
.ratingmulti img { border: 0; padding: 0; margin: 0; }

.ratingblockarticle { font-size: 1em; }
.ratingblockcomment { font-size: 0.8em; }
.ratingloaderarticle, .ratingloadercomment { font-size: 12px; text-align: center; vertical-align: middle; }

/* loading indicators */
.loader { margin-left: auto; margin-right: auto; text-align: left; }

.loader.circle { background: url(<?php echo $base_url_local;?>gfx/loader/circle.gif) no-repeat left; padding-left: 18px; }
.loader.circle.width { width: 16px; margin-left: auto; margin-right: auto; padding-left: 0px; }

.loader.bar { background: url(<?php echo $base_url_local;?>gfx/loader/bar.gif) no-repeat left; padding-left: 216px; }
.loader.bar.width { width: 208px; margin-left: auto; margin-right: auto; padding-left: 0px; }

.loader.arrows { background: url(<?php echo $base_url_local;?>gfx/loader/arrows.gif) no-repeat left; padding-left: 18px; }
.loader.arrows.width { width: 16px; margin-left: auto; margin-right: auto; padding-left: 0px; }

.loader.flower { background: url(<?php echo $base_url_local;?>gfx/loader/flower.gif) no-repeat left; padding-left: 18px; }
.loader.flower.width { width: 15px; margin-left: auto; margin-right: auto; padding-left: 0px; }

.loader.gauge { background: url(<?php echo $base_url_local;?>gfx/loader/gauge.gif) no-repeat left; padding-left: 134px; }
.loader.gauge.width { width: 128px; margin-left: auto; margin-right: auto; padding-left: 0px; }

.loader.squares { background: url(<?php echo $base_url_local;?>gfx/loader/squares.gif) no-repeat left; padding-left: 43px; }
.loader.squares.width { width: 43px; margin-left: auto; margin-right: auto; padding-left: 0px; }

.loader.fountain { background: url(<?php echo $base_url_local;?>gfx/loader/fountain.gif) no-repeat left; padding-left: 134px; }
.loader.fountain.width { width: 128px; margin-left: auto; margin-right: auto; padding-left: 0px; }

.loader.lines { background: url(<?php echo $base_url_local;?>gfx/loader/lines.gif) no-repeat left; padding-left: 102px; }
.loader.lines.width { width: 96px; margin-left: auto; margin-right: auto; padding-left: 0px; }

.loader.broken { background: url(<?php echo $base_url_local;?>gfx/loader/broken.gif) no-repeat left; padding-left: 18px; }
.loader.broken.width { width: 16px; margin-left: auto; margin-right: auto; padding-left: 0px; }

.loader.snake { background: url(<?php echo $base_url_local;?>gfx/loader/snake.gif) no-repeat left; padding-left: 14px; }
.loader.snake.width { width: 12px; margin-left: auto; margin-right: auto; padding-left: 0px; }

.loader.triangles { background: url(<?php echo $base_url_local;?>gfx/loader/triangles.gif) no-repeat left; padding-left: 14px; }
.loader.triangles.width { width: 12px; margin-left: auto; margin-right: auto; padding-left: 0px; }

/* top rating widget */
.trw-title { text-align: center; font-size: 16px; font-family: "Century Gothic", Arial, Helvetica, sans-serif; }
.trw-rating { font-size: 44px; font-family: "Century Gothic", Arial, Helvetica, sans-serif; font-weight: bold; text-align: center; }
.trw-footer { text-align: center; font-size: 11px; font-family: "Century Gothic", Geneva, Arial, Helvetica, sans-serif; }
