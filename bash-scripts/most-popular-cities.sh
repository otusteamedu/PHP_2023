#!/bin/bash

awk 'FNR > 1 {print $3}' user.txt | sort | uniq -c | sort -r | head -3 | awk '{print $2}'