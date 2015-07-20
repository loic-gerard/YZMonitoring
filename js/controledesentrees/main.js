function ControleDesEntrees(formId, rootPath) {
    console.log('constructeur avec ' + formId);

    var form = jQuery('#' + formId);
    var items = new Array();
    var timeOut;
    var root = rootPath; 

    jQuery('#' + formId + ' .formcheck').each(function (index) {
        items.push(jQuery(this));
    });

    for (var i = 0; i < items.length; i++) {
        items[i].blur([items[i], this], function (e) {
            e.data[1].checkForm(e.data[0]);
        });
        items[i].change([items[i], this], function (e) {
            e.data[1].checkForm(e.data[0]);
        });
        items[i].keyup([items[i], this], function (e) {
            e.data[1].checkForm(e.data[0]);
        });
    }

    console.log(items.length + ' elements de formulaire');


    this.checkForm = function (item) {
        clearTimeout(timeOut);
        timeOut = setTimeout(this.reloadDatas, 400);
    }

    this.reloadDatas = function () {
        var datas = {
            "file" : "app/pages/controledesentrees/view/ajax_liste.php",
            "in_numero" : $("#in_numero").val(),
            "pk_billet" : $("#pk_billet").val(),
            "tt_type" : $("#tt_type").val(),
            "dt_commande" : $("#dt_commande").val(),
            "tt_codebarre" : $("#tt_codebarre").val(),
            "in_numerocommande" : $("#in_numerocommande").val(),
            "tt_client" : $("#tt_client").val()       
        }
        
        console.log('reload datas');
        $.ajax({
            method: "POST",
            url: root+"ajax.php",
            data: datas
        })
                .done(function (msg) {
                    $("#billets").html(msg);
                });
    }

    this.checkForm();
}

function confirmCancelScan(url){
    if(confirm('Confirmez-vous l\'annulation de ce scan ?')){
        document.location = url;
    }
}

function confirmValidate(url){
    if(confirm('Confirmez-vous l\'activation de ce billet ?')){
        document.location = url;
    }
}

function confirmInvalidate(url){
    if(confirm('Confirmez-vous la désactivation de ce billet ?')){
        document.location = url;
    }
}

function manualScan(url){
    if(confirm('Confirmez-vous le scan manuel de ce billet ?')){
        document.location = url;
    }
}

function cancelOkScan(url){
    if(confirm('Confirmez-vous l\'annulation du scan de ce billet ?')){
        document.location = url;
    }
}

function cancelFiltres(){
    jQuery('input').val('');
    jQuery('select').val('-1');
    filtres.reloadDatas();
}