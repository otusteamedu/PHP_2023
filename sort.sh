#!/bin/bash
awk '{print $3}' db.txt | sort | uniq -c | sort -rn | head -n 3