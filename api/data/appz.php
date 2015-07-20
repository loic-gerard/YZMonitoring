<?php

namespace yz\data;

use jin\query\Query;
use jin\query\QueryResult;
use jin\query\QueryOfQuery;
use jin\lang\ArrayTools;
use yz\navigation\Url;
use jin\output\webapp\request\Request;
use jin\lang\StringTools;

class Appz{
    private static $appz = array('statistiques' => array('url' => 'statistiques', 'title' => 'Statistiques'),
                                 'controleentrees' => array('url' => 'controledesentrees', 'title' => 'Contrôle des entrées'));
    
    public static function getAppz(){
        $currentCode = Url::clearQueryArg(Request::getArgumentValue('q'));
        
        $dt = array();
        foreach(self::$appz AS $app){
            $app['selected'] = false;
            
            $appCode = $app['url'];
            if(StringTools::len($currentCode) >= StringTools::len($appCode) 
                && StringTools::left($currentCode, StringTools::len($appCode)) == $appCode 
                && $appCode != ''){
                $app['selected'] = true;
            }
            
            $dt[] = $app;
        }
       
        
        return $dt;
    }

}