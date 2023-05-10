#!/bin/bash

cat table.txt | awk '{print $3}' | sort | uniq -c | sort -r | head -n 3 | awk '{print $2}' | awk 'BEGIN {print "Три наиболее популярных города среди пользователей системы"} "{print $3}"'