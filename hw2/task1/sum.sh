#!/bin/bash

number_regex='^-?[0-9]+([.][0-9]+)?$'

if [ "$#" -ne 2 ]; then
    echo "Error: You must provide exactly two numbers."
    exit 1
fi

if ! [[ $1 =~ $number_regex ]] ; then
   echo "Error: The first argument is not a valid number."
   exit 1
fi

if ! [[ $2 =~ $number_regex ]] ; then
   echo "Error: The second argument is not a valid number."
   exit 1
fi

sum=$(echo "$1 + $2" | bc)

echo "The sum is: $sum"