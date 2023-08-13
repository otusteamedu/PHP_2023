#!/bin/bash

if [ ! -f $1 ]; then
  echo 'Файл не найден';
  exit 1;
fi

awk '{print $3}' $1 | awk 'NR!= 1' | sort | uniq -c | sort -r | head -3;