#!/bin/env bash

echo $(tail -n+2 table |
awk '{ print $3 }' |
sort | uniq -c | sort -k1 -r |
head -n3)
