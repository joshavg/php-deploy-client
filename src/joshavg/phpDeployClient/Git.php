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

    public function update()
    {
        $this->logger->notice('executing "git pull"');
        $ret = 0;
        $output = [];
        exec('git pull', $output, $ret);

        if ($ret !== 0) {
            throw new DeployException('error while checkout, exit code: ' . $ret);
        }

        if (count($output)) {
            $this->logger->notice(implode("\n", $output));
        }
    }

}
