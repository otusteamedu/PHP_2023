#!/usr/bin/env bash

if ! which bc > /dev/null; then
    echo "Пакет bc не установлен"
    exit
fi

echo 'Напишите exit в любом чтобы выйти или нажмите CTRL+C'
# Входные значения
read -r -p "Введите первый аргумент: " first_number

if [[ $first_number = "exit"  ]]; then
    exit;
fi

pattern='^-?[0-9]+?.[0-9]+'
if ! [[ $first_number =~ $pattern ]]; then
    echo "Вы ввели не число, допустивы целые числа, десятичные, положительные и отрицательные"
    exit
fi

result=$first_number

while :
do
    read -r -p "Введите знак -,+,/,*,^: " sign
    if [[ $sign = "exit"  ]]; then
        exit;
    fi

    read -r -p "Введите аргумент: " second_number
    if [[ $second_number = "exit"  ]]; then
            exit;
    fi
    if ! [[ $second_number =~ $pattern ]]; then
        echo "Вы ввели не число, допустивы целые числа, десятичные, положительные и отрицательные"
        exit
    fi

    if [[ $second_number = 0 && "$sign" = "/" ]]; then
        sign=""
    fi

    case "$sign" in
      "-"  ) result=$(echo "$result - $second_number" | bc);;
      "+"  ) result=$(echo "$result + $second_number" | bc);;
      "/"  ) result=$(echo "$result / $second_number" | bc);;
      "*"  ) result=$(echo "$result * $second_number" | bc);;
      "^"  ) result=$(echo "$result ** $second_number" | bc);;
      *) echo "Вы ввели недопустимый знак математической операции";;
    esac

    echo "Текущий результат: ${result}"
done

