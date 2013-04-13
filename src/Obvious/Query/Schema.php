<?php
    namespace Obvious\Query;

    use Doctrine\DBAL\Driver\Connection;
    use Obvious\Container;
    use Obvious\DI;
    use PDO;

    class Schema
    {
        const TABLE = 'BASE TABLE';
        const VIEW  = 'VIEW';

        /**
         * @return Schema
         */
        private static function instance()
        {
            return Container::get(DI::SCHEMA_QUERY);
        }

        /**
         * @return \Doctrine\DBAL\Connection
         */
        private function getConnection()
        {
            return Container::get(DI::DOCTRINE_CONNECTION);
        }

        public static function listDatabases()
        {
            $conn = self::instance()->getConnection();
            return $conn->getSchemaManager()->listDatabases();
        }

        public static function listTables()
        {
            $conn = self::instance()->getConnection();
            return $conn->getSchemaManager()->listTables();
        }

        public static function listViews()
        {
            $conn = self::instance()->getConnection();
            return $conn->getSchemaManager()->listViews();
        }
    }