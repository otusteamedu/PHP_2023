#!/bin/bash

 awk '{print $3}' table.txt | sort | uniq -c | sort -r -n  | head -3 | awk '{print $2}'