<div align="center">

# GetSimple CMS Community Edition

![image](https://github.com/GetSimpleCMS-CE/GetSimpleCMS-CE/assets/6113504/621eea2d-7db2-4115-8d33-89c941e45103)

[![CMS - GetSimpleCMS CE](https://img.shields.io/badge/CMS-GetSimpleCMS_CE-blue)](https://getsimple-ce.ovh/)
![PHP - v7.4-8.x](https://img.shields.io/badge/PHP-v7.4--8.x-orange)
![DataBase](https://img.shields.io/badge/FlatFile-purple)
![GitHub Release](https://img.shields.io/github/v/release/GetSimpleCMS-CE/GetSimpleCMS-CE?color=yellow)
[![Documentation - Available](https://img.shields.io/badge/Documentation-Available-red)](https://github.com/GetSimpleCMS-CE/GetSimpleCMS-CE/wiki)
[![License](https://img.shields.io/badge/License-GPL--3.0-green)](#license)

</div>


<hr/>


## What is GetSimple CMS CE? :pushpin:
GetSimple is an XML based, stand-a-alone, fully independent and lite Content Management System. To go along with its best-in-class user interface, it is loaded with features that every website needs, but with nothing it doesn't. GetSimple is truly the simplest way to manage a small-business website.
Now supporting php7.4-8.x.

Official CE Website - https://getsimple-ce.ovh/
The official unofficial GS update repo. Helping to bridge the gap in PHP compatibility. 


## INSTALLATION: :pushpin:

- Extract zip file to your web host
- Visit your domain and navigate to /admin (or your gsadmin path set in gsconfig.php), you will be redirected to the upgrade and install scripts
- (If you are receiving a 500 error, you may need to adjust permissions in .htaccess)

:warning: NOTE: Your site will be automatically put in maintenance mode during installs or upgrades.


## Whats New? :pushpin: ##

- New - Replaced fancybox with SimpleLightbox
- Update - Massive Admin 5.x
- Update - Codemirror
- Update - Install/Upgrade Email
- Update - Support page
- Update - Support>ErrorLog
- Update - Backup>Website Archives
- Fix - Menu-Manager
- Fix - Email HTML Render
- Fix - Password Reset
- Fix - Components copy code
- Fix - jCrop
- Removed - Deprecated Uploadify
- Removed - Outdated Demo Templates & Plugins
- Removed - Dead Files
- Hotfixes - Remote command execution vulnerability #1352  (https://github.com/GetSimpleCMS/GetSimpleCMS/issues/1352)
- Hotfixes - Cross-Site Scripting Vulnerability #1360 (https://github.com/GetSimpleCMS/GetSimpleCMS/issues/1360)
- Other minor cleanup, fixes and improvements

### Recent Updates: ###

🚀 Massive Admin 5 included by default (responsive admin + user manager + much much more...).

🌐 11 default languages included (de, es, en, fr, it, ja, nl, pl, pt, ru, uk).

- New gsconfig option (set login page language)
- Massive Admin included by default (responsive admin + user manager + much much more...).
- New Admin themes option.
- ResponsiveCE default template (front-end starter theme).
- New ckEditor plugins (Codemirror, YouTube, FontAwesome, etc.).
- New Soport Page options (view errorlog & phpInfo).
- New gsconfig option (view page tree by Title or Menu order).
- New Copy Component code button.


### Previous Updates: ###

- Added support for php7.4-8.2
- Fix deprecated Text-encoding HTML-ENTITIES for php8.2.
- Hotfixes: form action reflection, add phar to blacklist, .htaccess
- Fix bug in Components if none exist.
- Fix non numeric error on gsdebug.
- Fix vulnerability #1335 (https://github.com/GetSimpleCMS/GetSimpleCMS/issues/1335)
- Fix error message (empty log file) #1312 (https://github.com/GetSimpleCMS/GetSimpleCMS/pull/1312)
- Fix missing php7 extension on file_ext_blacklist #1237 (https://github.com/GetSimpleCMS/GetSimpleCMS/issues/1237)
- Add .webp support for GetSimple CMS #1350 (https://github.com/GetSimpleCMS/GetSimpleCMS/pull/1350)
- Add thumbnail creation on upload.
- Update Google Fonts to local in Innovation theme (for German GDPR).
- Changed function name do to deprecated class constructor.
- Further 8.x compatibility from Topic with fixes ([Forum Thread](http://get-simple.info/forums/showthread.php?tid=16548))

## Features :pushpin:

### XML Based ###
We don't use mySQL to store our information, but instead depend the simplicity of XML. By utilizing XML, we are able stay away from introducing an extra layer of slowness and complexity associated with connecting to a mySQL database. Because GetSimple was built specifically for the small-site market, we feel this is the absolutely best option for data storage.

### Easy to Learn UI ###
The top priority when designing our user-interface was to make it the best in it's class. We had the luxury of trying and testing all the competing management systems before designing ours, so we took the best out of each one - then refined it.

### Simple Installation ###
The total time in setting up a website took a total of 5 minutes, from starting the FTP to finishing the setup procedure.

### Easy Theme Customization ###
We have how to documents that show you how to create a custom theme. Our goal was not to bloat our software with hundreds of little-used theme functions, but to offer more than enough to allow for a fully customized theme.

### Plugins & Expandability ###
Designed to be light and agile, the base install comes to you clutter free, without dozens of extras you dont need. But of course we do have an ever growing selection of extensions ready to use and easy to install. Everything that you or your client are looking for…

## History :pushpin:
GetSimple CMS was created in 2009 and primarily developed for the creation of smaller websites, it is also became suitable for medium to large websites thanks to the extendability of the platform via plug-ins and themes.
Though by 2020, development had slowed considerably as the original team were no longer able to dedicate their time and resources to the project.<br/>
Recognizing the lapse in development and support on the current official website, we've taken the initiative to breathe new life into the platform by providing the essential updates it deserves, ensuring the advancement of this vital project.<br/>
We're driven by a shared commitment to uphold the importance of GetSimple CMS project and community. Leveraging our firsthand experience with GetSimple CMS, we understand its value as a solution.

## Team :pushpin: ##
The following individuals generously donate their time to further developing this "Community Edition" version, please consider supporting their efforts:

### :computer: multi / multicolor :video_game: ###
Location: Poland <br/>
Hobbies: Gaming & Programing <br/>
[![Donate](https://img.shields.io/badge/Donate-PayPal-blue.svg)](https://www.paypal.com/donate/?hosted_button_id=TW6PXVCTM5A72)

### :computer: islander / risingisland :palm_tree: ###
Location: Spain <br/>
Hobbies: Hiking & Design <br/>
[![Donate](https://img.shields.io/badge/Donate-PayPal-blue.svg)](https://www.paypal.com/donate/?hosted_button_id=C3FTNQ78HH8BE)


## LICENSE: :pushpin:

This software package is licensed under the GNU GENERAL PUBLIC LICENSE v3. 
LICENSE.txt is located within this download's zip file.

It would be great if you would link back to https://getsimple-ce.ovh/ if you use it.


## REQUIREMENTS: :pushpin:

https://github.com/GetSimpleCMS-CE/GetSimpleCMS-CE/wiki/Server-Requirements

### Build Requirements ###

Minimum of php7.4 recommended.

### Module Requirements ###

SimpleXML

### Browser Requirements ###

Javascript Enabled

### Server ###
*Apache ( recommended for out of the box security using .htaccess )


## DISCLAIMER: :pushpin:

While GetSimple strives to be a secure and stable application, we simply cannot 
be held liable for any information loss, corruption or anything else that may 
happen to your site while it is using the our software. If you find a bug 
or security hole, please contact someone in the forums at 
https://github.com/GetSimpleCMS-CE/GetSimpleCMS-CE/discussions


## Credits :pushpin:

Founder / Creator: Chris Cagle [ https://chriscagle.me ]
Original Lead Developer: Shawn Alverson [ http://tablatronix.com/ ]


## Libraries :pushpin:

_company logos in the icons are copyright of their respective owners_

Alpine.js  
https://alpinejs.dev/

Ckeditor  
https://ckeditor.com/

marijnh/CodeMirror  
https://codemirror.net/

simplelightbox  
https://github.com/andreknieriem/simplelightbox

W3 Css & JS  
https://www.w3schools.com/w3css/default.asp

rgrove/lazyload  
https://github.com/rgrove/lazyload

enyo/dropzone  
https://github.com/enyo/dropzone

bigspotteddog/scrolltofixed  
https://github.com/bigspotteddog/ScrollToFixed

dropzonejs  
http://www.dropzonejs.com/
