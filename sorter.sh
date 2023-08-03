#!/bin/bash

awk '$1 ~ /^[0-9]+$/ { print $3 }' table.txt | sort | uniq -c | sort -r | awk '{ print $2}' | head -n 3