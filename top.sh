#!/bin/bash

awk '{print $3}' file.txt | sort |uniq -c | sort -nr | head -3
