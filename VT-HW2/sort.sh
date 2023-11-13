#!/bin/sh

if [ -z $1 ]
then
	echo File name is empty
	exit 1
fi


if [ -z $2 ]
then
  COUNT_ROWS=3
else
  COUNT_ROWS=$2
fi

cat $1 | awk '{print $3}' | sort | uniq -c | sort -n -r | head -$COUNT_ROWS
