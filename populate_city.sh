#!/bin/bash

cat populate_city.txt | awk 'NR>1' | awk '{print $4, $3, $1}' | sort -k4 | head -n 3