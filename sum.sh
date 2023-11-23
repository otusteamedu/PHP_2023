reg='^[+-]?[0-9]+([.][0-9]+)?$'

while [[ ! $NUMBER_1 =~ $reg ]]
do
    read -p 'Первое число: ' NUMBER_1
done

while [[ ! $NUMBER_2 =~ $reg ]]
do
    read -p 'Второе число: ' NUMBER_2
done

echo "Сумма: $NUMBER_1 + $NUMBER_2 = `echo "$NUMBER_1 + $NUMBER_2" | bc`"