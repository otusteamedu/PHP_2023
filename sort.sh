#!/bin/bash

tail -n +2 table.txt | awk '{print $3}' | sort | uniq -c | sort -r -k1 | awk '{print $2}' | head -n 3
