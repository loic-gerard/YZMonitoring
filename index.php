<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

date_default_timezone_set('Europe/Paris');

//Chargement des classes de bases Jin
include 'framework-jin/jin/launcher.php';
use jin\output\webapp\WebApp;
use jin\JinCore;
use jin\db\DbConnexion;
use jin\output\webapp\context\Output;
use jin\log\Debug;
use jin\query\Query;

//Demarrage session
session_start();

//Inclusion de la configuration
include 'config/config.php';
define('ROOT_PATH', JinCore::getContainerPath());
define('BASE_URL', JinCore::getContainerUrl());

//Initialize launcher for DiatemProject classes
include ROOT_PATH.'api/yzcore.php';
spl_autoload_register(array('yz\YZCore', 'autoload'));

//Customs
foreach($custom AS $k => $v){
    Output::set($k, $v);
}

//Connexion BDD
$r = DbConnexion::connectWithSqLite3(DB_PATH);

//Initialisation de l'applicatif
WebApp::init('app/');