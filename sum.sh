#!/bin/bash
#Написать консольное приложение (bash-скрипт), который принимает два числа и выводит их сумму в стандартный вывод

SUM=0

#Количество аргументов < 1 Вывод ошибки
if [ $# -lt 1 ]; then
    echo 'Команда должна вызываться с 2 числовыми аргументами'
    exit 1
fi

#Количество аргументов < 2 Вывод ошибки
if [ $# -lt 2 ]; then
    echo 'Укажите второе числовое значение'
    exit 1
fi

#Количество аргументов > 2 Вывод ошибки
if [ $# -gt 2 ]; then
    echo 'Значений не должно быть больше двух'
    exit 1
fi

#Проходимся в цикле проверяем на число и суммируем все значения
for arg in "$@"; do
  if [[ ! $arg =~ ^[+-]?[0-9]+([.,][0-9]+)?$ ]]; then
    echo "Ошибка: $arg не является числом"
    exit 1
  else
    arg=${arg//,/.}

    SUM=$(echo "$SUM + $arg" | bc)
  fi
done

echo "Сумма переданных чисел равна $SUM"