#!/bin/bash

awk '{print $3}' table.txt | sort | uniq -c | head -3 | sort -r -n | awk '{print $2}'