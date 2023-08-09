#!/bin/bash

cities=$(awk '(NR>1) { print $3}' table.txt)
cities_sorted=$(echo "$cities" | sort)
cities_uniq=$(echo "$cities_sorted" | uniq -c)
result=$(echo "$cities_uniq" | sort -k1 -r | awk '{print $2}' | head -n3)
printf "The most popular cities are: %s\n$result"
