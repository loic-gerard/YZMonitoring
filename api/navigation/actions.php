<?php

namespace yz\navigation;

use yz\navigation\ActionItem;

class Actions{
    private static $items = array();
    
    public static function add($label, $icon, $url, $type = 'classic'){
        self::$items[] = new ActionItem($label, $icon, $url, $type);
    }
    
    public static function getAllItems(){
        return self::$items;
    }
}
