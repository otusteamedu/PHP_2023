#!/bin/bash

for file in $(ls *.php)
do
  php $file
done