# Benk-Media-Server
Media server webapp built on LAMP that stores, downloads, and allows the upload of audio and video.

To begin:

aria2 must be installed

www-data must have permssion to run aria2c and chown as sudo

scan.php must run in the background (php benk-media-server/.Scripts/scan.php &)

And make sure to chown -R www-data:www-data and chmod -R 755 the install location!



Goals:

Add a dashboard page for downloads, MAYBE report progress if I can figure out how to do that

Play videos with video.js                          

Support more download hosts
                           
Allow users to upload multiple files at a time

Allow users to delete multiple files at a time

Allow users to transfer files to a directory (drag and drop?)

Fix mobile styles

Possibly create a Desktop app to go with it? (Probs not)
