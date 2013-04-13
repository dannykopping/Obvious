<?php

    use Fig\Fig;
    use Obvious\Container;
    use Obvious\DI;
    use Obvious\Obvious;

    class Test extends PHPUnit_Framework_TestCase
    {
        protected function setUp()
        {
            $config = array(
                'hostname' => 'localhost',
                'schema'   => 'ormtest',
                'username' => 'ormtest',
                'password' => 'ormtest',
            );

            Container::set(DI::OBVIOUS, function () use ($config) {
                return new Obvious($config);
            });
        }

        /**
         * @return Obvious
         */
        private function getObvious()
        {
            return Container::get(DI::OBVIOUS);
        }

        public function testInstance()
        {
            $this->assertInstanceOf('\\Obvious\\Obvious', $this->getObvious());
        }

        public function testConnectionExists()
        {
            $obvious = $this->getObvious();
            $this->assertInstanceOf('\\PDO', $obvious->connect());
        }
    }