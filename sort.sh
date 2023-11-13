#!/bin/bash

echo $(cat cities.txt | awk '{print $3}' | sort | uniq -c | sort -n -r | awk '{print $2}' | head -n 3)
