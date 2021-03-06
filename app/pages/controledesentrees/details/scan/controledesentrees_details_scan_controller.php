<?php

use jin\output\webapp\context\DefaultController;
use jin\log\Debug;
use jin\query\Query;
use jin\lang\ArrayTools;
use jin\output\webapp\request\Request;
use yz\navigation\Url;
use yz\data\Billet;

class controledesentrees_details_scan_Controller extends DefaultController {
    public function onInit() {
        parent::onInit();
        
        if(Request::getArgumentValue('billet', true)){
            $billet = new Billet(Request::getArgumentValue('billet'));
            $billet->manualScan();
            Url::redirectTo('controledesentrees/details', array('billet' => Request::getArgumentValue('billet')));
        }else{
            Url::redirectTo('controledesentrees');
        }
    }
}
