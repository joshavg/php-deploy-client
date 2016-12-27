<?php

/**
 * api key for authentication
 */
define('KEY', null);

/**
 * maximum deploy execution time
 * set to 0 for no maximum
 */
define('MAX_EXECUTION_TIME', 5 * 60);

/**
 * where is the application located
 * will be the working directory of deploys
 */
define('WORKING_DIR', null);

/**
 * sets remote ip address of host who is allowed to trigger deploys
 */
define('ACCEPT_REMOTE_IP', null);
