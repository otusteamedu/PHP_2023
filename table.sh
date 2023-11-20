#!/bin/env bash

awk '{print $3}' clients.txt | sort | uniq -c | sort -nr | head -n 3
