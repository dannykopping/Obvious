<?php

    use Fig\Fig;
    use Obvious\Container;
    use Obvious\Query\Schema;

    class SchemaTest extends BaseTest
    {
        public function testListTables()
        {
            $this->assertCount(5, Schema::listTables());
        }

        public function testListViews()
        {
            $this->assertCount(1, Schema::listViews());
        }

        public function testListDatabases()
        {
            $this->assertGreaterThanOrEqual(1, count(Schema::listDatabases()));
        }
    }