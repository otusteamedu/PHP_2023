#!/bin/bash

echo "Привет! Я - калькулятор, могу сложить два числа"

while true; do
  read -p "Введите первое число: " number1
  read -p "Введите второе число: " number2
  pattern='^[+-]?[0-9]+(\.[0-9]+)?$'
  if [[ $number1 =~ $pattern && $number2 =~ $pattern ]]; then
    sum=$(echo "$number1 $number2" | awk '{printf "%.1f", $1 + $2}')
    echo "Сумма чисел равна: $number1 + $number2 = $sum"
    break
  else
    echo "Где-то ввели не число, попробуем еще раз"
  fi
done
