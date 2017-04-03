#!/bin/bash
#
# Copyright 2017 Marcus Andersson
#

# First argument is the path to the code repository
d=$1

# If argument is empty, use current directory
if [ -z "$d" ]; then
    d=.
fi

request=$(tempfile)

while true; do
    echo "listening for $request to save in $d"
    echo -e "HTTP/1.1 200 OK\r\n\r\n" | nc -l 3482 >$request
    if [ $? -eq 0 ]; then
	# Extract name from request and remove .py ending
	# Also remove illegal characters except numbers, letters, underscore and dash.
	name=$(basename $(head -1 $request | cut -d" " -f2 | sed -e "s/\.py$//" -e "s/[^0-9a-zA-Z_-]*//g"))
	echo "saving $d/$name.py"
	# Remove request header, leaving the payload
	awk 'BEGIN {a=0} /:/ {if (p==1) print} !/:/ {if (a==1) {p=1} if (a>1) {print} a=a+1}' <$request >$d/$name.py
	rm $request
    fi
done
