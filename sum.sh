#!/bin/bash
DIG1=$1
DIG2=$2

if [[ -z $DIG1 ]]; then
  echo "no first digit"
  exit 1
fi
if [[ -z $DIG2 ]]; then
  echo "no second digit"
  exit 1
fi

if [[ ! $DIG1 =~ ^[0-9.-]+$ ]]; then
  echo "${DIG1} not number"
  exit 1
fi
if [[ ! $DIG2 =~ ^[0-9.-]+$ ]]; then
  echo "${DIG1} not number"
  exit 1
fi

SUM=$(echo "$DIG1 $DIG2" | awk "BEGIN{ print $1 + $2 }")

echo "Sum = $SUM"