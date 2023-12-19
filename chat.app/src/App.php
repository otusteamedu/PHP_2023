<?php

declare(strict_types= 1);

namespace Dshevchenko\Brownchat;

class App
{
    public function run($argv): void
    {
        $startServer = false;
        $startClient = false;
        $argc = count($argv);

        for ($i = 1; $i < $argc; $i++) {
            $param = strtolower($argv[$i]);
            if ($param == 'server') {
                $startServer = true;
                break;
            }
            elseif ($param == 'client') {
                $startClient = true;
                break;
            }
        }

        try {
            if ($startServer) {
                fwrite(STDOUT, "\nBROWNCHAT SERVER\n");
                fwrite(STDOUT, "----------------\n\n");
                $settings = parse_ini_file(__DIR__ . '/../config/App.ini');
                $server = new Server($settings);
                $server->run();
            }
            else if ($startClient) {
                fwrite(STDOUT, "\nBROWNCHAT CLIENT\n");
                fwrite(STDOUT, "----------------\n\n");
                $settings = parse_ini_file(__DIR__ . '/../config/App.ini');
                $client = new Client($settings);
                $client->run();
            }
            else {
                fwrite(STDOUT, "\nUsage: App.php COMMAND\n\n");
                fwrite(STDOUT, "Commands:\n");
                fwrite(STDOUT, "  server    start brownchat server\n");
                fwrite(STDOUT, "  client    start brownchat client\n");
            }
        } catch (\Exception $e) {
            fwrite(STDOUT, 'ERROR: '. $e->getMessage());
        }
    }
}
