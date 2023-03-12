#!/usr/bin/env bash

cat cities.txt | awk '{print $3}' | sort | uniq -c | sort -r | head -3