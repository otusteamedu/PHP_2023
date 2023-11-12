#!/bin/bash
if ! dpkg -s bc >/dev/null 2>&1
then
  echo "installing bc package..."
  if ! sudo apt install -y bc > /dev/null 2>&1 
  then
    echo "Something went wrong..exiting";
    exit 1;
  else
    echo "success!";
  fi
fi

if [ $# -ne 2 ]
then
 echo "Wrong arguments count"
 exit 1
fi

regxp="^[+-]?[0-9]+([.][0-9]+)?$"

if ! [[ $1 =~ $regxp ]]
then
  echo "First arg not a number!" >&2;
  exit 1
fi

if ! [[ $2 =~ $regxp ]]
then
  echo "Second arg not a number!" >&2;
  exit 1
fi

sum=$(echo "$1 + $2" | bc)
echo "sum is: $sum";
