#!/usr/bin/env bash

awk 'NR>1 {print $3}' table.txt | sort | uniq -c | sort  -Vr | head -n 3  | awk '{print $2}'
