#!/bin/bash

awk '/^[0-9]+/{print $3}' users.txt | sort | uniq --count | sort --reverse | awk '{print $2}' | head -3
