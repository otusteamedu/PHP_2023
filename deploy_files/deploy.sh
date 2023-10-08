#!/bin/bash

rm -f .git/index.lock
git checkout -f main
git fetch origin main
git reset --hard FETCH_HEAD

cd docker/code
composer i