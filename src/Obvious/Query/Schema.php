<?php
    namespace Obvious\Query;

    use Obvious\Container;
    use Obvious\DI;
    use PDO;

    class Schema
    {
        /**
         * @return \PDO
         */
        private function getConnection()
        {
            return Container::get(DI::PDO_CONNECTION);
        }

        public function listTables()
        {
            return $this->getTablesOfType();
        }

        public function listViews()
        {
            return $this->getTablesOfType('VIEW');
        }

        private function getTablesOfType($type = 'BASE TABLE')
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