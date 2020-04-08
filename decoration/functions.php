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
use Symfony\Component\VarDumper\Dumper\HtmlDumper;

/**
 * dump default - auto determined if cli or web view
 * then die
 */
function dd() {
    call_user_func_array('dump', func_get_args());
    die;
}

/**
 * dump default - auto determined if cli or web view
 */
function d() {
    call_user_func_array('dump', func_get_args());
}

/**
 * use openbsd-netcat to monitor the debug
 *
 * nc -lkU ./debug.sock
 */
function t() {
    static $sock;
    static $dumper;
    static $cloner;

    if (!$sock) {
        $path = 'unix:///var/www/html' . dirname($_SERVER['PHP_SELF']) . '/debug.sock';
        $path = '/dev/stdout';
        $sock = stream_socket_client($path, $errno, $errstr);
    }

    if (!$dumper) {
        $dumper = new CliDumper();
    }

    if (!$cloner) {
        $cloner = new VarCloner();
    }

    extract(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 1)[0]);
    $file = substr($file, strpos($file, '/php/') + 5);
    fwrite($sock, sprintf("\033[4m\033[31m\033[1m> %s:%d \033[0m\n", $file, $line));

    $args = func_get_args();
    if (!$args) {
        $dumper->setColors(false);
        fwrite($sock, chr(10).'$_REQUEST '.date('Y-m-d H:i:s').PHP_EOL);
        $dumper->dump($cloner->cloneVar($_REQUEST), $sock);
        fwrite($sock, '--/req--'.PHP_EOL);
    } else {
        $dumper->setColors(true);
        foreach($args as $var) {
            $dumper->dump($cloner->cloneVar($var), $sock);
        }
    }
}

/**
 * Presentable html file dump local to request entry.
 */
function f() {
    static $dumper;
    static $cloner;

    $path = '/var/www/html' . dirname($_SERVER['PHP_SELF']);

    if (!$dumper) {
        $dumper = new HtmlDumper();
    }

    if (!$cloner) {
        $cloner = new VarCloner();
    }

    extract(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 1)[0]);

    $args = func_get_args();
    if (!$args) {
        $dumper->dump($cloner->cloneVar($var), $path.'/debug.html');
    } else {
        foreach($args as $var) {
            $dumper->dump($cloner->cloneVar($var), $path.'/debug.html');
        }
    }
}
