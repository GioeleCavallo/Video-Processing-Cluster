#!/bin/bash

cd /var/www/html/upload

current_date=$(date --date="-1 hours" +'%s')

for i in $(ls)
do
        creation=$(stat -c %x $i | cut -c1-19)
        creation_date=$(date -d "$creation" "+%s")
        if [ "$current_date" -ge "$creation_date" ];
        then
                rm -r $i
                echo "removed ${i}"
        fi
done
