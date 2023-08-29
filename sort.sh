manual="USAGE:\nuse like \n./sum.sh x y\nExamples:\n./sum.sh 1 2 OR \n./sum.sh 1.1 -2"
regex='^[+-]?[0-9]+([.][0-9]+)?$'

if  ! [[ $1 =~ $regex ]] ; then
    echo -e "First number is incorrect\n\n"$manual;
    exit 1
elif ! [[ $2 =~ $regex ]] ; then
    echo -e "Second number incorrect\n\n"$manual;.
    exit 1
fi

echo $1 $2 | awk '{print $1+$2}'