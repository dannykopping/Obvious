<?php

    use Obvious\Container;
    use Obvious\DI;
    use Obvious\Obvious;

    abstract class BaseTest extends PHPUnit_Framework_TestCase
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
        protected function getObvious()
        {
            return Container::get(DI::OBVIOUS);
        }
    }