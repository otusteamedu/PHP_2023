#!/usr/bin/env bash

lines=$(cat city.txt | grep "id" -v | awk '{print $3}' | sort | uniq -c | sort -nr | head -n 3)

echo $lines
