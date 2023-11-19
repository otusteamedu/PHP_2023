#!/bin/env bash  

# Если нет аргументов - выходим
if [ "$#" -eq 0 ]
then
    exit 0
fi

# Объявляем строку аргументов
ARGS=""

# Заполняем строку аргументов
for i in "$@"
do
    ARGS="$ARGS $i"
done

# Переходим в папку с проектом
cd ./../public 

COMPOSERSTR="docker run --rm --interactive --tty --volume ./../public:/app site/composer $ARGS"
eval $COMPOSERSTR