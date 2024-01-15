#!/usr/bin/env bash

awk '{print $3}' table.txt | sort | uniq -c | sort -r -V| head -n 3

