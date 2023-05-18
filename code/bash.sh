#!/bin/bash

if [[ $1 =~ ^[-]?[0-9]([.][0-9]+)?$ && $2 =~ ^[-]?[0-9]+([.][0-9]+)?$ ]]
then
    echo "$1 $2" | awk '{print $1 + $2}'
else
    echo "$1 or $2 is not a number"
fi