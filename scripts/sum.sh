#!/bin/bash

if [ $# != 2 ]; then
    echo "error: 2 arguments are required" >&2; exit -1
fi

REGEX='^[+-]?[0-9]+([,][0-9]+)?$'

x=$1
y=$2

if ! [[ $x =~ $REGEX ]] ; then
   echo "error: First argument is not a number" >&2; exit -1
fi

if ! [[ $y =~ $REGEX ]] ; then
   echo "error: Second argument is not a number" >&2; exit -1
fi

echo "$x $y" | awk '{c=$1+$2; printf "Сумма %s", c}'