<?php
// Zabbix GUI configuration file.
global $DB, $HISTORY;

$DB = [
	// Add configuration data for keys not set by environment variable.
	'TYPE' => '',
	'SERVER' => '',
	'PORT' => '',
	'USER' => '',
	'PASSWORD' => '',
	'SCHEMA' => '',
	'DATABASE' => ''
];

foreach ($DB as $key => &$value) {
	if (getenv("ZBX_DB_{$key}") !== false) {
		$value = getenv("ZBX_DB_{$key}");
	}
	// Apache on internal rewrites prepend REDIRECT_ prefix to environment variables.
	elseif (getenv("REDIRECT_ZBX_DB_{$key}") !== false) {
		$value = getenv("REDIRECT_ZBX_DB_{$key}");
	}
}

$ZBX_SERVER      = 'localhost';
$ZBX_SERVER_PORT = '10054';

$ZBX_SERVER_NAME = sprintf('%s/%s %s:%s', $DB['TYPE'], $DB['DATABASE'], $ZBX_SERVER, $ZBX_SERVER_PORT);

$IMAGE_FORMAT_DEFAULT = IMAGE_FORMAT_PNG;

// Log all php errors including E_NOTICE to file.
set_error_handler(function($errno, $errmsg, $errfile, $errline) {
	file_put_contents(
		'/home/gcalenko/git.zabbix.com/php.error.log',
		"{$errmsg} in file {$errfile} on line {$errline}".PHP_EOL,
		FILE_APPEND
	);
});
