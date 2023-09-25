#!/bin/bash

awk '{print $3}' table.txt | #Print only third column
awk 'NR!=1' | #Remove first row - head
sort | #Sort - unknow why don't work without it
uniq -c | #Count duplicate values
sort -rbg | #Sort reverse, ignore spaces, numeric-sort
head -3 #Top 3 rows