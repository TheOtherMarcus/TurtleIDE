#!/bin/bash

d=$1

if [ -z "$d" ]; then
    d=.
fi

touch $d/0.py
latest=$(ls $d | grep "^[0-9][0-9]*.py$" | sort -n | tail -1 | cut -d. -f1)
next=$(($latest + 1))

while true; do
    echo "listening for $d/$next.py" 
    echo -e "HTTP/1.1 200 OK\r\n\r\n$next.out" | nc -l 3481 | awk 'BEGIN {a=0} /:/ {if (p==1) print} !/:/ {if (a==1) {p=1} if (a>1) {print} a=a+1}' > $d/$next.py
    if [ $? -eq 0 ]; then
	echo "executing $d/$next.py" 
	python $d/$next.py &>$d/$next.out
	next=$(($next + 1))
    fi
done

