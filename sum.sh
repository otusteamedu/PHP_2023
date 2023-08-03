#!/bin/bash

NUMBER_OF_ARGS=2
HAS_ERROR=0
SUM=0

if [ $# -ne ${NUMBER_OF_ARGS} ]; then
    echo "Error: ${NUMBER_OF_ARGS} arguments needed";
    exit 1
fi

for CURRENT_NUMBER in $@; do
  # если число вещественное
  if [[ $CURRENT_NUMBER =~ ^[+-]?[0-9]+([.][0-9]+)?$ ]]; then
    # количество цифр после точки для дробных чисел
    MAX_FRACTION_LENGTH=0
    SUM_FRACTION_LENGTH=0
    CURRENT_NUMBER_FRACTION_LENGTH=0

    for i in SUM CURRENT_NUMBER; do
      if [[ "${!i}" == *"."* ]]; then
        I_FRACTION=${!i#*.}
        I_FRACTION_LENGTH=${#I_FRACTION}

        if [ ${I_FRACTION_LENGTH} -gt ${MAX_FRACTION_LENGTH} ]; then
          MAX_FRACTION_LENGTH=${I_FRACTION_LENGTH}
        fi

        eval "${i}_FRACTION_LENGTH=${I_FRACTION_LENGTH}"
      fi
    done

    # если есть дробные числа, то домножаем все числа до целых, складываем, потом приводим сумму к дробному числу
    if [ ${MAX_FRACTION_LENGTH} -gt 0 ]; then
      TEMP_SUM=$((${SUM//\./} * 10**(MAX_FRACTION_LENGTH - SUM_FRACTION_LENGTH) + ${CURRENT_NUMBER//\./} * 10**(MAX_FRACTION_LENGTH - CURRENT_NUMBER_FRACTION_LENGTH)))
      TEMP_SUM=$(sed -r "s/(.{$MAX_FRACTION_LENGTH})$/.\1/" <<< ${TEMP_SUM})
    else
      TEMP_SUM=$((${SUM} + ${CURRENT_NUMBER}))
    fi

    SUM=${TEMP_SUM}
  else
    HAS_ERROR=1
    echo "Error: ${CURRENT_NUMBER} is not a number"
  fi
done

if [ "$HAS_ERROR" -ne 1 ]; then
  echo "Result: ${SUM}"
else
  exit 1
fi
