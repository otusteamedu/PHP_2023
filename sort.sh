#!/bin/bash
die() {
  echo $@ 1>&2
  exit 1
}

if [[ $# -ne 1 ]]
then
  die "Usage ./sort.sh file_to_sort"
fi

if ! [[ -f "$1" ]]; then
  die "Parameter $1 is not a valid file"
fi

if [[ -r "$1" ]]; then
  awk -F" " 'NF==4 {print $3}' "$1" | sort | uniq -i -c | sort -k 1nr | head -3 | awk '{print $2}'
else
  die "Sorry, you do not have read permission to sort the file!"
fi

