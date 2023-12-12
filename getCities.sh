#!/bin/bash

awk 'NR!=1{print $3}' userTable.txt | sort | uniq -c | sort -r | awk '{print $2}' | head -3
