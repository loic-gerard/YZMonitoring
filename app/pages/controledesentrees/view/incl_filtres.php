<?php

use jin\JinCore;

function getValue($code){
    if(isset($_SESSION['filtres_billets']) && isset($_SESSION['filtres_billets'][$code])){
        return $_SESSION['filtres_billets'][$code];
    }
    return '';
}

?>

<div class="filtres">
    <form name="filtres" id="filtres">
        <div class="filtre">
            <div class="title">Numéro de billet</div>
            <div class="form">
                <input type="text" name="in_numero" id="in_numero" class="formcheck" value="<?= getValue('in_numero'); ?>">
            </div>
        </div>
        <div class="filtre">
            <div class="title">Numéro interne</div>
            <div class="form">
                <input type="text" name="pk_billet" id="pk_billet" class="formcheck" value="<?= getValue('pk_billet'); ?>">
            </div>
        </div>
        <div class="filtre">
            <div class="title">Type</div>
            <div class="form">
                <select name="tt_type" id="tt_type" class="formcheck">
                    <option <?php if(getValue('tt_type') == '-1'){ ?>selected="selected"<?php } ?> value="-1">Tous</option>
                    <option <?php if(getValue('tt_type') == 'vendredi'){ ?>selected="selected"<?php } ?> value="vendredi">Pass vendredi</option>
                    <option <?php if(getValue('tt_type') == 'samedi'){ ?>selected="selected"<?php } ?> value="samedi">Pass samedi</option>
                    <option <?php if(getValue('tt_type') == 'weekend'){ ?>selected="selected"<?php } ?> value="weekend">Pass week-end</option>
                </select>
            </div>
        </div>
        <div class="filtre">
            <div class="title">Date de commande</div>
            <div class="form">
                <input type="date" name="dt_commande" id="dt_commande" class="formcheck" value="<?= getValue('dt_commande'); ?>">
            </div>
        </div>
        <div class="filtre">
            <div class="title">Code barre</div>
            <div class="form">
                <input type="text" name="tt_codebarre" id="tt_codebarre" class="formcheck" value="<?= getValue('tt_codebarre'); ?>">
            </div>
        </div>
        <div class="filtre">
            <div class="title">Numéro de commande</div>
            <div class="form">
                <input type="text" name="in_numerocommande" id="in_numerocommande" class="formcheck" value="<?= getValue('in_numerocommande'); ?>">
            </div>
        </div>
        <div class="filtre">
            <div class="title">Client</div>
            <div class="form">
                <input type="text" name="tt_client" id="tt_client" class="formcheck" value="<?= getValue('tt_client'); ?>">
            </div>
        </div>
        <div class="filtre">
            <a href="javascript:cancelFiltres();" class="actionitem cancel">Réinitialiser</a>
        </div>
    </form>
    
</div>

<script type="text/javascript">	
var filtres = new ControleDesEntrees('filtres', '<?= JinCore::getContainerUrl(); ?>');
</script>