#!/bin/bash

if [[ $1 =~ ^-?[0-9]+(\.[0-9]+)?$ ]]; then
  echo 'Параметр 1 соотвествует числу'
else
  echo 'Параметр 1 не является числом'
  exit
fi

if [[ $2 =~ ^-?[0-9]+(\.[0-9]+)?$ ]]; then
  echo 'Параметр 2 соотвествует числу'
else
  echo 'Параметр 2 не является числом'
  exit
fi

# Проверка установки пакета bc
if ! command -v bc &> /dev/null; then  # Проверка, что команда `bc` не найдена
    echo "Пакет bc не установлен. Устанавливаю..."

    # Проверка операционной системы и использование соответствующего менеджера пакетов
    if [[ -n $(command -v apt-get) ]]; then  # Проверка, что apt-get доступен (Ubuntu / Debian)
        sudo apt-get update
        sudo apt-get install -y bc
    elif [[ -n $(command -v yum) ]]; then  # Проверка, что yum доступен (CentOS / RHEL)
        sudo yum install -y bc
    elif [[ -n $(command -v dnf) ]]; then  # Проверка, что dnf доступен (Fedora)
        sudo dnf install -y bc
    else
        echo "Не удалось выполнить установку. Пожалуйста, установите пакет bc вручную."
        exit 1
    fi

    echo "Пакет bc успешно установлен."
else
    echo "Пакет bc уже установлен."
fi

echo

if [[ $# -eq 2 ]] && [[ $1 =~ ^[0-9]+(\.[0-9]+)?$ ]] && [[ $2 =~ ^[0-9]+(\.[0-9]+)?$ ]]; then
    #echo $1 + $2 = $(echo "$1 + $2" | bc)
    result=$(echo "$1 $2" | awk '{printf "%.2f\n", $1 + $2}')
    echo "$1 + $2 = $result"
else
    echo "Неверное количество параметров или параметры не являются числами"
fi
