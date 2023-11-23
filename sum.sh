#!/usr/bin/env bash

re='^[+-]?[0-9]+([.][0-9]+)?$'

if [ ! $1 ];  then
	echo "error: Enter 1st number";  exit 1
fi

if ! [[ $1 =~ $re ]] ; then
   echo "error: First parameter is not a number"; exit 1
fi

if [ ! $2 ]; then
	echo "error: Enter 2nd number"; exit 1
fi

if ! [[ $2 =~ $re ]] ; then
   echo "error: Second parameter is not a number" >&2; exit 1
fi

echo Sum is $(awk "BEGIN{ print $1 + $2 }")