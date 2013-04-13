<?php
    use Obvious\Container;
    use Obvious\DI;
    use Obvious\Obvious;

    require_once "vendor/autoload.php";

    $o = new Obvious(array(
        'hostname' => 'localhost',
        'schema'   => 'ormtest',
        'username' => 'ormtest',
        'password' => 'ormtest',
    ));

    $o->connect();