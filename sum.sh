#!/usr/bin/env bash

INPUT_LEFT=$1
INPUT_RIGHT=$2
if ! echo $INPUT_LEFT+$INPUT_RIGHT | bc 2> /dev/null
then
	IFS='.' read -a LEFT_VAR <<< $INPUT_LEFT
	IFS='.' read -a RIGHT_VAR <<< $INPUT_RIGHT

	FLOAT_DIFF=$((${#LEFT_VAR[1]}-${#RIGHT_VAR[1]}))
	RIGHT_RESULT=$((${LEFT_VAR[0]}+${RIGHT_VAR[0]}))
	if [ $FLOAT_DIFF -ne 0 ] 
	then
			while [ $FLOAT_DIFF -lt 0 ]; do
				FLOAT_DIFF=$(($FLOAT_DIFF+1))
				LEFT_VAR[1]=${LEFT_VAR[1]}0
			done;

			while [ $FLOAT_DIFF -gt 0 ]; do
				FLOAT_DIFF=$(($FLOAT_DIFF-1))
				RIGHT_VAR[1]=${RIGHT_VAR[1]}0
		done;
	fi

	LEFT_VAR[1]=1${LEFT_VAR[1]}
	RIGHT_VAR[1]=1${RIGHT_VAR[1]}
	NUMBER_COUNT=${#RIGHT_VAR[1]}
	if [ ${LEFT_VAR[0]} -lt 0 ] 
	then 
		LEFT_VAR[1]=-${LEFT_VAR[1]}
	fi

	if [ ${RIGHT_VAR[0]} -lt 0 ] 
	then 
		RIGHT_VAR[1]=-${RIGHT_VAR[1]}
	fi

	STEP_RESULT=$((LEFT_VAR[1]+RIGHT_VAR[1]))


	if [ $STEP_RESULT -lt 0 ] 
	then
		STEP_RESULT=$((0-$STEP_RESULT))
	fi

	FLOAT_DIFF=$((NUMBER_COUNT-${#STEP_RESULT}))

	while [ $FLOAT_DIFF -gt 0 ]; 
	do
		FLOAT_DIFF=$((FLOAT_DIFF-1))
		STEP_RESULT=0${STEP_RESULT}
	done;

	if [ ${STEP_RESULT:0:1} -lt 0 ]
	then
		RIGHT_RESULT=$((RIGHT_RESULT-1))
	fi

	if [ ${STEP_RESULT:0:1} -gt 2 ]
	then
		RIGHT_RESULT=$((RIGHT_RESULT+1))
	fi

	RIGHT_RESULT=$RIGHT_RESULT.${STEP_RESULT:1}

	while [ ${#RIGHT_RESULT} > 0 ]; do
		if [  ${RIGHT_RESULT:${#RIGHT_RESULT}-1} = '.' ]
		then
			RIGHT_RESULT=${RIGHT_RESULT:0:${#RIGHT_RESULT}-1}
			break
		elif [ ${RIGHT_RESULT:${#RIGHT_RESULT}-1} -eq 0 ]
		then
			RIGHT_RESULT=${RIGHT_RESULT:0:${#RIGHT_RESULT}-1}
		else
			break
		fi

	done;

	echo $RIGHT_RESULT
fi