#!/bin/bash

cat table1.txt | awk '{ print $3 }' | sort | uniq -c | sort -n | tail -n 3 | awk '{ print $2 }'
