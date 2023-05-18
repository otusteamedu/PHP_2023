#!/bin/bash
REGEX='^[+-]?[0-9]+([.][0-9]+)?$'
FIRST_ARGUMENT=$1
SECOND_ARGUMENT=$2
if ! [[ $FIRST_ARGUMENT =~ $REGEX ]] ;
then echo "error: Not a number" >&2; exit 1
fi

if ! [[ $SECOND_ARGUMENT =~ $REGEX ]] ;
then echo "error: Not a number $SECOND_ARGUMENT"; exit 1
fi
SUM=$(echo "$FIRST_ARGUMENT + $SECOND_ARGUMENT" | bc)
echo "Sum: $SUM"