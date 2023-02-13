#!/usr/bin/env bash
cat data.txt | awk 'NR>1 {count[$3]++} END {for (i in count) print count[i], i}' | sort -nr | head -3
