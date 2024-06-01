GeoShortURL
=============
This [YOURLS](https://yourls.org) plugin enables the possibility to have different redirection URLs depending on the country of the visitor, by using YOURLS GeoIP plugin or by using the web server's built-in GeoIP module.

It is strongly recommended to use this plugin along with [302-instead](https://github.com/timcrockford/302-instead) plugin to avoid the 301 caching hell :)

Usage:
------

For any given short URL you need to 'Geoize' (e.g: http : //my-yourls-installation/**blah**): 
- use it to create a new short URL with the desired country code suffix (e.g. for France : **blah-fr**)
- assign it with your country-specific long URL


How to install this plugin
==========================
1. Create a new directory under the "user/plugins" directory
2. Save the "plugin.php" file into the directory you created in step 1
3. Activate the plugin using your YOURLS admin panel 

I spent 2 hours figuring out how to use it,
Let me leave a sample here.
=============================
Provide long URLs in different languages
https://www.abc.com/product/product-a This is the default page in English
https://www.abc.com/ru/product/product-a This is a Russian page
https://www.abc.com/fr/product/product-a This is a French page

Step 1
Install and activate this plugin on your sd.com (assuming you have it); 

Step 2 (create short links)
you need to add a short URL like
https://sd.com/a for https://www.abc.com/product/product-a
https://sd.com/a-ru for https://www.abc.com/ru/product/product-a
https://sd.com/a-fr for https://www.abc.com/fr/product/product-a

Step 3 (share)
After that, you just need to share "https://sd.com/a" with others,
It will automatically detect and match sd.com/a-"geocode" to redirect to the corresponding language page or just go to the English page.
