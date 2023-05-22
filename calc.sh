#!/bin/bash

if [[ $# -ne 2 ]]; then
    echo "Usage: $0 <number1> <number2>"
    exit 1
fi

re='^[+-]?[0-9]+([.][0-9]+)?$'
if ! [[ $1 =~ $re ]] || ! [[ $2 =~ $re ]]; then
    echo "Error: Arguments must be numbers" >&2; exit 1
fi

awk "BEGIN {print $1+$2; exit}"
