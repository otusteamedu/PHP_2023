#!/usr/bin/env bash
echo "Welcome. Lets see what kind of cities is the most popular!"

ERROR_EXIT_CODE=1

validate_file () {
	local filename=$1

	if [[ -z $filename ]]; then
		echo "Filename does not set" >&2
		exit $ERROR_EXIT_CODE
	fi

	if [[ ! (-e $filename) ]]; then
		echo "File '$filename' does not exists" >&2
		exit $ERROR_EXIT_CODE
	fi

	# '-e' '-f' are both check existing file. But for different error messages, we use two checks 
	if [[ ! (-f $filename) ]]; then
		echo "File '$filename' is not simple file" >&2
		exit $ERROR_EXIT_CODE
	fi

	if [[ ! (-r $filename) ]]; then
		echo "File '$filename' cannot be read. Probably access is denied" >&2
		exit $ERROR_EXIT_CODE
	fi

	if [[ ! (-s $filename) ]]; then
		echo "File '$filename' is empty" >&2
		exit $ERROR_EXIT_CODE
	fi
}

filename=$1

validate_file $filename

result=$(awk '{city = $3; if (length(city) > 0 && city ~ /^([A-Za-z0-9-])+$/) print city; }' $filename | sort | uniq -c | sort -r | head -n 3)

echo -e "\nThe most popular cities are:"
echo "$result"
