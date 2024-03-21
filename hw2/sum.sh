
#!/bin/bash
read -p "Введите первое число: " number1
if [[ $number1 == ^[0-9]*[.]?[0-9]+$ ]]; then
echo "Вы ввели не число!"
fi

read -p "Введите второе число: " number2
if [[ $number2 == ^[0-9]*[.]?[0-9]+$ ]]; then
echo "Вы ввели не число!"
fi
echo $number1 $number2 | awk '{ print $1+$2 }'