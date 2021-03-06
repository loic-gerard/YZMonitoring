<?php

use jin\output\webapp\context\DefaultController;
use jin\log\Debug;
use jin\query\Query;
use jin\lang\ArrayTools;

class statistiques_Controller extends DefaultController {

    public function getStatsScan($typeBillet = null) {
        $retour = array();


        //Construction des données
        $q = new Query();
        $q->setRequest('SELECT '
                . 'COUNT(*) AS nb, '
                . 'in_day AS day,'
                . 'in_hour AS hour '
                . 'FROM tb_scan AS s '
                . 'JOIN tb_billet AS b On b.pk_billet = s.fk_billet '
                . 'WHERE s.tt_type=' . $q->argument('OK', Query::$SQL_STRING) . ' '
                . 'AND s.dt_datetime >= \'31/07/2015 17:00:00\'');
        if($typeBillet == 'weekend'){
            $q->addToRequest('AND (b.tt_type='.$q->argument('weekend', Query::$SQL_STRING). ' OR b.tt_type='.$q->argument('ebillet_surtaxe', Query::$SQL_STRING).')');
        }else if($typeBillet == 'jour'){
            $q->addToRequest('AND (b.tt_type='.$q->argument('vendredi', Query::$SQL_STRING).' OR b.tt_type='.$q->argument('samedi', Query::$SQL_STRING).' OR b.tt_type='.$q->argument('samedi_surtaxe', Query::$SQL_STRING).' OR b.tt_type='.$q->argument('vendredi_surtaxe', Query::$SQL_STRING).')');
        }
        $q->addToRequest('GROUP BY in_day, in_hour');
        $q->execute();
   
        $qr = $q->getQueryResults();

        $labels = array();
        $datas = array();
        $datasCorresp = array();

        $dt = new \DateTime();
        $currentDay = $dt->format('d');
        $currentHour = $dt->format('H');

        $index = 0;
        $exit = false;
        for ($i = STATS_SCAN_START_DAY; $i <= STATS_SCAN_END_DAY; $i++) {
            $jStart = STATS_SCAN_START_HOUR;
            $jEnd = STATS_SCAN_END_HOUR;
            if ($i == STATS_SCAN_START_DAY) {
                $jStart = STATS_SCAN_START_HOUR;
                $jEnd = 23;
            } elseif ($i == STATS_SCAN_END_DAY) {
                $jStart = 0;
                $jEnd = STATS_SCAN_END_HOUR;
            } else {
                $jStart = 0;
                $jEnd = 23;
            }
            for ($j = $jStart; $j <= $jEnd; $j++) {
                if ($i == intval($currentDay) && $j == intval($currentHour + 1)) {
                    $exit = true;
                    break;
                }
                $labels[] = $j . 'h00';
                $datas[] = 0;
                $datasCorresp[$i . ':' . $j] = $index;
                $index++;
            }

            if ($exit) {
                break;
            }
        }

        $labels = array();
        foreach ($qr AS $r) {
            $labels[] = $r['day'].'-'.$r['hour'];
            $datas[] = $r['nb'];
        }
        
        $retour['labels'] = $labels;
        $retour['datas'] = $datas;
        
        return $retour;
    }
    
    public function getStatsSurSite($typeBillet = null) {
        $retour = array();


        //Construction des données
        $q = new Query();
        $q->setRequest('SELECT '
                . 'COUNT(*) AS nb, '
                . 'in_day AS day,'
                . 'in_hour AS hour '
                . 'FROM tb_scan AS s '
                . 'JOIN tb_billet AS b On b.pk_billet = s.fk_billet '
                . 'WHERE s.tt_type=' . $q->argument('OK', Query::$SQL_STRING) . ' AND s.dt_datetime >= \'31/07/2015 17:00:00\'');
        if($typeBillet == 'weekend'){
            $q->addToRequest('AND (b.tt_type='.$q->argument('weekend', Query::$SQL_STRING). ' OR b.tt_type='.$q->argument('ebillet_surtaxe', Query::$SQL_STRING).')');
        }else if($typeBillet == 'jour'){
            $q->addToRequest('AND (b.tt_type='.$q->argument('vendredi', Query::$SQL_STRING).' OR b.tt_type='.$q->argument('samedi', Query::$SQL_STRING).' OR b.tt_type='.$q->argument('samedi_surtaxe', Query::$SQL_STRING).' OR b.tt_type='.$q->argument('vendredi_surtaxe', Query::$SQL_STRING).')');
        }
        $q->addToRequest('GROUP BY in_day, in_hour');
        $q->execute();
        $qr = $q->getQueryResults();

        $labels = array();
        $datas = array();
        $datasCorresp = array();

        $dt = new \DateTime();
        $currentDay = $dt->format('d');
        $currentHour = $dt->format('H');


        $labels = array();
        $cumul = 0;
        foreach ($qr AS $r) {
            $cumul += $r['nb'];
            $datas[] = $cumul;
            $labels[] = $r['day'].'-'.$r['hour'];
        }
        
        
        
        $retour['labels'] = $labels;
        $retour['datas'] = $datas;
        
        return $retour;
    }

}
