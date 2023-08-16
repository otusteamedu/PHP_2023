#!/bin/bash

sort=`cat ./sort.txt | tail -n +2 | awk '{print $3}' | sort | uniq -c | sort -rnk1 | awk '{print $2}' | head -n 3`

echo "$sort"