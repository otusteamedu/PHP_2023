reg='^[-+]?[0-9]+(\.+[0-9]+)?$'

if [ -z "$1" ] || [ -z "$2" ]
then
    echo 'Должны передаваться два числа'
    exit 1
fi

for i in $1 $2;
    do :
        if !  [[ "$i" =~ $reg ]];
        then
            echo 'Можно вводить только числа. Введено: '$i
            exit 1
        fi
done

awk -v arg1=$1 -v arg2=$2 'BEGIN{print "Результат сложения:", arg1 + arg2}'

