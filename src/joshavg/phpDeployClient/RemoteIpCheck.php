<?php

namespace joshavg\phpDeployClient;


use Monolog\Logger;

class RemoteIpCheck
{

    private $allowed;

    /**
     * @var Logger
     */
    private $logger;

    /**
     * RemoteIpCheck constructor.
     * @param $allowed
     * @param $logger
     */
    public function __construct($allowed, Logger $logger)
    {
        $this->allowed = $allowed;
        $this->logger = $logger;
    }

    public function run()
    {
        if ($this->allowed === null) {
            return;
        }

        $remote = $_SERVER['REMOTE_ADDR'];
        if ($this->allowed !== $remote) {
            throw new DeployPreCheckException('remote ip not allowed: ' . $remote);
        }
    }

}
