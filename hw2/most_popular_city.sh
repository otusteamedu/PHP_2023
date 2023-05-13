#!/bin/bash

FILE=$1
REGEX_NUMBER='^([0-9]+)$'

if [ -z "$FILE" ]; then
  echo "Please provide /path/to/file/name."
  exit 1
fi

if [ ! -f "$FILE" ]; then
    echo "File not found."
    exit 1
fi

declare -A POPULAR_CITIES
while read LINE; do
  PARSE=' ' read -r -a DATA <<< "$LINE"

  if [[ ${DATA[0]} =~ $REGEX_NUMBER ]]; then
    if [ ${POPULAR_CITIES[${DATA[2]}]+_} ]; then
      (( POPULAR_CITIES[${DATA[2]}]++ ))
    else
      POPULAR_CITIES[${DATA[2]}]=1
    fi
  fi
done < "$FILE"

if [[ ${#POPULAR_CITIES[@]} == 0 ]]; then
  echo "No acceptable data in the file."
  exit 1
fi

POPULAR_CITIES_SORTED=$(
for KEY in "${!POPULAR_CITIES[@]}"; do
  echo "${POPULAR_CITIES[$KEY]}:::$KEY"
done | sort -rn | awk -F::: '{print $2}'
)

RESULT=''
I=0
for KEY in $POPULAR_CITIES_SORTED; do
  (( ++I ))
  if [ $I -le 3 ]; then
    if [ -z "$RESULT" ]; then
      RESULT="${KEY}"
    else
      RESULT="${RESULT}, ${KEY}"
    fi
  fi
done

echo "The three most popular cities are: $RESULT"
exit 0
