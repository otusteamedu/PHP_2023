<?php

namespace Deployer;

require 'recipe/webpractik.php';

//========= КОНФИГ ========//
host('b2c.ru')
    ->hostname('127.0.0.1')
    ->user('b2с')
    ->port(27)
    ->identityFile('~/.ssh/id_rsa')
    ->addSshOption('StrictHostKeyChecking', 'no')
    ->set('deploy_path', '~/prod.b2c.ru_deployer')
    ->stage('master');

set('http_user', 'b2c'); // Пользователь SSH
set('doc_root', 'www'); // DOCUMENT_ROOT
set('writable_mode', 'chmod');
set('writable_use_sudo', false);
set('keep_releases', 5); // Кол-во папок с релизами
set('nvm', 'source ~/.nvm/nvm.sh');

//========= СИМЛИНКИ И ПРАВА НА ФАЙЛЫ ========//
// Неизменяемые файлы. Будут созданы ссылки на эти файлы в shared
set('shared_files', [
    '.environment',
    'robots.txt',
]);

// Неизменяемые папки. Будут созданы ссылки на эти папки в shared
set('shared_dirs', [
    'bitrix',
    'upload',
    'logs',
]);

//========= ЗАДАЧИ ========//
// Сборка фронта
task('deploy:npm-install', static function () {
    run('cd {{release_path}} && {{nvm}} && nvm install 10 && npm install');
});

task('deploy:front-build', static function () {
    run('cd {{release_path}} && {{nvm}} && nvm install 10 && npm run prod');
});

// Групповое задание по фронту
task('deploy:front', [
    'deploy:npm-install',
    'deploy:front-build',
]);

// Swagger
task('deploy:swagger', static function () {
    run('cd {{release_path}}/ && php artisan l5-swagger:generate --all');
});

// Swagger bitrixoa
task('deploy:bitrixoa', static function () {
    run('cd {{release_path}}/ && php vendor/bin/bitrixoa --bitrix-generate');
});

// Сбросить autoload
task('deploy:dump-autoload', static function () {
    run('cd {{release_path}} && composer dump-autoload -o');
});

task('cachetool:clear:stat', static function () {
    run('cd {{release_path}} && /usr/bin/php cachetool.phar stat:clear --cli');
});

//========= ПОСЛЕДОВАТЕЛЬНОСТЬ ВЫПОЛНЕНИЯ ========//
task('deploy', [
    'deploy:info',
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'deploy:front',
    'deploy:vendors',
    'deploy:writable',
    'deploy:swagger',
    'deploy:bitrixoa',
    'deploy:dump-autoload',
    'deploy:clear_paths',
    'deploy:symlink',
    'deploy:unlock',
    'cleanup',
    'success',
    'cachetool:clear:stat',
]);

after('success', 'wp:clear-stat-cache-without-curl'); // Очистка кеша путей
after('deploy:failed', 'deploy:unlock');
