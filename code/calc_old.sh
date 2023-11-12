#!/bin/env bash
# apt-get install bc #установить если не установлен, тогда все проще

re='^-?([0-9]+)([,\.][0-9]+)?$'
if ! [[ $1 =~ $re ]] ; then
  echo "ARGUMENT 1 " $1 " is not a number"
  exit 0
else
  echo "ARGUMENT 1= " $1 " is a number"
fi

if ! [[ $2 =~ $re ]] ; then
  echo "ARGUMENT 2 " $2 " is not a number"
  exit 0
else
  echo "ARGUMENT 2= " $2 " is a number"
fi
# Calculate
#signs
  re_sign='^-'
  if [[ $1 =~ $re_sign ]] ; then
    sign1="min"
    else
      sign1="pl"
    fi

  if [[ $2 =~ $re_sign ]] ; then
    sign2="min"
    else
      sign2="pl"
    fi

#parts

    s="0"
    IFS='.' read -ra num1 <<< "$1"
    n1_1=${num1[0]}
    n1_2=${num1[1]}
    IFS='.' read -ra num2 <<< "$2"
    n2_1=${num2[0]}
    n2_2=${num2[1]}

    num1_1=$((${num1[0]}+${num2[0]}))

    if [ "${#n1_2}"-le"${#n2_2}" ];
    then
      len_str=${#n2_2}
      len_diff=$(($len_str-${#n1_2}))
      if [ $len_diff -gt 1 ];then
        for i in { 1.."$len_diff" }
          do
            n1_2="$n1_2$s"
          done
      fi
    else
      len_str=${#n1_2}
      len_diff=$(($len_str-${#n2_2}))
        for i in { 1.."$len_diff" }
          do
            n2_2="$n2_2$s"
          done
    fi

#decimals
echo $sign1, $sign2, $n1_2, $n2_2

  if [ "$sign1" -eq "pl" ]; then
    if [ "$sign2" -eq "pl" ]; then
      num=$(($n1_1+$n2_1))
      dec=$(($n1_2+$n2_2))
    else
      num=$(($n1_1-$n2_1))
      dec=$(($n1_2-$n2_2))
    fi
  else
    if [ "$sign2" -eq "pl" ]; then
      num=$((-$n1_1+$n2_1))
      dec=$((-$n1_2+$n2_2))
     else
      num=$((-$n1_1-$n2_1))
      dec=$((-$n1_2-$n2_2))
 sudo   fi
  fi
echo $n1_1, $n1_2, $n2_1, $n2_2
echo $num, $dec
















