#!/bin/bash

cat citys.txt | awk '{print $3}' | sort | uniq -c | sort -nr | head -3



