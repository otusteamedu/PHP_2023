#!/bin/bash

awk '{print $3}' data.txt | sort | uniq -c | sort -nr | head -n 3