#!/bin/bash

function checkCountArgs {
    if [ $1 -ne 2 ]
      then
        echo "Должно быть 2 аргумента"
        exit -1
    fi
}

function checkArgumentIsNumber {
  ARG_COUNT=$1
  ARG_VALUE=$2
  REGEX="^[+-]?[0-9]+([.][0-9]+)?$"
  if [[ ! $ARG_VALUE =~ $REGEX ]];
      then echo "Аргумент #$ARG_COUNT должен быть числом"
      exit -1
  fi
}

function checkValidArgs {
    count=1
    for param in "$@"
      do
        checkArgumentIsNumber $count $param
        count=$(( $count + 1 ))
    done
}

function checkArgs {
  checkCountArgs $#
  checkValidArgs $@
}

checkArgs $@

NUMBER_1=$1
NUMBER_2=$2
RESULT=$(echo "$NUMBER_1 + $NUMBER_2" | bc)
echo "$NUMBER_1 + $NUMBER_2 = $RESULT"
exit 0
