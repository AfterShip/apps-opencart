# apps-opencart
**Table of Contents**  *generated with [DocToc](http://doctoc.herokuapp.com/)*


###Introduction
This extension allow you to add tracking number in your order. You can add unlimited tracking numbers per order.

Customer will also get the email about the tracking info.

You need a free account in http://www.aftership.com to manage the trackings, and allow the user to access the tracking information using a link with the name of your store.


###Features
1. Each order can have more than one tracking number.
2. Tracking information in Admin page.
3. Tracking information in Customer's Order History page
4. Tracking information in Customer's Order information page
5. Support over 220 couriers.

###Supported themes

In order to support the track shipment at customer order history page,  the following theme are supported:

- Default
- Merkent
- MarketShop
- Optronics
- Pav floral

 *If you are a theme designer, colaborate with this repo in order to support your theme*


## Getting Started

###Before installation
* This extension DO NOT overwrite any file.
* We highly reconmed to make a backup before installing anything.

###Installation
1. If you don't have it installed, install the Vqmod version for Opencart:
> You can download the Opencart version from [here](https://github.com/vqmod/vqmod/releases) and the instructions to install [here](https://github.com/vqmod/vqmod/wiki/Installing-vQmod-on-OpenCart). To check that the instaltion has been correct you can look up in the folder `app/vqmod/vqcache` , if there are files the installion has been successful.
2. Download the version from this repository that you need and upload it to the root of your opencart store.
3. From the themes supported `app/vqmod/xml/supported_themes`, choose the one you need and copy it to the Vqmod xml folder `app/vqmod/xml`, now you should have 3 files:
   * `vqmod_opencart.xml` --> Change the opencart includes to point to the vqcache library.
   * `DragonApp_track_shipment.xml` --> Copy and modify the elements we need to the vqcache.
   * `DragonApp_track_shipment_theme_Default.xml` --> The theme specific file, can be other file depending of the theme you have installed. Will change the user layout so he can access the tracking information. (Since there are differents layout for each theme, we need different themes).
4. Enter in your admin store and go to `Modules --> DragonApp Track Shipment` click Install, and then click `edit`.
5. Once you are inside, enable the App, insert your Aftership API key and your username. If you don't have Aftership account, API or Username. Follow the next steps:
   * Create new Aftership account [here](https://www.aftership.com/signup).
   * Create new Aftership API [here](https://www.aftership.com/apps), install API, and generate one API Key.
   * Create new Aftership Username [here](https://www.aftership.com/users/profile).

## Documentation
_(Coming soon)_
http://www.dragonapp.com/track.html

## Examples
_(Coming soon)_


## Release History
_(Nothing yet)_

## License
Copyright (c) 2015 Aftership  
Licensed under the MIT license.
