#!/usr/bin/env bash
red=$(tput setaf 1)
green=$(tput setaf 2)
bold=$(tput bold)
resetFormat=$(tput sgr0)

operationList="+-/^"
operation="+"

function showHelp() {
  echo "${bold}About Calc command:${resetFormat}"
  echo "By default operation is ${bold}${green}+ (addition)${resetFormat}"
  echo "You can use ${green}${bold}-o${resetFormat} option key with one of this value ${green}${bold}$operationList${resetFormat}"
  echo "Then pass after option -o two or more numbers for getting result of operation."
}

while getopts "o:h" option; do
  case "$option" in
    o)
      if [[ $operationList == *"$OPTARG"* ]]; then
        echo "${bold}Set operation to ${green}$OPTARG${resetFormat}"
        operation=$OPTARG
        shift 2
      else
        echo "${red}Operation $OPTARG not find! Use one of this list $operationList" && exit
      fi;;
    h)
      showHelp && exit;;
    ? | *)
      continue;;
  esac
done

case "$#" in
  1) echo "${red}You're pass only one argument. Add 1 or more arguments." && exit;;
  0) echo "${red}Input is empty! Add 2 or more arguments." && exit;;
  *);; # 2 args or more is ok - continue
esac

function checkDependencies() {
  echo "Checking dependencies..."
  package="bc"

  if [ "$(which $package)" ]; then
    echo "${bold}$package${resetFormat} is installed."
  else
    echo "${red}Package $package is not installed. Please enter your root password for install it."
    sudo apt-get install -y $package
  fi
}

function validateInput() {
  isInt="^-\?[0-9]+$"
  isFloat="^[0-9]+([.][0-9]+)?$"
  isSignedFloat="^[+-]?[0-9]+([.][0-9]+)?$"

  if ! [[ $1 =~ $isInt || $1 =~ $isFloat || $1 =~ $isSignedFloat ]] ; then
    echo "${red}${bold}$1 is not a number" && exit
  fi
}

# Start of script
checkDependencies

result=0
argsCount=1

for currentArg in "$@"; do
  validateInput "$currentArg"
  echo "${resetFormat}$argsCount number is ${bold}$currentArg${resetFormat}"

  if [ $argsCount == 1 ]; then
    result=$currentArg
  else
    result=$(echo "scale=8; $result $operation $currentArg" | bc)
  fi

  ((argsCount++))
done

echo "${bold}Result of operation ${green}$operation${resetFormat} with numbers ${bold}is ${green}$result${resetFormat}"
