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
        $this->git->update();
        $this->composer->install();
    }
}
