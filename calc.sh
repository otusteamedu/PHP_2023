#!/bin/bash
FIRST_ARG=$1
SECOND_ARG=$2
REGEX="^[-+]?[0-9]+[\.|\,]?[0-9]*$"
if [[ ! $FIRST_ARG =~ $REGEX ]];
then
    echo "Argument 1 is not a number"
    exit
fi
if [[ ! $SECOND_ARG =~ $REGEX ]];
then
    echo "Argument 2 is not a number"
    exit
fi
FIRST_ARG=$(sed -e "s/[,]/./g" <<< $FIRST_ARG)
SECOND_ARG=$(sed -e "s/[,]/./g" <<< $SECOND_ARG)
if ! command -v bc &> /dev/null
then
    TOTAL=$(awk "BEGIN {print $FIRST_ARG + $SECOND_ARG;}") 
else
    TOTAL=$(bc <<< $FIRST_ARG+$SECOND_ARG)
fi
echo $TOTAL