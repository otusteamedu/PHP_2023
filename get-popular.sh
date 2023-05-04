#!/bin/bash
awk '{print $3}' table.txt | sort | uniq -c | sort -nr | head -3