#!/bin/bash

if [ -f $1 ]; then
  awk '{print $3}' $1 | sort | uniq -c | sort -r | head -3
  exit 1
else
  echo "Такого файла нет $1"
  exit 0
fi
