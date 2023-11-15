#!/bin/env bash
chmod +x table.sh
awk '{print $3}' table.txt | sort | uniq -c | sort -nr | head -3