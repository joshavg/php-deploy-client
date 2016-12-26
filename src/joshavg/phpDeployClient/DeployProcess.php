<?php

namespace joshavg\phpDeployClient;


use Monolog\Logger;

class DeployProcess
{
    /**
     * @var Git
     */
    private $git;

    /**
     * @var Composer
     */
    private $composer;

    /**
     * @var Logger
     */
    private $logger;

    public function __construct(Git $git, Composer $composer, Logger $logger)
    {
        $this->git = $git;
        $this->composer = $composer;
        $this->logger = $logger;
    }

    public function run()
    {
        $checkout = $this->git->checkout();

        if (!$checkout) {
            $this->logger->emergency('error while checkout, aborting');
            return;
        }

        $install = $this->composer->install();

        if (!$install) {
            $this->logger->emergency('error while installing');
        }
    }
}