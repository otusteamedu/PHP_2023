#!/bin/env bash
# apt-get install bc #установить если не установлен, тогда все проще

re='^-?([0-9]+)([\.][0-9]+)?$'
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

  #  arg1=$(echo $1 | sed 's/^0*//')
  #  arg2=$(echo $2 | sed 's/^0*//')
    arg1=$1
    arg2=$2

    IFS='.' read -ra num1 <<< "$arg1"
    n1_1=${num1[0]}
    n1_2=${num1[1]}
    IFS='.' read -ra num2 <<< "$arg2"
    n2_1=${num2[0]}
    n2_2=${num2[1]}

    num1_1=$((${num1[0]}+${num2[0]}))

    if [ "${#n1_2}"-le"${#n2_2}" ];
    then
      len_str=${#n2_2}
      len_diff=$(($len_str-${#n1_2}))
      echo "len_str len_diff" $len_str, $len_diff
      echo "arg1" $arg1

      if [ $len_diff -gt 0 ];then

         for ((i=1; i<= $len_diff; i++));
         do
            arg1="$arg1$s"
            echo $i
          done
          echo "arg1=" $arg1
      fi
    else
      len_str=${#n1_2}
      len_diff=$(($len_str-${#n2_2}))
        for i in { 1.."$len_diff" }
          do
            arg2="$arg2$s"
          done
    fi

int1=${arg1//,/}
int1=${arg1//./}
int2=${arg2//,/}
int2=${arg2//./}

echo $int1, $int2
re_sign='^-'
if [[ $int1 =~ $re_sign ]] ; then
  int1=$(echo $int1 | sed 's/^-*//')
  int1=$(echo $int1 | sed 's/^0*//')
  int1="-"$int1
  else
  int1=$(echo $int1 | sed 's/^0*//')
fi
if [[ $int2 =~ $re_sign ]] ; then
  int2=$(echo $int2 | sed 's/^-*//')
  int2=$(echo $int2 | sed 's/^0*//')
  int2="-"$int2
  else
  int2=$(echo $int2 | sed 's/^0*//')
fi
echo $int1, $int2
sum=$(( $int1 + $int2 ))
echo $sum
len_sum=${#sum}
len_sum1=$(( $len_sum - $len_str ))

sum1=$(echo $sum | cut -c1-$len_sum1 )
sum2=$(echo $sum | cut -c$(($len_sum1+1))-$(($len_sum+1)))

echo $sum, $sum1, $sum2

echo "Result=" $sum1.$sum2

#decimals


















