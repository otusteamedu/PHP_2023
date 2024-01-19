#!/bin/bash

cat /dev/null > temp.txt
awk '{print $3}' "$1" >> temp.txt
awk 'FNR>1' "temp.txt" | sort | uniq -c | sort -rn | head -3