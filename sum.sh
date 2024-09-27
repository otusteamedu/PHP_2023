#!/bin/bash

# VARS
VERSION=0.1
RE='^[-]?[0-9]+([.][0-9]+)?$'

# FUNCTIONS
print_help () {
  echo Usage: "$0 [OPTION] or"
  echo -e "\t$0 [NUMBER] ..."
  echo -e "\nExample: $0 -h"
  echo -e "\t$0 1 2 -4 1.23"
  echo -e "\nOptions:"
  echo -e "\t-h - show this help"
  echo -e "\t-v - show version"
  echo -e "\nNumber: integer or real number"
}

# MAIN
while [ -n "$1" ]
do
  case "$1" in
    -h) print_help
      exit 0
      ;;
    -v) echo Version: $VERSION
      exit 0
      ;;
    *) break;;
  esac
  shift
done

if [ -n "$1" ]
then
  # check number
  for var in "$@"
  do
    if ! [[ $var =~ $RE ]] ; then
      echo "Error: is not number $var"
      exit 2
    fi
  done

  SUM=$(echo "$*" | awk 'BEGIN {p=0;m=0} {for(i=1; i<=NF; i++) { if ($i > 0)p+=$i; else m-=$i; } } END { print p - m }')
  echo "$SUM"
  exit 0
else
  echo -e "No parameters found.\n"
  print_help
  exit 1
fi
