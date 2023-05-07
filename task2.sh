#!/bin/bash

tail -n +2 data_for_task2.txt | awk '{print $3}' | sort | uniq -c | sort -r | head -n 3 | awk '{print $2}'


