#!/bin/bash

awk '{print $3}' table.txt | sort | uniq -c | sort -r | head -n 3 | awk '{print $2}'