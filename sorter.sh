#!/bin/bash

awk '{print $3}' cities.txt | sort | uniq -c | sort -k1rn | head -3
