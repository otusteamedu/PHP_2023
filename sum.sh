#!/usr/bin/env bash

#CHECK_REGEX="^[+-]?[0-9]+([.][0-9]+)?$"
CHECK_REGEX="^[0-9]+$"

echo -n 'Введите первое число: '
read -r a

if ! [[ $a =~ $CHECK_REGEX ]]
then
  echo "ERROR: $a is not a number."
  exit 1
fi

echo -n 'Введите второе число: '
read -r b

if ! [[ $b =~ $CHECK_REGEX ]]
then
  echo "ERROR: $b is not a number."
  exit 2
fi


echo "$a + $b = $((a+b))"