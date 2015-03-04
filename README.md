# apps-opencart
- [apps-opencart](#apps-opencart)
    - [Introduction](#introduction)
    - [Features](#features)
    - [Supported themes](#supported-themes)
    - [Getting Started](#getting-started)
        - [Before installation](#before-installation)
        - [Installation](#installation)
    - [Demo](#demo)
        - [Backend End](#backend-end)
        - [Front End](#front-end)
    - [Release History](#release-history)
    - [License](#license)
    
##Introduction
This extension allow you to add tracking number in your order. You can add unlimited tracking numbers per order.

Customer will also get the email about the tracking info.

You need a free account in http://www.aftership.com to manage the trackings, and allow the user to access the tracking information using a link with the name of your store.


##Features
1. Each order can have more than one tracking number.
2. Tracking information in Admin page.
3. Tracking information in Customer's Order History page
4. Tracking information in Customer's Order information page
5. Support over 220 couriers.

##Supported themes

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

## Demo

### Backend End
[http://demo.dragonapp.com/admin](http://demo.dragonapp.com/admin)
>Login: demo 

>Password: demo

##### After login, visit `Extensions --> Modules --> DragonApp Track Shipment`
> If you just installed it, it should look like this:


![](https://cloud.githubusercontent.com/assets/6940389/6477031/b09ba6ac-c258-11e4-93c7-636abe33804d.png)

##### Input the API key and Username.

![](https://cloud.githubusercontent.com/assets/6940389/6477048/097d6e5e-c259-11e4-97db-958b86b62550.png)

If you input the correct credentials, you should notice how the Enabled carriers appear, this carriers are the ones you have actived in your Aftership account, you can modify them [here](https://www.aftership.com/settings/courier).

The username is very important, will tracking links to it, for example: [https://username.aftership.com/dhl/0123456789](https://username.aftership.com/dhl/123456789) will point to the tracking 123456789 from dhl in your account.

#####In `Sales --> Orders --> View --> Order History tab`

![](https://cloud.githubusercontent.com/assets/6940389/6477057/57a679ea-c259-11e4-8b20-a107be44a48b.png)

As you can see, you can add to the order tracking numbers and couriers (the couriers you have active in your account).

### Front End
[http://demo.dragonapp.com/admin](http://demo.dragonapp.com/admin)
>Login: demo@dragonapp.com 

>Password: demo

##### After login, visit `My Account --> Order History`
![](https://cloud.githubusercontent.com/assets/6940389/6477063/9f469cda-c259-11e4-92ae-e2f6090dc251.png)
The client has the shipping information, he only need to click in any of the tracking numbers.

##### Click in `view info` ![](https://cloud.githubusercontent.com/assets/6940389/6477271/689f45f8-c25c-11e4-9ccc-6e098efc3e79.png)
![](https://cloud.githubusercontent.com/assets/6940389/6477064/9f730de2-c259-11e4-9800-971ed600c19f.png)


## Release History
####2014-11-09 v1.5.0
* Add Username field
* Get the enable carriers from the user's account
* Change the track button for tracking link
* Show tracking information to the customer in order history and order details

####2014-11-09 v1.1.14
* Force to use TLS SSL connection
* Added more couriers, now support over 220 couriers!

####2014-07-07 v1.1.13
* Fix "tracking already exists"
* Added more couriers, now support 192 couriers!
####2014-03-18 v1.1.11
* Fix sq.db file, sorry for the stupid mistake

####2014-03-18 v1.1.10
* Fix the installation error, sorry for the problem caused!

####2014-03-18 v1.1.9
* Added more couriers and now support 150!

####2014-02-07 v1.1.8
* Added more couriers and now support 134!
* Added theme tcf

####2013-12-04 v1.1.7
* Added more couriers and now support 127!

####2013-12-04 v1.1.6
* Fix new installation SQL file bug. (only new user is needed to update. existing user is not affected)

####2013-11-01 v1.1.5
* Added courier up to over 120!
* Will send out the tracking information in backend if the tracking number is saved.
* Remove the install script now no more manual install step! All automatically.
* For upgrade, upload all files (except the vqmod theme file)
* Then simply go to backend --> modules --> uninstall, then install again.

####2013-07-24 v1.1.4
* Remove the g.tt link, as they no longer support.
* Fix the courier images, such as "mrw-spain"
* Change the courier slug name

####2013-07-22 v1.1.3
* Support AfterShip V3 API
* Support 88 couriers now!
* No custom JS file is needed (now only admin page is modified)
* No Aftership API is needed, you can still track within your site without leaving your site.

####2013-04-29 v1.1.2
* Bug fix for the CSS namespace

####2013-04-17 v1.1.1
* Add Support Optronics theme

####2013-04-17 v1.1.0
* Fixed DB_PREFIX bug
* Add new couriers, now support total 77 couriers!

####2013-03-08 v1.0.9
* Support 58 couriers!
* Add simple installation script

####2013-01-23 v1.0.8
* Support 52 couriers!
* Updated AfterShip API to version 2.
* Add a new page for Customer to Track Shipment without Login

####2012-11-11 v1.0.7
* Support 27 couriers
* Add dhl-global-mail, danmark-post, russian-post

####2012-09-08 v1.0.6
* Suport AfterShip https protocol

####2012-09-08 v1.0.4
* Allow Multi Store API Key use in AfterShip

####2012-09-04 v1.0.3
* Fixed aftership push email

####2012-09-03 v1.0.2
* Add push emails to AfterShip

####2012-09-02 v1.0.1
* Fix undefined variable "courier_id", "slug"

####2012-08-31 v1.0.0
* First Release

## License
Copyright (c) 2015 Aftership  
Licensed under the MIT license.
