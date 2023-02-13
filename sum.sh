#!/bin/bash

if [ $# -ne 2 ]
then
  echo "Необходимо передать 2 числа"
  exit
fi

if [[ ! $1 =~ ^[-]?[0-9]+([.][0-9]+)?$ ]] || [[ ! $2 =~ ^[-]?[0-9]+([.,][0-9]+)?$ ]]
then
  echo "Необходимо передать 2 числа"
  exit
fi

BC=`dpkg -s bc | grep "Status"`

if [ -z "$BC" ]
then
  sudo apt-get update -y
  sudo apt-get install -y bc
fi

RESULT=`echo "$1+$2"|bc`
echo $RESULT
