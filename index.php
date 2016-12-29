<?php


use joshavg\phpDeployClient\Composer;
use joshavg\phpDeployClient\DeployException;
use joshavg\phpDeployClient\DeployPreCheckException;
use joshavg\phpDeployClient\DeployProcess;
use joshavg\phpDeployClient\Git;
use joshavg\phpDeployClient\LoggerHandler;
use joshavg\phpDeployClient\RemoteIpCheck;
use Monolog\Logger;

error_reporting(E_ALL);

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/settings.php';

set_time_limit(MAX_EXECUTION_TIME);

$logger = new Logger('main');

$handler = new LoggerHandler();
$logger->pushHandler($handler);

$key = isset($_GET['key']) ? $_GET['key'] : null;
$success = false;

try {
    if (WORKING_DIR === null) {
        throw new DeployPreCheckException('working dir has not been configured');
    }

    if ($key !== KEY) {
        throw new DeployPreCheckException('api keys do not match, provided: ' . $key);
    }

    $remoteCheck = new RemoteIpCheck(ACCEPT_REMOTE_IP, $logger);
    $remoteCheck->run();

    $logger->notice('changing to working directory ' . WORKING_DIR);
    chdir(WORKING_DIR);

    $git = new Git($logger);
    $composer = new Composer($logger);

    $process = new DeployProcess($git, $composer, $logger);
    $success = $process->run();
} catch (DeployPreCheckException $e) {
    $logger->error($e->getMessage());
    http_response_code(500);
} catch (DeployException $e) {
    $logger->emergency($e->getMessage());
    http_response_code(500);
}

echo $handler->summarize();
