<?php
    namespace Obvious;

    use Doctrine\DBAL\Configuration;
    use Doctrine\DBAL\DriverManager;
    use Obvious\Event\ConnectionEvent;
    use Obvious\Query\Schema;
    use PDO;
    use Symfony\Component\EventDispatcher\EventDispatcher;

    class Obvious
    {
        private $defaultConfig = array(
            'hostname' => 'localhost',
            'schema'   => 'schema',
            'username' => 'root',
            'password' => '',
        );

        public function __construct(array $config = array())
        {
            Container::set(DI::CONFIG, empty($config) ? $this->defaultConfig : $config);

            $this->setupContainer();
            $this->addDefaultEventListeners();
        }

        private function setupContainer()
        {
            Container::set(DI::CONNECTION, function ($app) {
                $hostname = $app[DI::CONFIG]['hostname'];
                $schema   = $app[DI::CONFIG]['schema'];
                $username = $app[DI::CONFIG]['username'];
                $password = $app[DI::CONFIG]['password'];

                return new Connection($hostname, $schema, $username, $password);
            });

            Container::set(DI::DOCTRINE_CONNECTION, function ($app) {
                $config           = new Configuration();
                $connectionParams = array(
                    'dbname'   => $app[DI::CONFIG]['schema'],
                    'user'     => $app[DI::CONFIG]['username'],
                    'password' => $app[DI::CONFIG]['password'],
                    'host'     => $app[DI::CONFIG]['hostname'],
                    'driver'   => 'pdo_mysql',
                );
                return DriverManager::getConnection($connectionParams, $config);
            });

            Container::set(DI::EVENT_DISPATCHER, function () {
                return new EventDispatcher();
            }, true);

            Container::set(DI::CONNECTION_EVENT, function () {
                return new ConnectionEvent();
            });

            Container::set(DI::SCHEMA_QUERY, function () {
                return new Schema();
            });
        }

        /**
         * @return PDO
         */
        public function connect()
        {
            return $this->getConnection();
        }

        /**
         * @return Connection
         */
        private function getConnection()
        {
            return Container::get(DI::DOCTRINE_CONNECTION);
        }

        /**
         * @return EventDispatcher
         */
        private function getEventDispatcher()
        {
            return Container::get(DI::EVENT_DISPATCHER);
        }

        private function addDefaultEventListeners()
        {
            $this->getEventDispatcher()->addListener(ConnectionEvent::CONNECTION_ERROR, function ($e) {
                print_r($e);
            });
        }
    }