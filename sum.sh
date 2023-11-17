#!/bin/bash

regexNumber='^[-]?[0-9]*\.?[0-9]+$'

if ! [[ $1 =~ $regexNumber ]] || ! [[ $2 =~ $regexNumber ]] ; then
        echo "$1 или $2 - не является целочисленным|отрицательными|вещественным числом."
fi


sum=$(awk "BEGIN { print $1 + $2 }")
echo "$1 + $2 = $sum"