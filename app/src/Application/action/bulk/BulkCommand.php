<?php

namespace App\Application\action\bulk;


class BulkCommand
{
    public function run($url, $bulkFileName): void
    {
        $command = sprintf(
            "curl -X POST '%s/_bulk' -H 'Content-Type: application/json' --data-binary '@data/%s'",
            $url,
            $bulkFileName
        );
        shell_exec($command);
    }
}
