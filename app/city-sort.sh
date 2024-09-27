#!/bin/env sh
head /app/data/data.txt | tail -n +2 | awk '{print $3}' | sort | uniq -c | sort -r -k 1 | head -n 3
