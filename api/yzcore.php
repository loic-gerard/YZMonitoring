<?php

namespace yz;

/**
 * Tâches de bas niveau de l'application YZMonitoring
 * @author Loïc Gerard
 */
class YZCore {

    /**
     * Fonction de chargement automatique des classes
     * @param  string $className Chemin complet de la classe requise
     */
    public static function autoload($className) {
        $tab = explode('\\', $className);
        $path = strtolower(implode(DIRECTORY_SEPARATOR, $tab)) . '.php';
        $path = str_replace('yz'.DIRECTORY_SEPARATOR, 'api'.DIRECTORY_SEPARATOR, $path);
        $path = str_replace('api'.DIRECTORY_SEPARATOR.'yzcore.php', '', __FILE__) . $path;

        if (is_file($path)) {
            require($path);
        }
    }

}
