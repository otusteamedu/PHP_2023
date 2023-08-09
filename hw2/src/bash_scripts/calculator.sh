#!/bin/bash

echo "Привет! Я - калькулятор, могу сложить два числа"

while true; do
  read -p "Введите первое число: " number1
  read -p "Введите второе число: " number2
  if [[ $number1 =~ [[:digit:]] && $number2 =~ [[:digit:]] ]]; then
    sum=$(echo "$number1 + $number2" | bc)
    echo "Сумма чисел равна: $number1 + $number2 = $sum"
    break
  else
    echo "Где-то ввели не число, попробуем еще раз"
  fi
done


