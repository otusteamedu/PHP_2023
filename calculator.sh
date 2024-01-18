#!/bin/bash

if [ $(dpkg-query -W -f='${Status}' bc 2>/dev/null | grep -c "ok installed") -eq 0 ];
then
  echo 'Установите пакет bc';
  exit;
fi

if [ $# -ne 2 ]
then
echo "Укажите 2 параметра"
exit
fi

validateNumber () {
  local numb
  numb=$(echo $1 | tr "," .)

  dot_count=$(echo $numb | tr -cd '.' | wc -c)

  if [ $dot_count -gt 1 ]
  then
  return 0
  fi

  numb=$(echo "$numb" | tr -d '0-9.\-')

  if [ ${#numb} -gt 0 ]
  then
  return 0
  fi

  return 1
}

if validateNumber $1 -eq 0; 
then
  echo "Ошибка формата первого числа"
  exit;
fi

if validateNumber $2 -eq 0; 
then
  echo "Ошибка формата второго числа"
  exit;
fi

n1=$(echo $1 | tr "," .)
n2=$(echo $2 | tr "," .)

sum=$(echo "$n1 + $n2" | bc)
echo "Сумма чисел: $sum"