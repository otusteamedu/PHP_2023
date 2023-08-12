#!/bin/bash

tail -n +2 users.txt | awk '{print $3}' | sort | uniq -c | sort -nr | awk '{print $2}' | head -n 3