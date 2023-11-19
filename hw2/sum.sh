#!/bin/env bash 

# homework #2
# sum.sh on awk (by dshevchenko, 2023)

# 1. checking the availability of AWK
AWKPATH=$(which awk)
if [ -z "$AWKPATH" ]; then
    echo "ERROR: AWK in not installed."
    echo "To install AWK, use the command: sudo apt-get install gawk"
    exit 1
fi

# 2. checking the number of arguments
if [ "$#" -ne 2 ]
then
    echo "ERROR: Two numbers are expected."
    exit 2
fi

# 3. checking each argument for number compliance
CHECK_REGEX="^[+-]?[0-9]+([.][0-9]+)?$"
for i in "$@"
do
    if ! [[ $i =~ $CHECK_REGEX ]]
    then
        echo "ERROR: $i is not a number."
        exit 3
    fi
done

# 4. calc sum with AWK
RESULT=$(echo "$1 $2" | awk '{print $1 + $2}')

# 5. output result
echo "$RESULT"




