#!/bin/bash

var_email=$1

var_check01=$(echo $var_email | tr -cd '@' | wc -m)

echo "Количество символов @ = "$var_check01

var_postname=$(echo $var_email | cut -d '@' -f 1)
var_domain=$(echo $var_email | cut -d '@' -f 2)

echo "Имя адресата " $var_postname
echo "Доменное имя " $var_domain

var_check02=$(nslookup -type=any $var_domain | grep name)

if [[ $var_check01 = '1' ]] && [ -n "$var_postname" ] && [ -n "$var_domain" ] && [ -n "$var_check02" ]
        then
        echo "Простая проверка пройдена";
        echo $var_check02;
else
        echo "Проверка не пройдена. Введите корректный email";
fi
