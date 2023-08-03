#!/bin/bash

sed '1d' cities | awk '{print $3}' | sort | uniq -c | sort -rk1 | head -3 | awk '{print $2}'
