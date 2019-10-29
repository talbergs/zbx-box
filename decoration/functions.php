<?php

/**
 * To add this file to project use `auto_prepend_file` in php.ini
 *
 * auto_prepend_file=functions.php
 *
 * In composer.json this exact version works with php 5.4
 * {"require": {"symfony/var-dumper": "2.8.50"}}
 */

require_once __DIR__.'/vendor/autoload.php';

use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\CliDumper;

/**
 * dump default - auto determined if cli or web view
 * then die
 */
function dd($var) {
	dump($var);
    die;
}

/**
 * dump default - auto determined if cli or web view
 */
function d($var) {
	dump($var);
}

/**
 * use openbsd-netcat to monitor the debug
 *
 * nc -lkU ./debug.sock
 */
function t($var) {
    static $sock;

    $cloner = new VarCloner();
    $dumper = new CliDumper();

    $dumper->setColors(true);
    if (!$sock) {
        $path = 'unix:///'.__DIR__.'/../www/debug.sock';
        $sock = stream_socket_client($path, $errno, $errstr);
        fwrite($sock, chr(10).'$_REQUEST '.date('Y-m-d H:i:s').PHP_EOL);
        $dumper->dump($cloner->cloneVar($_REQUEST), $sock);
        fwrite($sock, '--/req--'.PHP_EOL);
    }


    extract(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 1)[0]);
    $file = substr($file, strpos($file, '/php/') + 5);
    fwrite($sock, sprintf("\033[4m\033[31m\033[1m> %s:%d \033[0m\n", $file, $line));
    $dumper->dump($cloner->cloneVar($var), $sock);

    /* fclose($sock); */
}
