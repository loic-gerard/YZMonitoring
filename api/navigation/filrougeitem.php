<?php

namespace yz\navigation;

use yz\navigation\Url;
use jin\output\webapp\request\Request;

class FilRougeItem{
    private $label;
    private $urlCode;
    private $url;
    private $addedArgs;
    
    public function __construct($label, $urlCode = null, $addedArgs = array()) {
        $this->label = $label;
        
        if($urlCode){
            $this->urlCode = $urlCode;
            $this->url = Url::getUrlFromCode($urlCode, $addedArgs);
            $this->addedArgs = $addedArgs;
        }
    }
    
    public function isSelected(){
        if(Url::clearQueryArg(Request::getArgumentValue('q')) == Url::clearQueryArg($this->urlCode)){
            return true;
        }
        return false;
    }
    
    public function isLinkable(){
        if($this->urlCode){
            return true;
        }
        return false;
    }
    
    public function getLabel(){
        return $this->label;
    }
    
    public function getCode(){
        return $this->urlCode;
    }
    
    public function getUrl(){
        return $this->url;
    }
}

