<?php

require_once("../gd-star-config.php");
$wpconfig = get_wpconfig();
require($wpconfig);
global $gdsr;

$data = GDSRChart::votes_counter();
$values = array();
$titles = array();
foreach ($data as $row) {
    $values[] = $row->counter;
    $titles[] = $row->vote;
}

include(STARRATING_CHART_PATH."pchart/pData.class");
include(STARRATING_CHART_PATH."pchart/pChart.class");

$data_set = new pData;
$data_set->AddPoint($values, "Serie1");
$data_set->AddPoint($titles, "Serie2");
$data_set->AddAllSeries();
$data_set->SetAbsciseLabelSerie("Serie2");

$chart = new pChart(430,240);
$chart->loadColorPalette(STARRATING_CHART_PATH."colors/default.palette");
$chart->drawFilledRoundedRectangle(7, 7, 423, 233, 5, 240, 240, 240);
$chart->drawRoundedRectangle(5, 5, 425, 235, 5, 230, 230, 230);

$chart->setFontProperties(STARRATING_CHART_PATH."fonts/quicksand.ttf", 8);
$chart->drawPieGraph($data_set->GetData(), $data_set->GetDataDescription(), 180, 130, 130, PIE_PERCENTAGE, TRUE, 50, 20, 5);
$chart->drawPieLegend(370, 15, $data_set->GetData(), $data_set->GetDataDescription(), 250, 250, 250);
$chart->drawFilledRoundedRectangle(16, 16, 301, 34, 5, 220, 220, 220);
$chart->drawFilledRoundedRectangle(15, 15, 300, 33, 5, 250, 250, 250);
$chart->setFontProperties(STARRATING_CHART_PATH."fonts/quicksand.ttf", 11);
$chart->drawTitle(20, 29, __("Chart with votes distribution", "gd-star-rating"), 250, 50, 50);

$chart->Stroke();

?>