<?php

namespace AppDeploy;

class ActualizeEnvGitAction
{
    public function run(): bool
    {
        $getLastCommitHash = "echo 'APP_VERSION='$(git log -1 --format='%H') > .env.git";
        $getLastCommitComment = "echo \"COMMENT='\"$(git log -1 --format='%s')\"'\" >> .env.git";
        $command = sprintf('%s && %s', $getLastCommitHash, $getLastCommitComment);

        exec($command, $output, $exitCode);

        return (0 === $exitCode);
    }
}
