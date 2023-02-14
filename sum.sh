#!/bin/bash

# Инициализация переменных
RESULT=0
REGEX="^-?[0-9]+(\.[0-9]+)?$"

if [ $# -ne 2 ]; then
  echo "Нужно передать 2 числа."
  exit 1
else
  for i in $*; do
    if [[ $i =~ $REGEX ]]; then
      RESULT=$(echo "$RESULT $i" | awk '{ print $1 + $2 }')
    else
      echo "$i Не является числом."
      exit 2
    fi
  done
fi

echo "($1 + $2) = $RESULT"
exit 0
