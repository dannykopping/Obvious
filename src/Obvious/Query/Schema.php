<?php
    namespace Obvious\Query;

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
         * @return \PDO
         */
        private function getConnection()
        {
            return Container::get(DI::PDO_CONNECTION);
        }

        public static function listTables()
        {
            return self::instance()->getTablesOfType(self::TABLE);
        }

        public static function listViews()
        {
            return self::instance()->getTablesOfType(self::VIEW);
        }

        private function getTablesOfType($type)
        {
            $conn   = $this->getConnection();
            $config = Container::get('config');

            $schema = $config['schema'];

            $results = $conn->query("SHOW FULL TABLES IN `{$schema}` WHERE TABLE_TYPE = '{$type}'", PDO::FETCH_NUM);

            if (empty($results))
                return array();

            $tables = array();
            foreach ($results as $table) {
                $tables[] = $table[0];
            }

            return $tables;
        }
    }