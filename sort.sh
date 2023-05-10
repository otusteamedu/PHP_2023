#!/bin/bash

cat "table.txt" | awk '{print $3}' | sort | uniq -c | sort -rn | head -n 3 | awk '{ print $2 }'