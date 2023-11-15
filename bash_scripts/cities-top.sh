#!/bin/bash

cat ./cities.txt | tail -n +2 | sort -nrk4 | head -n 3 | awk '{print $3,$4}'
