#!/bin/bash

awk -v col=3 '{print $col}' /Users/lebedev.vr/otus_php_2023/PHP_2023/scripts/users_table.txt | sort | uniq -c | sort -rn | awk ' NR==1, NR==3 {print $2}'