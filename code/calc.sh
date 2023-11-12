rem: Calc
NUM1=$1 | grep -E '^(-?)([0-9]+)([.,]?)([0-9]+)$'
NUM1=$2 | grep -E '^(-?)([0-9]+)([.,]?)([0-9]+)$'
if [ $1 = NUM1 ]
then
  echo NUM1
else
 echo "ARGUMENT 1 is not a number"
fi
if [ $2 = NUM2 ]
then
  echo NUM2
else
 echo "ARGUMENT 2 is not a number"
fi
rem: SUM=$(($1+$2))


