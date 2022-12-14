<?php

declare(strict_types=1);

define('DEBUG', env('DEBUG', false));
define('ENVIRONMENT', env('ENVIRONMENT', 'production'));

if (DEBUG) {
	ini_set('display_errors', '1');
	ini_set('display_startup_errors', '1');
	error_reporting(E_ALL);
} else {
	ini_set('display_errors', '0');
	ini_set('display_startup_errors', '0');
}
