#!/bin/env bash

tail -n +2 data.txt | awk '{print $3}' | sort | uniq -c | sort -r | head -n 3

