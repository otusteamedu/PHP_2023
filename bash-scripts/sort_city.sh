#!/bin/bash

awk -F ' ' '{print $3}' cities.txt | awk 'NR!= 1' | sort | uniq -c | sort -nr | head -3
