#!/bin/bash

cat home_work_linux_2_text.txt | awk 'NR!=1' | awk '{print $3}' | sort | uniq -c | sort -r | head -3 
