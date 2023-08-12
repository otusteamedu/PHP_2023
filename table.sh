#!/bin/bash


# shellcheck disable=SC2002
cat table.txt | awk '{print $3}' | sort | uniq -c | sort -nr | head -3