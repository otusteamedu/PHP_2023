#!/bin/sh

awk -F ' ' '{print $3}' cities | awk 'NR!= 1' | sort | uniq -c | sort -nr | head -3

