#!/bin/bash
# This script uses ffmpeg to check if the just-downloaded file contains any errors and keeps a log of those that do

to_test=$1
existing=''

# Remove any entries for which the file no longer exists
for video in $(cat video_validation.log); do
    if [ -f $video ]; then
        existing="$existing$video\n"
    fi
done

# Check if the file contains a read error
$(ffmpeg -v error -i $to_test -map 0:1 -f null - >error.log 2>&1)
if grep -q "Read error" error.log; then
    existing="$existing$to_test"
fi

rm error.log
echo $existing > video_validation.log

# Uncomment to run on all files and dump to log

#for video in $(find .. -name "*.mp4" -type f); do
#    echo "------------------$video ERRORS---------------------" >> video_validation.log
#    $(ffmpeg -v error -i $video -map 0:1 -f null - >error.log 2>&1)
#    $(cat error.log >> video_validation.log)
#done
