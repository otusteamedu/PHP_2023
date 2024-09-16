#!/bin/bash

# Проверяем что бы скрипт был запущен через bash
if [ -z "$BASH" ]; then echo "Пожалуйста запустите скрипт $0 через оболочку bash"; exit; fi

# Проверяем установлен ли bc и если нет, просим установить его
if [ $(dpkg-query -W -f='${Status}' bc 2>/dev/null | grep -c "ok installed") -eq 0 ];
then
  echo 'Этому скрипту требуется установить пакет bc';
  exit;
fi


PRINT_N1="Введите первое число: "
PRINT_N2="Введите второе число: "
ERROR="Хм, кажется вы ввели не корреткное число, попробуйте еще раз: "

read -p "$PRINT_N1" n1

checkNumb () {
  local n

  # Заменим все "," на "." далее понадобится для проверки корректности введенных пользователем данных
  n=$(echo $1 | tr "," .)

  # Посчитаем сколько "." ввел пользователь, если больше 1-ой, значит что-то не так с числом
  cntN=$(echo $n | tr -cd '.' | wc -c)

  if [ $cntN -gt 1 ]
  then
	return 0
  fi

  n=$(echo "$n" | tr -d '0-9.\-')

  if [ ${#n} -gt 0 ]
  then
	return 0
  fi

  #идем к успеху
  return 1
}

while  checkNumb $n1; do
  read -p "$ERROR" n1
  checkNumb $n1
done

read -p "$PRINT_N2" n2

while  checkNumb $n2; do
  read -p "$ERROR" n2
  checkNumb $n2
done

# Сложение двух чисел

n1=$(echo $n1 | tr "," .)
n2=$(echo $n2 | tr "," .)

result=$(echo "$n1 + $n2" | bc)
echo "Результат сложения: $result"
