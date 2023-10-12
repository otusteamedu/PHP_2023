#!/bin/bash

awk '{print $3}' cities.txt | sort -f | uniq -ci | sort -r | head -n 3
