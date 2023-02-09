#!/bin/bash

ARGS=2
E_BADARGS=65
SUM=0

if [ $# -lt $ARGS ] || [ $# -gt $ARGS ]; then
    echo "Error: Two arguments expected"
    exit E_BADARGS
fi

for arg in $@
do
  if ! [[ $arg =~ ^(-?[0-9]+)(\.[0-9]+)?$ ]]; then
      echo "Error: Argument $arg is not a number"
      exit E_BADARGS
  fi
done

echo "Argument 1: $1"
echo "Argument 2: $2"

if ! command -v bc &> /dev/null
then
    SUM=$(echo $1 $2 | awk '{print $1 + $2}')

else
    SUM=$(echo "$1+$2" | bc -l)
fi

echo "Sum: $SUM"
