#!/bin/bash

awk -F ' ' '{print $3}' table.txt | sort | uniq -c | sort -nr | head -n 3 | awk -F ' ' '{print $2}'
