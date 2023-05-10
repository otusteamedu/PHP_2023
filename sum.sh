#! /bin/bash

FIRST_NUMBER=$1
SECOND_NUMBER=$2

REG_EXP='^[+-]?[0-9]+([.][0-9]+)?$'

NUMBER_NOT_FOUND_ERROR="Script need 2 arguments!"
NOT_NUMBER_ERROR="Argument is not number!"

if [ -z $FIRST_NUMBER ]
then
   echo $NUMBER_NOT_FOUND_ERROR;
   exit -1;
fi

if [ -z $SECOND_NUMBER ]
then
   echo $NUMBER_NOT_FOUND_ERROR;
   exit -1;
fi

if [[ $FIRST_NUMBER =~ $REG_EXP ]] && [[ $SECOND_NUMBER =~ $REG_EXP ]]; 
then
   echo $FIRST_NUMBER $SECOND_NUMBER | LC_NUMERIC="C" awk '{printf "%f\n", $1 + $2}'
else
   echo $NOT_NUMBER_ERROR;
   exit -1;
fi
