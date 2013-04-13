<?php
    namespace Obvious\Event;

    use Exception;
    use Symfony\Component\EventDispatcher\Event;

    class ConnectionEvent extends Event
    {
        const CONNECTION_START   = 'db.conn.start';
        const CONNECTION_ERROR   = 'db.conn.error';
        const CONNECTION_SUCCESS = 'db.conn.success';

        private $code;
        private $message;
        private $exception;

        public static function getMessageForCode($code)
        {
            switch ($code) {
                case self::CONNECTION_START:
                    return 'Connection to mysql@%s started';
                    break;
                case self::CONNECTION_ERROR:
                    return 'Connection to mysql@%s failed';
                    break;
                case self::CONNECTION_SUCCESS:
                    return 'Connected to mysql@%s';
                    break;
            }

            return null;
        }

        public function setCode($code)
        {
            $this->code = $code;
        }

        public function getCode()
        {
            return $this->code;
        }

        public function setException(Exception $exception)
        {
            $this->exception = $exception;
        }

        public function getException()
        {
            return $this->exception;
        }

        public function setMessage($message)
        {
            $this->message = $message;
        }

        public function getMessage()
        {
            return $this->message;
        }
    }