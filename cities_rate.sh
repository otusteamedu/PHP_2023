#!/bin/bash

cat ./cities.txt | tail -n+2 | awk '{print $3}' | sort | uniq -c | sort -r | awk '{print $2}' | head -n3