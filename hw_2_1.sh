#!/bin/bash

regex='^[+-]?([0-9]+\.?|[0-9]*\.[0-9]+)$'


# shellcheck disable=SC2162
read -p "Enter first number: " num1
# shellcheck disable=SC2053
if ! [[ $num1 =~ $regex ]]; then
  echo "It is not a number"
fi

# shellcheck disable=SC2162
read -p "Enter second number: " num2
# shellcheck disable=SC2053
if ! [[ $num2 != $regex ]]; then
  echo "It is not a number"
fi

# shellcheck disable=SC2034
# shellcheck disable=SC2004
#sum=$(echo "$num1 + $num2" | bc)

sum=$(echo $num1 $num2 | awk '{print $1 + $2}')

echo "$num1 + $num2" = $sum;