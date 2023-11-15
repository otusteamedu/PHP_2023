#!/bin/bash

if [[ "$OSTYPE" != "darwin"* ]]; then
    BC_PACKAGE_STATUS=`dpkg -s $1 | grep "Status" `
    if [ -z "$BC_PACKAGE_STATUS" ]; then
        echo "BC package not installed"
        exit 1
    fi
fi

if [ -z "$1" ]
then
  echo "Argument 1 is empty"
  exit 1
fi

if [ -z "$2" ]
then
  echo "Argument 2 is empty"
  exit 1
fi

result=$(echo "$1 + $2" | bc)
echo "$result"

exit 0