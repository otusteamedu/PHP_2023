#!/bin/bash

echo "Это калькулятор, например напишите '2 + 2' и нажмите enter"

while [[ true ]]
do
  read num1 sign num2
  if [[ $num1 == "exit" ]]
    then
        echo "bye"
        break
  elif [[ "$num1" =~ "^((\d*\.?\d*)([+-/*]))*(\d*\.?\d*)$" && "$num2" =~ "^((\d*\.?\d*)([+-/*]))*(\d*\.?\d*)$" ]]
    then
        echo "error"
        break
  else
    case $sign in
        "+") result=$(echo "scale=3; $num1+$num2" | bc);;
        *) echo "error" ; break ;;
    esac
    echo "Ответ:" "$result"
  fi
done