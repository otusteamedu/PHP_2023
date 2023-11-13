#!/bin/env bash
cat table.txt | awk '{ print $3 }'| sort | uniq -c | sort | tail -n 3



