#!/bin/sh

if [ -z $1 ]
then
	echo Arg 1 is emty
	exit 1
fi

if [ -z $2 ]
then
  echo Arg 2 is emty
  exit 1
fi
echo $1 $2 | awk '{print $1 + $2}'
