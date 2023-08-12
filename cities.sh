#!/usr/bin/env bash
cat cities.txt | awk 'NR!=1' | awk '{print $3}' | sort | uniq -c | sort -r | head -3