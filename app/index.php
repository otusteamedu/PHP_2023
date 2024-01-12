<?php

require_once __DIR__ . '/vendor/autoload.php';

use AppDeploy\ActualizeEnvGitAction;
use AppDeploy\Deploy;
use AppDeploy\DeployDTO;
use NdybnovHw03\CnfRead\ConfigStorage;

$cnfStorage = new ConfigStorage();

$gitCnf = $cnfStorage->fromDotEnvFile([__DIR__, '.env.git']);
$appVersion = $gitCnf->get('APP_VERSION');
$comment = $gitCnf->get('COMMENT');

echo sprintf(
    '%s:%s:%s',
    sprintf('%s.%s.%s', PHP_MAJOR_VERSION, PHP_MINOR_VERSION, PHP_RELEASE_VERSION),
    $appVersion,
    str_replace(' ', '_', $comment)
);

(isset($argv[1]) && (new ActualizeEnvGitAction())->run());

if ((isset($_SERVER['REQUEST_METHOD'])) && ($_SERVER['REQUEST_METHOD'] === 'POST')) {
    $config = $cnfStorage->fromDotEnvFile([__DIR__, '.env']);
    (new Deploy(new DeployDTO([
        'app_version' => $_POST['app_version'] ?? $appVersion,
        'comment' => $_POST['comment'] ?? $comment,
        'dir' => $config->get('DIR'),
        'repository' => $config->get('REPOSITORY'),
        'target_prj_dir' => $config->get('TARGET_PRJ_DIR'),
        'target_branch' => $config->get('TARGET_BRANCH'),
        'app_sub_dir' => $config->get('APP_SUB_DIR'),
        'log_file' => $config->get('LOG_FILE'),
    ])))->run();
}
