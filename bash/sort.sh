#!/usr/bin/env bash

FILE="sort.txt"

cat $FILE | awk 'NR>1 {print $3}' | sort | uniq -c | sort  -rn | head -n 3
