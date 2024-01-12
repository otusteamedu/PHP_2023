<?php

namespace AppDeploy;

class Deploy
{
    readonly private DeployDTO $dto;
    private const ENV_FILE = '.env';
    private const ENV_GIT_FILE = '.env.git';

    public function __construct(DeployDTO $dto)
    {
        $this->dto = $dto;
    }

    public function run(): bool
    {
        if (!$this->validRemoteVersion($this->dto->appVersion)) {
            $this->logStep("Incorrect remote version: {$this->dto->appVersion}");
            return false;
        }
        $this->logStep('Version validated remote successfully');

        $this->cloneRepository();
        $this->logStep('Repository cloned successfully');

        if (!$this->controlValidVersion($this->dto->appVersion)) {
            $this->logStep("Incorrect version: {$this->dto->appVersion}");
            return false;
        }
        $this->logStep('Version validated control successfully');

        $this->copyEnv();
        $this->logStep('Environment copied');

        $this->actualizeGitEnv();
        $this->logStep('Git environment updated');

        $this->dockerBuild();
        $this->logStep('App built');

        if (!$this->dockerUp()) {
            $this->logStep('App run failed!');
            return false;
        }
        $this->logStep('App ran');

        return true;
    }

    private function dockerUp(): bool
    {
        $appUp = 'docker compose up --detach --remove-orphans --timeout 0';
        $command = "cd {$this->getAbsolutePath(0)} && $appUp";

        return false !== $this->doCommand($command);
    }

    private function dockerBuild(): bool
    {
        $command = "cd {$this->getAbsolutePath(0)} && docker compose build";

        return false !== $this->doCommand($command);
    }

    private function validRemoteVersion(string $versionHash): bool
    {
        $rep = $this->dto->repository;
        $branch = $this->dto->targetBranch;
        $command = "git ls-remote $rep refs/heads/$branch | awk '{print $1}'";

        $result = $this->doCommand($command);
        $this->log("Remote version hash comparison: `$result` vs `$versionHash`");

        return ($result && $versionHash === $result);
    }

    private function controlValidVersion(string $versionHash): bool
    {
        $getLastCommitHash = 'git show -s --format=%H';
        $command = "cd {$this->getAbsolutePath(1)} && $getLastCommitHash";

        $result = $this->doCommand($command);
        $this->log("Version hash comparison: `$result` vs `$versionHash`");

        return ($result && $versionHash === $result);
    }

    private function doCommand(string $commandLine): bool|string
    {
        $output = [];
        $exitCode = 0;
        $result = exec($commandLine, $output, $exitCode);

        $isSuccess = (0 === $exitCode);
        $logMessage = $isSuccess ? 'Command (Ok):' : 'Command (Fail):';
        $this->log($logMessage . ' ' . $commandLine);
        $this->log(print_r($isSuccess ? $result : $output, true));

        return $isSuccess ? $result : false;
    }

    private function log(string $message): void
    {
        error_log('log: ' . $message, 3, $this->dto->logFile);
        error_log(PHP_EOL, 3, $this->dto->logFile);
    }

    private function logStep(string $message): void
    {
        error_log('Step: ' . $message, 3, $this->dto->logFile);
        error_log(PHP_EOL, 3, $this->dto->logFile);
        error_log(PHP_EOL, 3, $this->dto->logFile);
    }

    private function actualizeGitEnv(): bool
    {
        $pathToEnv = $this->getAbsolutePath(0, $this::ENV_GIT_FILE);
        $appVersion = "echo 'APP_VERSION='$(git log -1 --format='%H') > $pathToEnv";
        $comment = "echo \"COMMENT='\"$(git log -1 --format='%s')\"'\" >> $pathToEnv";
        $command = "cd {$this->getAbsolutePath(0)} && $appVersion && $comment";

        return false !== $this->doCommand($command);
    }

    private function copyEnv(): bool
    {
        $path = $this->getAbsolutePath(0, $this::ENV_FILE);
        $this->log('exist:' . $path);
        if (!file_exists($path)) {
            $copyFile = 'cp .env.example ' . $this::ENV_FILE;
            $command = "cd {$this->getAbsolutePath(0)} && $copyFile";

            return false !== $this->doCommand($command);
        }

        return true;
    }

    private function cloneRepository(): bool
    {
        $path = $this->getAbsolutePath(1);
        if (file_exists($path)) {
            $this->log('Path already exists: ' . $path);
            $checkout = "git checkout {$this->dto->targetBranch}";
            $pull = "git pull origin {$this->dto->targetBranch}";
            $command = "cd $path && $checkout && $pull";

            return false !== $this->doCommand($command);
        }

        $this->log('Path does not exist:' . $path);

        $cloneBranch = sprintf(
            'git clone --branch %s %s %s',
            $this->dto->targetBranch,
            $this->dto->repository,
            $this->dto->targetPrjDir
        );
        $command = "cd {$this->dto->dir} && $cloneBranch";

        return false !== $this->doCommand($command);
    }

    private function getAbsolutePath(int $levels, string $envFile = ''): string
    {
        $env = $envFile ?? $this::ENV_FILE;
        $dto = $this->dto;
        $path = implode(
            DIRECTORY_SEPARATOR,
            [$dto->dir, $dto->targetPrjDir, $dto->appSubDir, $env]
        );

        return $levels ? dirname($path, $levels) : $path;
    }
}
