#!/usr/bin/env bash

awk 'NR>1 {print $3}' table | sort | uniq -c | sort  -Vr | head -n 3  | awk '{print $2}'