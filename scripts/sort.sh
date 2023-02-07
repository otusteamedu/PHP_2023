#!/bin/bash

SCRIPT_DIR=$( cd -- "$( dirname -- "${BASH_SOURCE[0]}" )" &> /dev/null && pwd )

awk '{print $3}' "$SCRIPT_DIR/table.txt" | sort | uniq -c | sort -rnk1 | head -n3 | awk '{print $2}'
