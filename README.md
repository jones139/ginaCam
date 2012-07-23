ginaCam
=======

Simple webcam interface to display pictures captured from a camera.

The idea of this is to use a 
<a href="http://en.wikipedia.org/wiki/NSLU2">LinkSys NSLU2</a> 
running 
<a href="http://openwrt.org">OpenWRT</a> to act as a webcam.
It will use <a href="http://www.lavrsen.dk/foswiki/bin/view/Motion/">motion</a>
 to monitor images from usb connected webcams and save
images to disk if motion is detected.
The scripts in this archive are to provide a simple user interface to allow
the images to be viewed easily.
It also has a very simple 'upgrade' script that will allow the software to
be upgraded via the web.  NOTE - THIS IS NOT A GOOD EXAMPLE OF DOING THIS - LOADS OF SECURITY FLAWS - It is just a quick hack to get it working.

Future extensions include:
- Upload to remote server (which will be powerful enough to turn the images into movies - don't think the NSLU2 is up to it.
- Support for multiple cameras.
- Record sound.

Current version can be seen at http://maps.webhop.net/webcam.


Graham Jones.