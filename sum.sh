#!/usr/bin/env bash

function str_repeat() {
  result=""
  str=$1
  repeat=$2

  for i in $(seq 1 "$repeat")
  do
    result+="$str"
  done

  echo "$result"
}

function floatSum() {
  #вытаскиваем целую часть
  a1=$(echo "$1" | awk -F "." '{print $1}')
  b1=$(echo "$2" | awk -F "." '{print $1}')

  #вытаскиваем дробную часть
  a2=$(echo "$1" | awk -F "." '{print $2}')
  b2=$(echo "$2" | awk -F "." '{print $2}')

  if [[ ${#a2} -le 0 ]]; then
    a2=0
  fi

  if [[ ${#b2} -le 0 ]]; then
      b2=0
  fi

  # уравниваем длину дробной части
  if [[ ${#a2} -ge ${#b2} ]]; then
    maxLength=${#a2}
  else
    maxLength=${#b2}
  fi

  if [[ $maxLength > ${#a2} ]]; then
    a2+="$(str_repeat '0' $((maxLength-${#a2})))"
  fi

  if [[ $maxLength > ${#b2} ]]; then
      b2+="$(str_repeat '0' $((maxLength-${#b2})))"
  fi

  #складываем части
  c1=$((a1+b1))
  c2=$((a2+b2))

  if [[ ${#c2} > $maxLength ]]; then
    c1=$((${c2:0:${#c2}-$maxLength}+c1))
    c2=${c2:${#c2}-$maxLength:${#c2}}
  fi

  if [[ $c2 -gt 0 ]]; then
    echo "$c1.$c2"
  else
    echo "$c1"
  fi
}

if [ $# -ne 2 ]; then
  echo "Ошибка: необходимо ввести два аргумента. Оба аргумента должны быть числом."
  exit 1
fi

a=$1
b=$2
isIntRegExp='^[+-]?[0-9]+$'
isNumberRegExp='^[+-]?[0-9]+[\.]?[0-9]*$'

if ! [[ $a =~ $isNumberRegExp ]] || ! [[ $b =~ $isNumberRegExp ]]; then
  echo "Ошибка: Оба аргумента должны быть числом"
  exit 1
fi

#если оба числа целые
if [[ $a =~ $isIntRegExp ]] && [[ $b =~ $isIntRegExp ]]; then
  echo "Сумма "$((a+b))
  exit 0
else
  echo "Сумма "$(floatSum "$a" "$b") #можно вызывать только эту функцию она посчитает и целые числа и дробные, но думаю оптимальнее использовать только с дробями.
fi
