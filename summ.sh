#!/bin/bash
NUM1=$1
NUM2=$2
if [[ $NUM1 =~ ^[\-\+]?[0-9]+\.?[0-9]*$ ]]; then
        if [[ $NUM2 =~ ^[\-\+]?[0-9]+\.?[0-9]*$ ]]; then
                echo "summ: "
                echo "$NUM1 $NUM2" | awk '{print $1 + $2}'
        else
                echo "second arg is not a number"
        fi
else
        echo "first arg is not a number"
fi