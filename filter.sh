#!/bin/bash
awk '(NR> 1)' tableUsers.txt | awk '{print $3}'| \
sort | uniq -c | sort -nr | head -3