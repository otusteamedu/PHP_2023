#!/bin/bash

cat table.txt | grep -v "id" | awk '{print $3}' | sort -k1 | uniq -c | sort -nk1 -r | head -n3