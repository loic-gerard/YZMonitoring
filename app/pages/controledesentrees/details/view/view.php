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
use yz\data\Billet;
use jin\output\components\ui\table\Table;
use jin\output\components\ui\table\TableModel;
use jin\lang\StringTools;

if(!Request::getArgumentValue('billet')){
    Url::redirectTo('controledesentrees');
}

$pk = Request::getArgumentValue('billet');
$billet = new Billet($pk);


$ds = $billet->getScans();

$ds->addColumn('verbose', function($row) {
    if($row['tt_type'] == 'OK'){
        return '<b class="validColor">Validation du billet</b>';
    }else{
        return '<b>'.$row['tt_type'].'</b>';
    }
});

$ds->addColumn('annuler', function($row) {
    return array(
        'href' => 'javascript:confirmCancelScan(\''.Url::getUrlFromCode('controledesentrees/details/cancel', array('pk' => $row['pk_scan'], 'billet' => $_GET['billet'])).'\');',
        'label' => 'Annuler',
        'class' => 'cancel'
    );
});


$ds->removeColumn('tt_type');
$ds->removeColumn('pk_scan');
$ds->removeColumn('fk_billet');
$ds->removeColumn('in_day');
$ds->removeColumn('in_hour');

$t = new Table('billets');
$t->setHeaders(array('Date','Détails',''));
$t->setDataSource($ds);

$tm = new TableModel();
$tm->setColComponent('dt_datetime', 'jin\output\components\ui\DateTime');
$tm->setColComponent('annuler', 'yz\ui\components\tablecell\Button');
$t->setTableModel($tm);

Output::addTemplate('global');
Output::addTemplate('interface');
Output::addTemplate('defaultpage');

FilRouge::add('Contrôle des entrées', 'controledesentrees');
FilRouge::add('Billet numéro '.$billet->getNumero(), 'controledesentrees/details', array('billet' => $pk));

Output::set('title', 'Billet numéro '.$billet->getNumero());

Output::addTo('js', '<script src="'.BASE_URL.'/js/controledesentrees/main.js"></script>');


Actions::add('Retour', 'flaticon-add', Url::getUrlFromCode('controledesentrees', array()), 'classic');

if($billet->isValide()){
    Actions::add('Désactiver', 'flaticon-add', 'javascript:confirmInvalidate(\''.Url::getUrlFromCode('controledesentrees/details/invalidate', array('billet' => $_GET['billet'])).'\')', 'cancel');
    
    if($billet->isScanned()){
        Actions::add('Annuler le scan', 'flaticon-add', 'javascript:cancelOkScan(\''.Url::getUrlFromCode('controledesentrees/details/cancelokscan', array('billet' => $_GET['billet'])).'\')', 'cancel');
    }else{
        Actions::add('Scanner manuellement', 'flaticon-add', 'javascript:manualScan(\''.Url::getUrlFromCode('controledesentrees/details/scan', array('billet' => $_GET['billet'])).'\')', 'valid');
    }
}else{
    Actions::add('Activer', 'flaticon-add', 'javascript:confirmValidate(\''.Url::getUrlFromCode('controledesentrees/details/validate', array('billet' => $_GET['billet'])).'\')', 'valid');
}

?>

<div class="panel">   
    <div class="panelTitle">Validité</div>
    <div class="panelContent" id="billets">
        <div class="keyValueLine">
            <div class="key">Dates de validité :</div>
            <div class="value"><?= $billet->get('tt_dates_validite'); ?></div>
            <div class="clear"></div>
        </div>
        <div class="keyValueLine">
            <div class="key">Valide :</div>
            <div class="value"><?php if($billet->isValide()){ echo '<div class="valid led">OUI</div>'; }else{ echo '<div class="cancel led">NON</div>'; } ?></div>
            <div class="clear"></div>
        </div>
        <div class="keyValueLine">
            <div class="key">Déjà validé :</div>
            <div class="value"><?php if($billet->isScanned()){ echo '<div class="valid led">OUI</div>'; }else{ echo '<div class="cancel led">NON</div>'; } ?></div>
            <div class="clear"></div>
        </div>
        <div class="keyValueLine">
            <div class="key">Modifié manuellement :</div>
            <div class="value"><?php if($billet-> isSurcharged()){ echo '<div class="valid led">OUI</div>'; }else{ echo '<div class="cancel led">NON</div>'; } ?></div>
            <div class="clear"></div>
        </div>
        
       
    </div>
</div>

<div class="panel">
    <div class="panelTitle">Généralités</div>
    <div class="panelContent" id="billets">
        <div class="keyValueLine">
            <div class="key">Numéro :</div>
            <div class="value"><?= $billet->getNumero(); ?></div>
            <div class="clear"></div>
        </div>
        <div class="keyValueLine">
            <div class="key">Numéro interne :</div>
            <div class="value"><?= $billet->getPk(); ?></div>
            <div class="clear"></div>
        </div>
        <div class="keyValueLine">
            <div class="key">Type :</div>
            <div class="value"><?= $billet->get('tt_type'); ?></div>
            <div class="clear"></div>
        </div>
        <div class="keyValueLine">
            <div class="key">Désignation :</div>
            <div class="value"><?= $billet->get('tt_designation'); ?></div>
            <div class="clear"></div>
        </div>
        <div class="keyValueLine">
            <div class="key">Source :</div>
            <div class="value"><?= $billet->get('tt_source'); ?></div>
            <div class="clear"></div>
        </div>
        <div class="keyValueLine">
            <div class="key">Code barre :</div>
            <div class="value"><?= $billet->get('tt_codebarre'); ?></div>
            <div class="clear"></div>
        </div>
    </div>
</div>

<div class="panel">    
    <div class="panelTitle">Commande</div>
    <div class="panelContent" id="billets">
        <div class="keyValueLine">
            <div class="key">Client :</div>
            <div class="value"><?= StringTools::urlDecode($billet->get('tt_client')); ?></div>
            <div class="clear"></div>
        </div>
        <div class="keyValueLine">
            <div class="key">Numéro de commande :</div>
            <div class="value"><?= $billet->get('in_numero_commande'); ?></div>
            <div class="clear"></div>
        </div>
        <div class="keyValueLine">
            <div class="key">Date de commande :</div>
            <div class="value"><?= $billet->get('dt_commande'); ?></div>
            <div class="clear"></div>
        </div>
    </div>
</div>



<div class="tablePanel">
    <div class="panelTitle">Scans</div>
    <div class="panelContent">
        <?php echo $t->render(); ?>
    </div>
</div>

<div class="panel" id="commentaires"> 
    <div class="panelTitle">Commentaires</div>
    <div class="panelContent" id="billets">
        <form method="POST" action="<?= Url::getUrlFromCode('controledesentrees/details/savecomments', array('billet' => $_GET['billet'])); ?>">
            <textarea name="commentaires"><?= $billet->get('tt_commentaires'); ?></textarea><br><br>
        <input type="submit" value="Enregistrer" class="button valid">
        </form>
    </div>
</div>


