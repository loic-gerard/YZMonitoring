<?php

namespace yz\ui\components\tablecell;

use jin\output\components\ui\UIComponent;
use jin\output\components\ComponentInterface;

class Button extends UIComponent implements ComponentInterface{
    /**
     *
     * @var boolean Valeur
     */
    private $value;
    
    
    /**
     * Constructeur
     * @param string $name  Nom du composant
     */
    public function __construct($name){
	parent::__construct($name, 'details');
    }
    
    
    /**
     * Effectue le rendu du composant
     * @return string
     */
    public function render(){
        $html = '<a href="'.$this->value['href'].'" class="'.$this->value['class'].' actionitem">'.$this->value['label'].'</a>';
        return $html;
    }
    
    
    /**
     * Retourne la valeur courante
     * @return boolean
     */
    public function getValue(){
	return $this->value;
    }
    
    
    /**
     * Définit la valeur du composant
     * @param mixed $value  Valeur (boolean ou 1|0)
     * @throws \Exception
     */
    public function setValue($value){
	$this->value = $value;
    }
}



