#!/bin/bash

file="city.txt"

cat $file | awk 'NR>1 {print $3}' | sort | uniq -c | sort -rn | head -n 3
