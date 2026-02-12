<?php

/**
 * This file is part of Swow
 *
 * @link    https://github.com/swow/swow
 * @contact twosee <twosee@php.net>
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code
 */

declare(strict_types=1);

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Swow\Coroutine;
use Swow\Socket;

$server = new Socket(Socket::TYPE_TCP);
$server->bind('127.0.0.1', 9764)->listen();

Coroutine::run(function () use ($server) {
    while (true) {
        $client = $server->accept();
        Coroutine::run(function () use ($client) {
            $request = $client->readString();
            /** @var Application $app */
            $app = require_once __DIR__.'/../bootstrap/app.php';
            $app->handleRequest(Request::capture());
            $client->close();
        });
    }
});
