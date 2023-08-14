#!/bin/bash

#trap 'echo "# $BASH_COMMAND";read' DEBUG
RED="\e[31m"
GREEN="\e[32m"
ENDCOLOR="\e[0m"
REG='^[+-]?[0-9]+([.][0-9]+)?$'
PACKAGE="bc"

I=`dpkg -s $PACKAGE | grep "Status" `
if [ -n "$I" ]
then
   if ! [[ $1 =~ $REG ]] ; then
    echo -e "${RED}Первый параметр - ($1) не является числом${ENDCOLOR}" >&2; exit 1
   elif ! [[ $2 =~ $REG ]] ; then
    echo -e "${RED}Второй параметр - ($2) не является числом${ENDCOLOR}" >&2; exit 1
   fi

   SUM=$(echo $1 $2 | awk '{print $1 + $2}')
   echo -e "${GREEN}Сумма чисел $1 и $2: $SUM${ENDCOLOR}"
else
  echo -e "${RED}Пакет $PACKAGE не установлен${ENDCOLOR}"; exit 1
fi