if [ $# -ne 1 ]; then
    echo "Укажите имя файла с данными"
    exit 1
fi

if [ ! -f "$1" ]; then
    echo "Файл не найден"
    exit 1
fi

awk '{print $3}' "$1" | sort | uniq -c | sort -nr | head -n 3
