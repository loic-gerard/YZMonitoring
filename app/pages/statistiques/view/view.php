<?php

use jin\output\webapp\context\Output;
use jin\output\webapp\request\Request;
use yz\navigation\Url;
use yz\navigation\FilRouge;
use yz\navigation\Actions;
use yz\ui\alerts\StandardAlert;
use yz\ui\alerts\ErrorAlert;
use jin\log\Debug;
use jin\query\Query;
use jin\lang\ArrayTools;

Output::addTemplate('global');
Output::addTemplate('interface');
Output::addTemplate('defaultpage');

FilRouge::add('Statistiques', 'statistiques');

Output::set('title', 'Statistiques');
Output::addTo('js', '<script src="' . BASE_URL . 'js/chartjs/Chart.min.js"></script>');
?>


<?php
//Statistiques sur les scans
//-----------------------------------------------------------------------------


$datasGlobal = Output::$controller->getStatsScan();
$datasWeekEnd = Output::$controller->getStatsScan('weekend');
$datasJour = Output::$controller->getStatsScan('jour');
?>


<div class="panel">
    <div class="panelTitle">
        Evolution des admissions
    </div>
    <div class="panelContent">

        <canvas id="scans"></canvas>
        <div id="scansLegend"></div>

        <script language="javascript">
            var options = { 
            legendTemplate : "<div class=\"legende\"><% for (var i=0; i<datasets.length; i++){%><div><div class=\"cube\" style=\"background-color:<%=datasets[i].strokeColor%>\"></div><div class=\"label\"><%if(datasets[i].label){%></div><%=datasets[i].label%><%}%></div><%}%></div>"
            };
            var data = {
                labels: [<?php echo '"' . ArrayTools::toList($datasGlobal['labels'], '","') . '"'; ?>],
                datasets: [
                    {
                        label: "Total",
                        fillColor: "rgba(137,209,125,0.2)",
                        strokeColor: "rgba(137,209,125,1)",
                        pointColor: "rgba(137,209,125,1)",
                        pointStrokeColor: "#fff",
                        pointHighlightFill: "#fff",
                        pointHighlightStroke: "rgba(137,209,125,1)",
                        data: [<?php echo ArrayTools::toList($datasGlobal['datas']); ?>]
                    },
                    {
                        label: "Pass WeekEnd",
                        fillColor: "rgba(41,167,184,0.2)",
                        strokeColor: "rgba(41,167,184,1)",
                        pointColor: "rgba(41,167,184,1)",
                        pointStrokeColor: "#fff",
                        pointHighlightFill: "#fff",
                        pointHighlightStroke: "rgba(41,167,184,1)",
                        data: [<?php echo ArrayTools::toList($datasWeekEnd['datas']); ?>]
                    },
                    {
                        label: "Pass Jour",
                        fillColor: "rgba(253,192,113,0.2)",
                        strokeColor: "rgba(253,192,113,1)",
                        pointColor: "rgba(253,192,113,1)",
                        pointStrokeColor: "#fff",
                        pointHighlightFill: "#fff",
                        pointHighlightStroke: "rgba(253,192,113,1)",
                        data: [<?php echo ArrayTools::toList($datasJour['datas']); ?>]
                    }
                ]
            };

            var ctx = document.getElementById("scans").getContext("2d");
            var myLineChart = new Chart(ctx).Line(data, options);
            var legend = myLineChart.generateLegend();
            $('#scansLegend').append(legend);
        </script>
    </div>
</div>


<?php
//Personnes sur site
//-----------------------------------------------------------------------------


$datasGlobal = Output::$controller->getStatsSurSite();
$datasWeekEnd = Output::$controller->getStatsSurSite('weekend');
$datasjour = Output::$controller->getStatsSurSite('jour');

?>


<div class="panel">
    <div class="panelTitle">
        Festivaliers sur site
    </div>
    <div class="panelContent">

        <canvas id="sursite"></canvas>
        <div class="total"><?= $datasGlobal['datas'][count($datasGlobal['datas'])-1]; ?><br>festivaliers</div>
        <div id="sursiteLegend"></div>
        
        <div class="clear"></div>
        <script language="javascript">
            var options = { 
            legendTemplate : "<div class=\"legende\"><% for (var i=0; i<datasets.length; i++){%><div><div class=\"cube\" style=\"background-color:<%=datasets[i].strokeColor%>\"></div><div class=\"label\"><%if(datasets[i].label){%></div><%=datasets[i].label%><%}%></div><%}%></div>"
            };
            var data = {
                labels: [<?php echo '"' . ArrayTools::toList($datasGlobal['labels'], '","') . '"'; ?>],
                datasets: [
                    {
                        label: "Total",
                        fillColor: "rgba(137,209,125,0.2)",
                        strokeColor: "rgba(137,209,125,1)",
                        pointColor: "rgba(137,209,125,1)",
                        pointStrokeColor: "#fff",
                        pointHighlightFill: "#fff",
                        pointHighlightStroke: "rgba(137,209,125,1)",
                        data: [<?php echo ArrayTools::toList($datasGlobal['datas']); ?>]
                    },
                    {
                        label: "Pass WeekEnd",
                        fillColor: "rgba(41,167,184,0.2)",
                        strokeColor: "rgba(41,167,184,1)",
                        pointColor: "rgba(41,167,184,1)",
                        pointStrokeColor: "#fff",
                        pointHighlightFill: "#fff",
                        pointHighlightStroke: "rgba(41,167,184,1)",
                        data: [<?php echo ArrayTools::toList($datasWeekEnd['datas']); ?>]
                    },
                    {
                        label: "Pass Jour",
                        fillColor: "rgba(253,192,113,0.2)",
                        strokeColor: "rgba(253,192,113,1)",
                        pointColor: "rgba(253,192,113,1)",
                        pointStrokeColor: "#fff",
                        pointHighlightFill: "#fff",
                        pointHighlightStroke: "rgba(253,192,113,1)",
                        data: [<?php echo ArrayTools::toList($datasJour['datas']); ?>]
                    }
                ]
            };

            var ctx = document.getElementById("sursite").getContext("2d");
            var myLineChart = new Chart(ctx).Line(data, options);
            var legend = myLineChart.generateLegend();
            $('#sursiteLegend').append(legend);
        </script>
    </div>
</div>