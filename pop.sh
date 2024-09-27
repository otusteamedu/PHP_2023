#!/bin/bash

print_help () {
    echo "Usage: $0 filename"
}

if [ -n "$1" ]
then
  if [ ! -f "$1" ]; then
    echo "Error: $1 no exists."
    exit 1;
  fi

  tail -n +2 "$1" | awk '{print($3)}' | sort | uniq -c | sort -r -k1 | head -n3 | awk '{print($2)}'
  exit 0
else
  echo -e "Not filename.\n"
  print_help
  exit 1
fi
