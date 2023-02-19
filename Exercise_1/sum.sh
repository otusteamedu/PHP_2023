#! /bin/bash
if ! [[ $1 =~ ^[-+]?[0-9]+\.?[0-9]*$ ]] || ! [[ $2 =~ ^[-+]?[0-9]+\.?[0-9]*$ ]]; then
    echo "Your inputed arguments is not a number, or not exists" >&2
    exit -1
fi

SUM=0
NUMBER_1=$1
NUMBER_2=$2

SUM=$(awk "BEGIN {print $NUMBER_1+$NUMBER_2; exit}")

echo "${NUMBER_1} + ${NUMBER_2} = ${SUM}"
