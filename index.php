<?php

error_reporting(E_ALL);

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/settings.php';

set_time_limit(MAX_EXECUTION_TIME);

$logger = new \Monolog\Logger('main');

$handler = new \joshavg\phpDeployClient\LoggerHandler();
$logger->pushHandler($handler);

$key = isset($_GET['key']) ? $_GET['key'] : null;
$success = false;

$remoteCheck = new \joshavg\phpDeployClient\RemoteIpCheck(ACCEPT_REMOTE_IP, $logger);

if ($key !== KEY) {
    $logger->error('api keys do not match, provided: ' . $key);
    $success = false;
} elseif (WORKING_DIR === null) {
    $logger->error('working dir has not been configured');
    $success = false;
} elseif ($remoteCheck->run() === false) {
    $logger->error('remote ip check failed');
    $success = false;
} else {
    $logger->debug('changing to working directory ' . WORKING_DIR);
    chdir(WORKING_DIR);

    $git = new \joshavg\phpDeployClient\Git($logger);
    $composer = new \joshavg\phpDeployClient\Composer($logger);

    $process = new \joshavg\phpDeployClient\DeployProcess($git, $composer, $logger);
    $success = $process->run();
}

if (!$success) {
    http_response_code(500);
}

echo $handler->summarize();
