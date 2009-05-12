<?php

require_once("../gd-star-config.php");
$wpconfig = get_wpconfig();
require($wpconfig);

global $gdsr;
if ($gdsr->use_nonce) {
    $nonce = $_REQUEST['_wpnonce'];
    require_once(ABSPATH.WPINC."/pluggable.php");
    if (!wp_verify_nonce($nonce, 'gdsr_chart_l8')) die("Security check");
}

$id = $_GET["id"];
$show = $_GET["show"];

$data = GDSRChart::votes_trend_daily($id);

$vote = array();
$rate = array();
$date = array();

foreach ($data as $day => $el) {
    if ($show == "user") {
        $voters = $el["user_voters"];
        $votes = $el["user_votes"];
    }
    else if ($show == "visitor") {
        $voters = $el["visitor_voters"];
        $votes = $el["visitor_votes"];
    }
    else {
        $voters = $el["visitor_voters"] + $el["user_voters"];
        $votes = $el["visitor_votes"] + $el["user_votes"];
    }
    $vote[] = $voters;
    $date[] = $day;
    if ($voters > 0) $rate[] = number_format($votes / $voters, 1);
    else $rate[] = 0;
}

include(STARRATING_CHART_PATH."pchart/pData.class");
include(STARRATING_CHART_PATH."pchart/pChart.class");

$DataSet = new pData;
$DataSet->AddPoint($vote,"Serie1");
$DataSet->AddPoint($rate,"Serie2");
$DataSet->AddPoint($date,"Serie3");
$DataSet->AddSerie("Serie1");
$DataSet->SetAbsciseLabelSerie("Serie3");
$DataSet->SetSerieName("Votes","Serie1");
$DataSet->SetSerieName("Rating","Serie2");

$chart = new pChart(750,380);
$chart->loadColorPalette(STARRATING_CHART_PATH."colors/default.palette");
$chart->drawFilledRoundedRectangle(7, 7, 743, 373, 5, 240, 240, 240);
$chart->drawRoundedRectangle(5, 5, 745, 375, 5, 230, 230, 230);

$chart->setFontProperties(STARRATING_CHART_PATH."fonts/quicksand.ttf", 8);
$chart->setGraphArea(60, 40, 695, 290);

$DataSet->SetYAxisName("Votes");
$chart->drawScale($DataSet->GetData(), $DataSet->GetDataDescription(), SCALE_NORMAL, 150, 150, 150, TRUE, 90, 0);
$chart->drawGrid(4,TRUE,230,230,230,50);

$chart->drawLineGraph($DataSet->GetData(),$DataSet->GetDataDescription());
$chart->drawPlotGraph($DataSet->GetData(),$DataSet->GetDataDescription(),2,1,255,255,255);

$chart->clearScale();
  
$DataSet->RemoveSerie("Serie1");   
$DataSet->AddSerie("Serie2");   
$DataSet->SetYAxisName("Ratings");

$chart->drawRightScale($DataSet->GetData(), $DataSet->GetDataDescription(), SCALE_NORMAL, 150, 150, 150, TRUE, 90, 0);
$chart->drawLineGraph($DataSet->GetData(),$DataSet->GetDataDescription());
$chart->drawPlotGraph($DataSet->GetData(),$DataSet->GetDataDescription(),2,1,255,255,255);

$chart->Stroke();

?>
