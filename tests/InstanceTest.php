<?php

    use Fig\Fig;
    use Obvious\Container;
    use Obvious\Query\Schema;

    class InstanceTest extends BaseTest
    {
        public function testInstance()
        {
            $this->assertInstanceOf('\\Obvious\\Obvious', $this->getObvious());
        }

        public function testConnectionExists()
        {
            $obvious = $this->getObvious();
            $this->assertInstanceOf('\\Doctrine\\DBAL\\Connection', $obvious->connect());
        }
    }