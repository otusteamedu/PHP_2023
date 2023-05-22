#!/bin/bash
RESULT=0
for i in $@
do
	RESULT=$(($RESULT+$i))
done
echo "Result = $RESULT"