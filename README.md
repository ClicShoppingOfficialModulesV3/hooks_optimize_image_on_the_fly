# hooks_optimize_image_on_the_fly

This hook allows you to optimize your jpg and png image on the fly without lost on your quality image.

It works on product files when you insert a new image or when you insert a gallery image
 
TiniFy uses smart lossy compression techniques to reduce the file size of your PNG files. By selectively decreasing the number of colours in the image, fewer bytes are required to store the data. The effect is nearly invisible but it makes a very large difference in file size!

TiniFy is free for the first 500 images per month


Important Note :
licence  : GPL 2 - MIT

- You must have an account to Tinify.
- To use this apps, you must install composer on your local server or your server (apt-get install composer for linux).
- The exec function must be authorised by your hoster else the auto installation will not work (for the libray but the apps will be installed).
- To install manually the library
Inside the shop directory (where there is composer.json file)

composer require tinify/tinify ==> installation
composer update tinify/tinify ==> update
composer remove tinify/tinify ==> remove

Once this installaton is made, you can set the apps.

Install :
Copy the files inside your directory

Copy the hooks_tinyfy_optimize_image_on_the_fly.json into ClicShopping/Work/Cache/Github

Go https://tinypng.com/ and create an account to finding your API

In Design / Design - Configuration / Image : Insert your API



See Marketplace for all informations

 All informations about the ClicShopping
 
 Download ClicShopping : https://github.com/ClicShopping/ClicShopping_V3/archive/master.zip

 Community : https://www.clicshopping.org

 Software : https://github.com/ClicShopping

 Official add on : https://github.com/ClicShoppingOfficialModulesV3

 Community add on : https://github.com/ClicShoppingV3Community

 trademark License info : https://www.clicshopping.org/forum/trademark/ 
 
![image](https://github.com/ClicShoppingV3Community/hooks_optimize_image_on_the_fly/blob/master/ModuleInfosJson/image.png)