# Benk-Media-Server
Media server webapp built on LAMP that stores, downloads, and allows the upload of audio and video.

To begin:

transmission-cli must be installed

www-data must have permssion to run transmission-cli as sudo

scan.php must run in the background (php benk-media-server/.Scripts/scan.php &)

And make sure to chown -R www-data:www-data and chmod -R 755 the install location!



Goals:

Play media on the server (It already does this, but I would like to make a better player, at least for music;
                           currently, it only uses the default audio/video player included in the browser. Furthermore,
                           a lot of browser players don't support stuff like .mkv, so maybe use video.js?)
                           
Download manager
                           
Allow users to upload multiple files at a time

Allow users to delete multiple files at a time

Allow users to transfer files to a directory

Possibly create a Desktop app to go with it? (Probs not)
