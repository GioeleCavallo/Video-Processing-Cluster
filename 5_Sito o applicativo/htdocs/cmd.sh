#!/bin/bash

MOTION_VECTOR="$3motion.mp4"
ffprobe -v error -select_streams v:0 -show_frames $1 > $2
python3 programs/ffstats_converter.py $2
ffmpeg -flags2 +export_mvs -i $1 -vf codecview=mv=pf+bf+bb $MOTION_VECTOR

ffmpeg -hide_banner -loglevel panic -i $1 -vf "select='eq(pict_type\,I)',showinfo" "$3I_frames.mp4"
ffmpeg -hide_banner -loglevel panic -i $1 -vf "select='eq(pict_type\,B)',showinfo" "$3B_frames.mp4"
ffmpeg -hide_banner -loglevel panic -i $1 -vf "select='eq(pict_type\,P)',showinfo" "$3P_frames.mp4"
mkdir "$3zip"
ffmpeg -hide_banner -loglevel panic -i $1 "$3zip/frame_%d.jpg"
zip -q -r "$3zip.zip" "$3zip"

