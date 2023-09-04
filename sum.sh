#!/bin/bash
die() {
  echo $@ 1>&2
  exit 1
}

if ! command -v bc &> /dev/null
then
   sudo apt-get install bc 1>/dev/null || die "Error using calc.sh - required package bc could not be installed. For reason see error above."
fi

if [[ $# -ne 2 ]]
then
  die "Usage ./calc.sh first_number second_number"
fi

regexp='^[-]?[0-9]+([.]{1}[0-9]+)?$'

if ! [[ $1 =~ $regexp && $2 =~ $regexp ]]; then
  die "Number format for arguments should be (-)n(.n)"
fi

echo "$1+$2" | bc