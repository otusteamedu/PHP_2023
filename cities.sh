#! /bin/bash

cat ./table.txt | awk '{if (NR > 1) {print $3}}' | sort | uniq -c | sort -r -k 1 | head -n 3 | awk '{print $2}'
