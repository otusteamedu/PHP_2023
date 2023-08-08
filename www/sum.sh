#!/bin/bash

# Написать консольное приложение (bash-скрипт),
# который принимает два числа и выводит их сумму в стандартный вывод.

# Например
# ./sum.sh 1.5 -7

# Если предоставлены неверные аргументы
# (для проверки на число можно использовать регулярное выражение)
# вывести ошибку в консоль.

# Если Вы запускаете скрипты на базе Docker под Windows 10,
# то поведение функции sort по умолчанию отличается от стандартного в linux
# (числа сортируются как числа, а не как строки)


function is_valid_number()
{
  re='^[+-.]?[0-9]+([.][0-9]+)?$'
  if ! [[ $1 =~ $re ]]
  then
    msgerror='error: Is not a valid number.'
    echo \'$1\' '=>' $msgerror >&2
    return 1
  fi
  return 0
}

function is_valid_or_exit
{
  is_valid_number $1
  if [[ 1 -eq $? ]]
  then
    echo 'Please check your parameters, they should be only numbers, and run again.'
    exit 1
  fi
}

a=$1
b=$2

is_valid_or_exit $a
is_valid_or_exit $b

summ=$(echo $a+$b | bc)

echo $summ
