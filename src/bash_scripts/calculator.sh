#!/bin/bash

regex='^[+-]?[0-9]+([.][0-9]+)?$'

if ! [[ $1 =~ $regex ]] ; then
   echo "First argument is not a number" >&2; exit 1
elif 
   ! [[ $2 =~ $regex ]] ; then
   echo "Second argument is not a number" >&2; exit 1	
fi

echo $1 $2 | awk '{print $1 + $2}' 
