#!/usr/bin/env bash

awk '{print $3}' user_table.txt | sort | uniq -c | sort -rn | awk '{print $2}' | head -3
