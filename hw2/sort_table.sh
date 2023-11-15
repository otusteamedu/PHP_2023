#!/bin/bash

echo "Top 3 popular cities"
cat table.txt | awk '{print $3}' | sed -e '1d' | sort | uniq -c | sort -rk9 | head -3
exit 0