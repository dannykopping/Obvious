<?php
    namespace Obvious;

    use Exception;
    use Obvious\Event\ConnectionEvent;
    use PDO;

    class Connection
    {
        private $hostname;
        private $schema;
        private $username;
        private $password;

        public function __construct($hostname, $schema, $username, $password)
        {
            $this->hostname($hostname);
            $this->schema($schema);
            $this->username($username);
            $this->password($password);
        }


        public function hostname($hostname = null)
        {
            if (!$hostname) return $this->hostname;

            $this->hostname = $hostname;
            return $this->hostname;
        }

        public function schema($schema = null)
        {
            if (!$schema) return $this->schema;

            $this->schema = $schema;
            return $this->schema;
        }

        public function username($username = null)
        {
            if (!$username) return $this->username;

            $this->username = $username;
            return $this->username;
        }

        public function password($password = null)
        {
            if (!$password) return $this->password;

            $this->password = $password;
            return $this->password;
        }

        public function connect()
        {
            try {
                $connection = new PDO('mysql:host=' . $this->hostname() . ';dbname=' . $this->schema(),
                    $this->username(),
                    $this->password());
            } catch (Exception $e) {
                $connEvent = Container::get(DI::CONNECTION_EVENT);
                $connEvent->setCode($e->getCode());
                $connEvent->setMessage($e->getMessage());
                $connEvent->setException($e);

                Container::get(DI::EVENT_DISPATCHER)->dispatch(ConnectionEvent::CONNECTION_ERROR, $connEvent);
            }

            if (isset($connection)) {
                Container::set(DI::PDO_CONNECTION, function () use ($connection) {
                    return $connection;
                }, true);

                return $connection;
            }

            return null;
        }
    }