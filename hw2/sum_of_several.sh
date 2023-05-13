#!/bin/bash

SUM=0
NUMBER_OF_ARGS=$#
REGEX_NUMBER='^[-]?([0-9]+\.)?([0-9]+)$'

if [ $NUMBER_OF_ARGS -lt 2 ]; then
  echo "Please provide at least two arguments."
  exit 1
fi

for ARG in "$@"
do
  if ! [[ $ARG =~ $REGEX_NUMBER ]]; then
    echo "One of the arguments is not a correct number."
    exit 1
  fi
done

for ARG in "$@"
do
  SUM=$(echo "$SUM" "$ARG" | awk '{print $1 + $2}')
done
echo "The sum of arguments is: $SUM"
exit 0
