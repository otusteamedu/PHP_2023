#!/bin/bash

RESULT=$(cat ./users.txt | tail -n +2 | awk '{print $3}' | sort | uniq -c | sort -r | head -n 3 | awk '{print $2}')
echo $RESULT

