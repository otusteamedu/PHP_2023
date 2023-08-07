#!/bin/bash
var=$(awk '(NR>1) {print $3}' table.txt)
printf "$var" | sort | uniq -c | sort -k 1 -r | tr -d '[:digit:]' | head -3
