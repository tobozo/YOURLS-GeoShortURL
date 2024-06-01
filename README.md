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
------
1. Create a new directory under the "user/plugins" directory
2. Save the "plugin.php" file into the directory you created in step 1
3. Activate the plugin using your YOURLS admin panel 

Activate conditional redirection for a set of locales
------

Given the following long URLs:
 - `https://blah.something/product/product-a` This is the default page in English
 - `https://blah.something/ru/product/product-a` This is a Russian page
 - `https://blah.something/fr/product/product-a` This is a French page

1. Create links in the admin panel, you need to add short URLs like
  - `https://my-yourls-installation/a` for `https://blah.something/product/product-a`
  - `https://my-yourls-installation/a-ru` for `https://blah.something/ru/product/product-a`
  - `https://my-yourls-installation/a-fr` for `https://blah.something/fr/product/product-a`

2. Share
  After that, you just need to share `https://my-yourls-installation/a` with others,
  It will automatically detect and match `my-yourls-installation/a-[geocode]` to redirect to the corresponding locale page or just go to the default (English) page.

