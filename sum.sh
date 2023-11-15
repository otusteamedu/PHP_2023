#!/bin/env bash
chmod +x sum.sh

fValue=$1
sValue=$2

re='^[-0-9.]+$'
if ! [[ $fValue =~ $re ]] ; then
  echo "Ошибка: Первый аргумент должен быть числом" >&2
  exit 1
fi

if ! [[ $sValue =~ $re ]] ; then
  echo "Ошибка: Второй аргумент должен быть числом" >&2
  exit 1
fi

sum=$(awk 'BEGIN {printf "%f", '"$fValue"' + '"$sValue"'}')

echo "$sum"
