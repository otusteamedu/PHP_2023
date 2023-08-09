#!/bin/bash
cat <table | awk '{print $3}' | sort | uniq -c | sort -rn | head -n 3
