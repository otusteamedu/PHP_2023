#!/bin/bash
if (($# < 2))
then
    echo "Количество аргументов меньше 2"
elif (($#> 2))
then
    echo "Количество аргументов больше 2"
else
    I=`dpkg -s bc | grep "Status"`
    if [ -z "$I" ] 
    then
        echo 'Начала установки bc пакета'
        apt-get install bc -y
        echo 'Конец установки'
    fi

    REGEX="^[+-]?[0-9]+([.][0-9]+)?$";
    if [[ $1 =~ $REGEX && $2 =~ $REGEX ]];
    then
        RES=$(bc<<<"scale=3;$1+$2")
        echo " $1 + $2 = "$RES 
    else
        echo "Аргументы должны содержать числа"
    fi 
fi