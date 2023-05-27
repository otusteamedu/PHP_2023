#!/bin/bash
if [ $# -eq 2 ]
then
	if [[ $1 =~ ^[+-]?[0-9]+([.][0-9]+)?$ ]] && [[ $2 =~ ^[+-]?[0-9]+([.][0-9]+)?$ ]]
	then
		RESULT=0
		for i in $@
		do
			RESULT=$(awk "BEGIN{x=$RESULT+$i; print x}")
		done
		echo "Result = $RESULT"
	else
		echo "Error: All arguments should be numbers"
	fi
else
	echo "Error: 2 arguments are needed"
fi