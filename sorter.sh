#!/bin/bash
tail -n +2 ./table.txt | \
sort -k3 | \
awk '{print $3}' | \
uniq -c | \
sort -k1 -r | \
awk '{print $2}' | \
head -n 3
