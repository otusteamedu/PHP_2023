#!/bin/bash

echo $(awk 'FNR > 1 {print $3}' table.txt | sort | uniq -c | sort -r | head -n3)