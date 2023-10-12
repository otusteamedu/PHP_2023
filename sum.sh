#!/bin/bash

error=0
need_bc=0
float='^[+-]?[0-9]+([.][0-9]+)?$'
int='^[+-]?[0-9]+$'

for i in $@
do
  if ! [[ $i =~ $float ]]
  then
     echo "Ошибка: операнд $i не является числом"
     error=1
  elif ! [[ $i =~ $int ]]
  then
    need_bc=1
    if ! command -v bc &> /dev/null
    then
      echo "Операнд $i не является целым числом"
      echo "Не найдена утилита bc для работы с вещественными числами."
      echo "Установка:"
      echo "apt-get update"
      echo "apt-get install bc"
      error=1
    fi
  fi
done

if [[ $error -eq 1 ]]
then
  exit 1
fi

sum=0

if [[ $need_bc -eq 1 ]]
then
  for i in $@
  do
    sum=$(echo $sum + $i | bc)
  done
else
  for i in $@
  do
    sum=$((sum + $i))
  done
fi

echo $sum
