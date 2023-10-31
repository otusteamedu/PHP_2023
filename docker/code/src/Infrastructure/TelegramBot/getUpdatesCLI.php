<?php

/**
 * This file is part of the PHP Telegram Bot example-bot package.
 * https://github.com/php-telegram-bot/example-bot/
 * (c) PHP Telegram Bot Team
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * This file is used to run the bot with the getUpdates method.
 */

// Load composer
$config = require __DIR__.'/config.php';

require_once $config['home_dir'].'/vendor/autoload.php';

// Load all configuration options
/** @var array $config */

try {
    // Create Telegram API object
    $telegram = new Longman\TelegramBot\Telegram($config['api_key'], $config['bot_username']);
    
    /**
     * Check `hook.php` for configuration code to be added here.
     */
    
    $telegram->enableMySql($config['mysql']);
    
    // Load all command-specific configurations
    foreach ($config['commands']['configs'] as $command_name => $command_config) {
        $telegram->setCommandConfig($command_name, $command_config);
    }
    
    $telegram->addCommandsPaths($config['commands']['paths']);
    while (true) {
        // Handle telegram getUpdates request
        $server_response = $telegram->handleGetUpdates();
        
        if ($server_response->isOk()) {
            $res = $server_response->getResult();
            $update_count = count($res);
            if ($update_count > 0) {
                echo date('Y-m-d H:i:s').' - Processed '.$update_count.' updates';
            }
        } else {
            echo date('Y-m-d H:i:s').' - Failed to fetch updates'.PHP_EOL;
            echo $server_response->printError();
        }
        usleep(1000);
        break;
    }
} catch (Longman\TelegramBot\Exception\TelegramException $e) {
    // Log telegram errors
    Longman\TelegramBot\TelegramLog::error($e);
    
    // Uncomment this to output any errors (ONLY FOR DEVELOPMENT!)
    echo $e;
} catch (Longman\TelegramBot\Exception\TelegramLogException $e) {
    // Uncomment this to output log initialisation errors (ONLY FOR DEVELOPMENT!)
    echo $e;
}
?>