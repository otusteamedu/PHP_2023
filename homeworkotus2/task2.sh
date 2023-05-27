#!/bin/bash
VAR=$(awk '{print $3}' ./table.txt)
echo "$VAR" > ./table.txt
SORTED=$(sort ./table.txt)
echo "$SORTED" > ./table.txt
CALCULATED=$(uniq -c ./table.txt)
echo "$CALCULATED" > ./table.txt
SORTED2=$(sort -k 1r ./table.txt)
echo "$SORTED2" > ./table.txt
FIRST3=$(head -n 3 ./table.txt)
echo "$FIRST3" > ./table.txt
echo "Result = $FIRST3"