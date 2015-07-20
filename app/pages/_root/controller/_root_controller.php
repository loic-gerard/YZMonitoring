<?php

use jin\output\webapp\context\DefaultController;
use yz\navigation\Url;

class _root_Controller extends DefaultController{
    public function onInit(){
        Url::redirectTo('statistiques/');
        parent::onInit();
    }
}
