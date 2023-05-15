#!/bin/bash
FILE=$1
if [ -z "$FILE" ]; then
  echo "Укажите путь к файлу"
  exit 1
fi

if [ ! -f "$FILE" ]; then
    echo "Файл не найден"
    exit 1
fi
awk '{print $3}' $FILE | sort | uniq -c | sort -rn | head -3
