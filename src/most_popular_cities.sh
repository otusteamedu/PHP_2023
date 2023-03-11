#!/usr/bin/env bash
green=$(tput setaf 2)
bold=$(tput bold)
resetFormat=$(tput sgr0)

echo "${bold}This script help you to find three most popular cities in text table.${resetFormat}"

read -e -p "Enter ${bold}${green}path to your text table file${resetFormat}, please: " path

mostPopularCities=$(awk 'NR>1 { print $3 }' "$path" | sort | uniq -c | sort -nr | head -3)

echo "${bold}${green}This 3 cities are the most popular in Your table:${resetFormat}"
echo "${bold}$mostPopularCities"
