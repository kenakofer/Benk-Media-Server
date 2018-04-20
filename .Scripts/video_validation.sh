#!/bin/bash

echo '' > video_validation.log
for video in $(find .. -name "*.mp4" -type f); do
    echo "------------------$video ERRORS---------------------" >> video_validation.log
    $(ffmpeg -v error -i $video -map 0:1 -f null - >error.log 2>&1)
    $(cat error.log >> video_validation.log)
done
