<?php
    namespace Obvious;

    use ArrayAccess;
    use Pimple;

    class Container
    {
        /**
         * @var     Container
         */
        private static $instance;

        /**
         * @var     Pimple
         */
        private $pimple;

        private function __construct()
        {
            $this->pimple = new Pimple();
        }

        private static function instance()
        {
            if (!self::$instance) self::$instance = new Container();
            return self::$instance;
        }

        public static function get($name)
        {
            $pimple = self::instance()->pimple;
            return $pimple[$name];
        }

        public static function set($name, $value, $singleton=false)
        {
            $pimple = self::instance()->pimple;
            $pimple[$name] = $singleton ? $pimple->share($value) : $value;
        }
    }

    class DI
    {
        const OBVIOUS = 'obvious';

        const CONFIG = 'config';
        const CONNECTION = 'connection';
        const PDO_CONNECTION = 'pdo.connection';
        const EVENT_DISPATCHER = 'event-dispatcher';
        const CONNECTION_EVENT = 'connection-event';
        const SCHEMA_QUERY = 'schema-query';
        const DOCTRINE_CONNECTION = 'doctrine-connection';
    }