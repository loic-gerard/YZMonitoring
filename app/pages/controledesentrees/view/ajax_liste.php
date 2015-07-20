<?php

use jin\query\Query;
use jin\query\QueryResult;
use jin\output\components\ui\table\Table;
use jin\output\components\ui\table\TableModel;
use yz\ui\alerts\ErrorAlert;
use yz\ui\alerts\StandardAlert;
use yz\navigation\Url;

if(isset($_POST['in_numero'])){
    $_SESSION['filtres_billets'] = $_POST;
}

$q = new Query();
$q->setRequest('SELECT * FROM tb_billet ');
$q->addToRequest('WHERE 1=1 ');
if($_POST['in_numero'] != ''){
    $q->addToRequest('AND in_numero LIKE \'%'.$_POST['in_numero'].'%\'');
}
if($_POST['pk_billet'] != ''){
    if(!is_numeric($_POST['pk_billet'])){
        $e = new ErrorAlert('Numéro interne incorrect', 'Valeur numérique attendue');
        echo $e->render();
        exit;
    }
    $q->addToRequest('AND pk_billet='.$q->argument($_POST['pk_billet'], Query::$SQL_NUMERIC));
}
if($_POST['tt_type'] != '' && $_POST['tt_type'] != '-1'){
    $q->addToRequest('AND tt_type ='.$q->argument($_POST['tt_type'], Query::$SQL_STRING));
}
if($_POST['tt_codebarre'] != ''){
    $q->addToRequest('AND tt_codebarre LIKE \'%'.$_POST['tt_codebarre'].'%\'');
}
if($_POST['in_numerocommande'] != ''){
    $q->addToRequest('AND in_numero_commande LIKE \'%'.$_POST['in_numerocommande'].'%\'');
}
if($_POST['tt_client'] != ''){
    $q->addToRequest('AND tt_client LIKE \'%'.$_POST['tt_client'].'%\'');
}
if($_POST['dt_commande'] != '' && $_POST['dt_commande'] != 'jj/mm/aaaa'){
    $q->addToRequest('AND dt_commande='.$q->argument($_POST['dt_commande'], Query::$SQL_DATETIME));
}
$q->addToRequest('LIMIT 30');
$q->execute();
$qr = $q->getQueryResults();

if($qr->count()==0){
    $sa = new StandardAlert('Aucun résultat', 'Votre recherche ne retourne aucun résultat.');
    echo $sa->render();
    exit;
}

$qr->addColumn('details', function($row) {
    return array(
        'href' => Url::getUrlFromCode('controledesentrees/details', array('billet' => $row['pk_billet'])),
        'label' => 'Détails',
        'class' => 'classic'
    );
});

$qr->removeColumn('dt_commande');
$qr->removeColumn('tt_dates_validite');
$qr->removeColumn('in_surcharge');
$qr->removeColumn('tt_commentaires');

$t = new Table('billets');
$t->setHeaders(array('#id','Numéro','Type','Désignation','Code barre','N° commande','Client','Valide','Source',''));
$t->setDataSource($qr);

$tm = new TableModel();
$tm->setColComponent('dt_commande', 'jin\output\components\ui\Date');
$tm->setColComponent('in_valide', 'jin\output\components\ui\Boolean');
$tm->setColComponent('details', 'yz\ui\components\tablecell\Button');
$t->setTableModel($tm);

echo $t->render();