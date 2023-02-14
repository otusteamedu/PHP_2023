#!/bin/bash

if [[ $# -ne 2 ]]; then
  echo "Error: 2 arguments expected, $# provided"
  exit 1
fi

re='^[+-]?[0-9]+([.][0-9]+)?$'
if ! [[ $1 =~ $re ]] ; then
  echo "Ошибка: Первый аргумент должен быть числом" >&2
  exit 1
fi

if ! [[ $2 =~ $re ]] ; then
  echo "Ошибка: Второй аргумент должен быть числом" >&2
  exit 1
fi

sum=$(awk 'BEGIN {printf "%f", '"$1"' + '"$2"'}')

echo "$sum"
