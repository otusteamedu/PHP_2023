#!/bin/bash

tail -n +2 cities.txt | awk "{print \$3}" | sort | uniq -c | sort -rn | head -n 3

