#!/bin/bash

awk '{print $3}' cities | sort | uniq -c | sort -rn | head -n 3
