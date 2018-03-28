# Benk-Media-Server
Media server webapp built on LAMP that stores, downloads, and allows the upload of audio and video.

To begin:

aria2 and php-xml must be installed

scan.php must be given the correct full path to run Aria2 and run in the background (php benk-media-server/.Scripts/scan.php 2>&1 /dev/null &)

To allow upload of bigger files, edit php.ini

And make sure to chown -R www-data:www-data and chmod -R 755 the install location!



Goals:


Improve music player (album art, skip buttons?)

Fix mobile styles

Upload files in background

Allow users to delete multiple files at a time

Allow users to transfer files to a directory (drag and drop?)

Possibly create a Desktop app to go with it? (Probs not)
