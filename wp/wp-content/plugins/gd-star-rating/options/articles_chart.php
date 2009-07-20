<?php

    if ($use_nonce)
        $nonce = sprintf("&_wpnonce=%s", wp_create_nonce('gdsr_chart_l8'));
    else
        $nonce = "";

?>

<script>
function generateUrl(id) {
    var chartUrl = '<?php echo STARRATING_CHART_URL."chart_line_articles.php"; ?>';
    var chartNon = '<?php echo $nonce; ?>';
    var chartXtr = '?id=' + id;
    
    jQuery("#gdsrchartimage").attr("src", chartUrl + chartXtr + chartNon);
}
</script>
<table width="100%">
    <tr>
        <td width="160" valign="top">
            
        </td>
        <td width="10"></td>
        <td valign="top">
            <img id="gdsrchartimage" src="<?php echo STARRATING_CHART_URL; ?>chart_line_articles.php" border="0" />
        </td>
    </tr>
</table>

