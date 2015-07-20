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
Output::addTemplate('interface_controledesentrees');
Output::addTemplate('defaultpage');

FilRouge::add('Contrôle des entrées', 'controledesentrees');

Output::set('title', 'Contrôle des entrées');
Output::addTo('js', '<script src="'.BASE_URL.'/js/controledesentrees/main.js"></script>');

?>

<div class="tablePanel">
    <div class="panelTitle">Résultats de la recherche</div>
    <div class="panelContent" id="billets">
        
    </div>
</div>