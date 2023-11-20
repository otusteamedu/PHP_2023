#!/bin/bash

echo $(cat data.txt | awk '{ print $3 }' | sort | uniq -c | sort -k1 -r | head -n 3)
