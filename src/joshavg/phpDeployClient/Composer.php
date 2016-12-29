<?php

namespace joshavg\phpDeployClient;


use Monolog\Logger;

class Composer
{

    /**
     * @var Logger
     */
    private $logger;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    public function install()
    {
        $this->logger->notice('executing "composer install"');

        $ret = 0;
        $output = [];
        exec('composer install', $output, $ret);

        if ($ret !== 0) {
            throw new DeployException('error while install, exit code: ' . $ret);
        }

        if (count($output)) {
            $this->logger->notice(implode("\n", $output));
        }
    }

}
