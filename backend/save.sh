#!/bin/bash

d=$1

if [ -z "$d" ]; then
    d=.
fi

request=$(tempfile)

while true; do
    echo "listening for $request to save in $d" 
    echo -e "HTTP/1.1 200 OK\r\n\r\n" | nc -l 3482 >$request
    name=$(basename $(head -1 $request | cut -d" " -f2 | sed -e "s/\.py$//"))
    echo "saving $d/$name.py"
    awk 'BEGIN {a=0} /:/ {if (p==1) print} !/:/ {if (a==1) {p=1} if (a>1) {print} a=a+1}' <$request >$d/$name.py
    rm $request
done

