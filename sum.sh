#!/bin/bash

re='^[+-]?[0-9]+([.][0-9]+)?$'
if ! [[ $1 =~ $re ]] ; then
   echo "error: $1 Not a number" >&2;
   exit 1
fi
if ! [[ $2 =~ $re ]] ; then
   echo "error: $2 Not a number" >&2;
   exit 1
fi

awkSum() {
  echo -e "$1\n$2" | awk '{res+=$1;} END {print res}'
}

bcSum() {
  echo "$1 + $2" | bc
}

if ! [ -x "$(command -v bc)" ]; then
  awkSum $1 $2
else
  bcSum $1 $2
fi
