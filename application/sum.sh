#!/usr/bin/env bash
echo "Welcome. The script will count your values."

ERROR_EXIT_CODE=1

check_is_set () {
	local name=$1
	local value=$2

	if [[ -z $value ]]; then
		echo "$name '$value' is not set" >&2
		exit $ERROR_EXIT_CODE
	fi
}

check_is_valid_number () {
	local name=$1
	local value=$2

	if [[ ! ($value =~ ^-?[0-9]+(\.[0-9]+)?$) ]]; then
		echo "$name '$value' is not valid numeric value" >&2
		exit $ERROR_EXIT_CODE
	fi
}

validate_input () {
	local name=$1
	local value=$2

	check_is_set "$name" $value
	check_is_valid_number "$name" $value
}

output_successful_message () {
	local first_variable=$1
	local second_variable=$2
	local result=$3
	
	echo "THe sum of the '$first_variable' and the '$second_variable' is '$result'"	
}

first_variable=$1
second_variable=$2

validate_input "First variable" $first_variable
validate_input "Second variable" $second_variable

# according to this article
# https://stackoverflow.com/questions/592620/how-can-i-check-if-a-program-exists-from-a-bash-script
# by hash we can check if command exists in the bash

if hash bc 2>/dev/null; then
	result=$(echo "$first_variable + $second_variable" | bc)
	output_successful_message $first_variable $second_variable $result
	exit
fi

if hash expr 2>/dev/null; then
	# 'expr' works only for integer numbers, so we must check them before using it
	if [[ $first_variable =~ ^-?[0-9]+$ && $second_variable =~ ^[0-9]+$ ]]; then
		result=$(expr $first_variable + $second_variable)
		output_successful_message $first_variable $second_variable $result
		exit
	fi
fi

if hash awk 2>/dev/null; then
	result=$(awk "BEGIN { a = $first_variable; b = $second_variable; print (a + b) }")
       	output_successful_message $first_variable $second_variable $result
	exit
fi	

echo "Cannot find any math functions. Please install one of 'bc', 'awk' or 'expr' (if you use integer arguments) commands" >&2
exit $ERROR_EXIT_CODE
