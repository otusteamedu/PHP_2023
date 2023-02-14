#!/bin/bash

if [ $# -ne 2 ]
then
  echo "Необходимо передать 2 числа"
  exit
fi

if [[ ! $1 =~ ^[-]?[0-9]+([.,][0-9]+)?$ ]] || [[ ! $2 =~ ^[-]?[0-9]+([.,][0-9]+)?$ ]]
then
  echo "Необходимо передать 2 числа"
  exit
fi

FORMATTED1=`echo "$1" | sed 's/[.]/,/g'`
FORMATTED2=`echo "$2" | sed 's/[.]/,/g'`

RESULT=`echo "$FORMATTED1 $FORMATTED2" | awk '{ print $1 + $2 }' | sed 's/[,]/./g'`

echo $RESULT
