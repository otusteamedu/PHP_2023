#!/bin/bash

cat ./file.txt | sort -n -k 4 -r | uniq | head -n 3 | awk '{print $3}'