#!/bin/bash

parameter1=$1
parameter2=$2
regular='^\-?[0-9]+(\.[0-9]+)?$'

if [ -z $parameter1 ]; then 
    echo "FIRST AND SECOND PARAMETERS DO NOT EXIST"
    exit 1
fi

if [ -z $parameter2 ]; then
    echo "SECOND PARAMETER DOES NOT EXIST"
    exit 1
fi

if [[ $parameter1 =~ $regular ]] && [[ $parameter2 =~ $regular ]]; then
     echo $parameter1 $parameter2 | awk '{print $1 + $2}'
else
    echo "THE INPUT VALUES DO NOT VALID"
fi

