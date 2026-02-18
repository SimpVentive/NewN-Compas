<?php
error_reporting(E_ALL); 
defined('DS')  ? null : define('DS', DIRECTORY_SEPARATOR);

//echo realpath(dirname(__FILE__). '/../../application');
defined('APPPATH') || define('APPPATH', realpath(dirname(__FILE__) . '/../../application'));
defined('APPLICATION_PATH') || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../../application'));
defined('APPLICATION_PATH2') || define('APPLICATION_PATH2', realpath(dirname(__FILE__) . '/../..'));

include APPLICATION_PATH2 .DS.'dbconnect.php';

define('DOCTRINE_PATH', APPLICATION_PATH.DS.'helpers'.DS.'doctrine'.DS.'lib');
define('FIXTURES_PATH', APPLICATION_PATH.DS.'data'.DS.'fixture');
define('SQL_PATH', APPLICATION_PATH.DS.'data'.DS.'sql');
define('MIGRATIONS_PATH', APPLICATION_PATH.DS.'data'.DS.'migrations');
define('SCHEMA_PATH', APPLICATION_PATH.DS.'data'.DS.'schema.yml');
define('MODELS_PATH', APPLICATION_PATH.DS.'models');
define('DSN', 'mysql://'.DBUSER.':'.DBPASS.'@'.DBPATH.'/'.DBNAME);


$config=array("dsn"=>DSN, "data_fixtures_path"=>FIXTURES_PATH, "sql_path"=>SQL_PATH, "migrations_path"=>MIGRATIONS_PATH, "yaml_schema_path"=>SCHEMA_PATH, "models_path"=>MODELS_PATH);


require_once(DOCTRINE_PATH.DS.'Doctrine.php');
spl_autoload_register(array('Doctrine', 'autoload'));
spl_autoload_register(array('Doctrine_Core', 'modelsAutoload'));

$manager = Doctrine_Manager::getInstance();
$manager->setAttribute(Doctrine::ATTR_QUOTE_IDENTIFIER, true);
$manager->setAttribute(Doctrine::ATTR_AUTO_ACCESSOR_OVERRIDE, true);
$manager->setAttribute(Doctrine::ATTR_MODEL_LOADING,Doctrine::MODEL_LOADING_CONSERVATIVE);
$manager->setAttribute(Doctrine::ATTR_AUTOLOAD_TABLE_CLASSES,true);
//Doctrine_Core::setModelsDirectory(MODELS_PATH);
Doctrine_Core::loadModels(MODELS_PATH);

// open connection sample code
$conn = Doctrine_Manager::connection(DSN);
if ($conn === $manager->getCurrentConnection()) {
	//echo 'Current connection is the connection we just created!';
}

function __autoload($class_name){
	echo $class_name;
}

$cli = new Doctrine_Cli($config);
$cli->run($_SERVER['argv']);
