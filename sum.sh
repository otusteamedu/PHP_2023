#!/bin/bash

if [ "$1" == "-help" ] || [ "$1" == "--help" ]; then
    echo "This script sums two numbers"
    echo "Uses two parameters (negative and real numbers)"
    exit 0;
fi

if [ "$#" != 2 ]; then
    echo "You have to provide two numbers in parameters"
    exit 1;
fi

echo "$1+$2" |  awk -F "+" '{print ($1+$2)}'