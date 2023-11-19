#!/bin/env bash 

cat tab.txt | tail -n +2 | \
    awk {'print $3'} | sort | \
    uniq -c | sort -r -V| \
    head -n 3 | awk {'print $2'}