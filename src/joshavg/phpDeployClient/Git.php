<?php

namespace joshavg\phpDeployClient;


use Monolog\Logger;

class Git
{

    /**
     * @var Logger
     */
    private $logger;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    public function checkout()
    {
        $this->logger->notice('executing "git checkout"');
        $ret = 0;
        $output = [];
        exec('git checkout', $output, $ret);

        if ($ret !== 0) {
            throw new DeployException('error while checkout, exit code: ' . $ret);
        }

        if (count($output)) {
            $this->logger->notice(implode("\n", $output));
        }
    }

}
