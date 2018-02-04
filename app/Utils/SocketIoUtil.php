<?php

namespace App\Utils;

use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version2X;

class SocketIoUtil
{
    public static function notifyNextImage()
    {
        $socketIoServer = env('PICS_SOCKET_SERVER');
        $client = new Client(new Version2X($socketIoServer));
        $client->initialize();
        $client->emit('pics message', ['msg' => 'next']);
        $client->close();
    }
}
