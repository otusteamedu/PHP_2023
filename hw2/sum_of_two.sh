#!/bin/bash

NUMBER_OF_ARGS=$#
ARG_ONE=$1
ARG_TWO=$2
REGEX_NUMBER='^[-]?([0-9]+\.)?([0-9]+)$'

if [ $NUMBER_OF_ARGS -lt 2 ]; then
  echo "Please provide two arguments."
  exit 1
fi

if [ $NUMBER_OF_ARGS -gt 2 ]; then
  echo "You provided more than two arguments."
  exit 1
fi

for ARG in "$@"
do
  if ! [[ $ARG =~ $REGEX_NUMBER ]]; then
    echo "One of the arguments is not a correct number."
    exit 1
  fi
done

echo "$ARG_ONE" "$ARG_TWO" | awk '{print "The sum of arguments is: " $1 + $2}'
exit 0
