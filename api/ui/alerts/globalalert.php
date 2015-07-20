<?php

namespace yz\ui\alerts;

use jin\lang\ArrayTools;

class GlobalAlert{
    private $title;
    private $texte;
    private $picto;
    private $classes = array('alert');
    
    public function __construct($title, $texte, $picto = 'flaticon-info') {
        $this->title = $title;
        $this->texte = $texte;
        $this->picto = $picto;
    }
    
    public function render(){
        $html = '<div class="'.ArrayTools::toList($this->classes, ' ').'">';
        $html .= '<div class="alertPicto '.$this->picto.'"></div>';
        $html .= '<div class="alertContent">';
        $html .= '<div class="alertTitle">'.$this->title.'</div>';
        $html .= '<div class="alertTexte">'.$this->texte.'</div>';
        $html .= '</div>';
        $html .= '</div>';
        
        return $html;
    }
    
    public function addClass($className){
        $this->classes[] = $className;
    }
}