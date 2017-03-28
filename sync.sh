#!/bin/bash

BASEDIR=$(dirname "$0")
echo $BASEDIR
rsync -avze ssh  --exclude-from=$BASEDIR'/backtrack/.gitignore' --delete --progress $BASEDIR/backtrack/ backtrack@77.222.55.92:/var/www/backtrack/www
