<?php

namespace AppDeploy;

class DeployDTO
{
    readonly public string $appVersion;
    readonly public string $comment;
    readonly public string $dir;
    readonly public string $repository;
    readonly public string $targetPrjDir;
    readonly public string $targetBranch;
    readonly public string $appSubDir;
    readonly public string $logFile;

    /**
     * Initializes the object with the provided data.
     *
     * @param array $dto The data transfer object containing the following keys:
     *                   - app_version: The version of the application.
     *                   - comment: The comment for the object.
     *                   - dir: The directory.
     *                   - repository: The repository.
     *                   - target_prj_dir: The target project directory.
     *                   - target_branch: The target branch.
     *                   - app_sub_dir: The application sub-directory.
     *                   - log_file: The log file.
     */
    public function __construct(array $dto)
    {
        $this->appVersion = $dto['app_version'];
        $this->comment = $dto['comment'];
        $this->dir = $dto['dir'];
        $this->repository = $dto['repository'];
        $this->targetPrjDir = $dto['target_prj_dir'];
        $this->targetBranch = $dto['target_branch'];
        $this->appSubDir = $dto['app_sub_dir'];
        $this->logFile = $dto['log_file'];
    }
}
