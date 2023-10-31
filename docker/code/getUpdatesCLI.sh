#!/bin/bash

export XDEBUG_SESSION=1
export PHP_IDE_CONFIG="serverName=localhost"

while :
do
  result=$(php src/Infrastructure/TelegramBot/getUpdatesCLI.php )
  #echo "$result"
  if [ "$result" != "" ]; then
       echo "$result"
  fi
  if [ "$result" = "exit" ]; then
     break
  fi
done

echo "Скрипт завершил работу"