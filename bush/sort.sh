#!/bin/bash

awk -F ' ' '{print $3}' table.txt | awk 'NR!= 1' | sort | uniq -c | sort -nr | head -3