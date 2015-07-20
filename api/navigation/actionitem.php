<?php

namespace yz\navigation;

class ActionItem{
    private $label;
    private $url;
    private $icon;
    private $type;
    
    public function __construct($label, $icon, $url, $type) {
        $this->label = $label;
        $this->icon = $icon;
        $this->url = $url;
        $this->type = $type;
    }
    
    public function render(){
        $class = 'actionitem '.$this->type;
        $out = '<div onclick="javascript:document.location=\''.$this->url.'\';" class="'.$class.'">';
        $out .= '<a href="'.$this->url.'">'.$this->label.'</a>';
        $out .= '</div>';
        return $out;
    }
}
