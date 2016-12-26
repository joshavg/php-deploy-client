<?php

error_reporting(E_ALL);

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/settings.php';

set_time_limit(MAX_EXECUTION_TIME);

$logger = new \Monolog\Logger('main');

$handler = new \joshavg\phpDeployClient\LoggerHandler();
$logger->pushHandler($handler);

$key = isset($_GET['key']) ? $_GET['key'] : null;

if ($key !== KEY) {
    $logger->error('api keys do not match, provided: ' . $key);
} elseif (WORKING_DIR === null) {
    $logger->error('working dir has not been configured');
} else {
    $logger->debug('changing to working directory ' . WORKING_DIR);
    chdir(WORKING_DIR);

    $git = new \joshavg\phpDeployClient\Git($logger);
    $composer = new \joshavg\phpDeployClient\Composer($logger);

    $process = new \joshavg\phpDeployClient\DeployProcess($git, $composer, $logger);
    $process->run();
}

echo $handler->summarize();
