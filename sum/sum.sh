#!/bin/bash
number1=$1
number2=$2

echo "$number1 $number2" | awk '{print $1+$2}'