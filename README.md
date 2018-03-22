# Benk-Media-Server
Media server webapp built on LAMP that stores, downloads, and allows the upload of audio and video.

To begin:

aria2 must be installed

www-data must have permssion to run aria2c as sudo

scan.php must run in the background (php benk-media-server/.Scripts/scan.php 2>&1 /dev/null &)

And make sure to chown -R www-data:www-data and chmod -R 755 the install location!



Goals:


Play videos with video.js   

Report progress of downloads on dashboard   

General UI improvements

Allow users to delete multiple files at a time

Allow users to transfer files to a directory (drag and drop?)

Allow users to upload multiple files at a time

Fix mobile styles

Possibly create a Desktop app to go with it? (Probs not)
