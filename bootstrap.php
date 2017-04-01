<?php

    use Illuminate\Database\Capsule\Manager as Capsule;
    
    # LOAD "PHP Server Monitor" CONFIG
    require_once('../config.php');
    
    # ENABLE DEBUG
    if(PSM_DEBUG) {
        ini_set('display_errors', 'On');
        error_reporting(E_ALL);
    }

    # LOAD CLASSES
    require_once('vendor/autoload.php');

    # LOAD ELOQUENT
    $capsule = new Capsule;
    $capsule->addConnection([
        'driver'    => 'mysql',
        'host'      => PSM_DB_HOST,
        'database'  => PSM_DB_NAME,
        'username'  => PSM_DB_USER,
        'password'  => PSM_DB_PASS,
        'prefix'    => PSM_DB_PREFIX,
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
    ]);
    $capsule->setAsGlobal();
    $capsule->bootEloquent();

?>