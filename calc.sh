#!/bin/bash

echo "Это программа - калькулятор"
read -p "Введите число 1: " NUM1
while [ -z "$NUM1" ]; do
    echo "Вы ничего не ввели";
    read -p "Введите число 1: " NUM1
done
while [[ ! ("$NUM1" =~ ^[0-9,-]+$) ]]; do
    echo "Вы ввели не число";
    read -p "Введите число 1: " NUM1
done

read -p "Введите математческое действие: " ACTION
while [ -z "$ACTION" ]; do
    echo "Вы ничего не ввели";
    read -p "Введите математческое действие: " ACTION
done
while [[ ! ("$ACTION" =~ ^[-\+*/]$) ]]; do
    echo "Вы ввели не математическое действие, разрешено +-*/";
    read -p "Введите математческое действие: " ACTION
done

read -p "Введите число 2: " NUM2
while [ -z "$NUM2" ]; do
    echo "Вы ничего не ввели";
    read -p "Введите число 2: " NUM2
done
while [[ ! ("$NUM2" =~ ^[0-9,-]+$) ]]; do
    echo "Вы ввели не число";
    read -p "Введите число 2: " NUM2
done

SUM=$(($NUM1 $ACTION $NUM2))
echo "Ответ - $SUM"