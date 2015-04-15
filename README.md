# apps-opencart
- [apps-opencart](#apps-opencart)
    - [Introduction](#introduction)
    - [Features](#features)
    - [Supported themes](#supported-themes)
    - [Getting Started](#getting-started)
        - [Before new install](#before-new-install)
        - [Install](#new-install)
        - [Upgrade](#upgrade-from-11x-12x-13x-14x-to-15x)
    - [Demo](#demo)
        - [Backend End](#backend-end)
        - [Front End](#front-end)
    - [FAQ and troubleshooting](#faq-and-troubleshooting)
    - [Release History](#release-history)
    - [License](#license)

##Introduction
This extension allows you to add tracking numbers to your order. You can add unlimited tracking numbers per order.

With a Premium AfterShip account your customers can get email/SMS notifications with detailed tracking information.

To start you need a free account at http://www.aftership.com to manage the trackings, and allow the your customers to access tracking information using a link with the name of your store.


##Features
1. Each order can have more than one tracking number.
2. Tracking information in Admin page.
3. Tracking information in Customer's Order History page
4. Tracking information in Customer's Order information page
5. Support over 230 couriers.

##Supported themes

The following themes are supported for tracking shipments on the Customer's Order History page:

- Default
- Merkent
- MarketShop
- Optronics
- Pav floral

 *If you are a theme designer, collaborate with this repo in order to support your theme*


## Getting Started

###Before new install
* This extension DOES NOT overwrite any file.
* We highly recommend to make a backup before installing anything.

###New install
1. If you don't have it installed, install the Vqmod version for Opencart:
> You can download the Opencart version from [here](https://github.com/vqmod/vqmod/releases) and the instructions to install [here](https://github.com/vqmod/vqmod/wiki/Installing-vQmod-on-OpenCart). To check that the installation was successful you can look in the folder `app/vqmod/vqcache` , if there are files the installion was successful.
2. Download the version that you need from this repository and upload it to the root of your opencart store.
3. From the themes supported `app/vqmod/xml/supported_themes`, choose the one you need and copy it to the Vqmod xml folder `app/vqmod/xml`, now you should have 3 files:
   * `vqmod_opencart.xml` --> Change the opencart includes to point to the vqcache library.
   * `DragonApp_track_shipment.xml` --> Copy and modify the elements we need to the vqcache.
   * `DragonApp_track_shipment_theme_Default.xml` --> The theme specific file, can be other file depending on the theme you have installed. This file changes the user layout so users can access the tracking information. (Since there are differents layout for each theme, we need different themes).
4. Login to your store as Admin and go to `Modules --> DragonApp Track Shipment` click Install, and then click `edit`.
5. Once you are inside, enable the App, insert your Aftership API key and your username. If you don't have Aftership account, API or Username. Follow the next steps:
   * Create new Aftership account [here](https://www.aftership.com/signup).
   * Create new Aftership API [here](https://www.aftership.com/apps), install API, and generate one API Key.
   * Create new Aftership Username [here](https://www.aftership.com/users/profile).

### Upgrade from 1.1.x, 1.2.X. 1.3.X, 1.4.X to 1.5.X

1. Go to `Modules` and click unninstall  `DragonApp Track Shipment`.
2. Download the version from this repository and upload it to the root of your opencart store.
3. From the themes supported `app/vqmod/xml/supported_themes`, choose the one you need and copy it to the Vqmod xml folder `app/vqmod/xml`, now you should have 3 files:
   * `vqmod_opencart.xml` --> Change the opencart includes to point to the vqcache library.
   * `DragonApp_track_shipment.xml` --> Copy and modify the elements we need to the vqcache.
   * `DragonApp_track_shipment_theme_Default.xml` --> The theme specific file, can be other file depending on the theme you have installed. This file changes the user layout so users can access the tracking information. (Since there are differents layout for each theme, we need different themes).
4. Delete all the files inside the library `app/vqmod/vqcache` (clear all the cache of vqmod);
5. Login to your store as Admin and go to `Modules --> DragonApp Track Shipment` click Install, and then click `edit`.
6. Once you are inside, enable the App, insert your Aftership API key and your username. If you don't have Aftership account, API or Username. Follow the next steps:
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

If you input the correct credentials, you should notice now the Enabled carriers appear, these carriers are the ones you have activated in your Aftership account, you can modify them [here](https://www.aftership.com/settings/courier).

The username is very important, tracking links will contain it, for example: [https://username.aftership.com/dhl/0123456789](https://username.aftership.com/dhl/123456789) will point to the tracking 123456789 from dhl in your account.

#####In `Sales --> Orders --> View --> Order History tab`

![](https://cloud.githubusercontent.com/assets/6940389/6477057/57a679ea-c259-11e4-8b20-a107be44a48b.png)

As you can see, you can add to the order tracking numbers and couriers (the couriers you have active in your account).

### Front End
[http://demo.dragonapp.com/admin](http://demo.dragonapp.com/admin)
>Login: demo@dragonapp.com

>Password: demo

##### After login, visit `My Account --> Order History`
![](https://cloud.githubusercontent.com/assets/6940389/6477063/9f469cda-c259-11e4-92ae-e2f6090dc251.png)
The client has the shipping information, he only needs to click on any of the tracking numbers.

##### Click in `view info` ![](https://cloud.githubusercontent.com/assets/6940389/6477271/689f45f8-c25c-11e4-9ccc-6e098efc3e79.png)
![](https://cloud.githubusercontent.com/assets/6940389/6477064/9f730de2-c259-11e4-9800-971ed600c19f.png)

##FAQ and troubleshooting
* What is the "AfterShip API Key"?

>AfterShip is an online service which help you to TRACK and NOTIFY your customer after the package is shipped.<br>
It is very useful as you can monitor ALL the shipments in one place.<br>
The API KEY is used to interact to your Aftership account using the API, so lets say you want to send to Aftership one tracking number, the Key will make us know which account made the request, so que can add it to your account.<br>
Create new Aftership API [here](https://www.aftership.com/apps), install API, and generate one API Key.

* What is the "AfterShip Username"

>The Aftership Username allows your customer to access to the tracking information of your account. So if you have the tracking number `1234567890`, you can provide a link like this to the customer and he will be able to access the tracking information: [https://yourusername.aftership.com/1234567890](https://yourusername.aftership.com/1234567890).<br>
Create new Aftership Username [here](https://www.aftership.com/users/profile).

* Which couriers do you support?

>Until 2015-03-01, we supported over 230 couriers, detail please check at:[http://www.aftership.com](http://www.aftership.com)

## Release History
####2015-04-15 v1.5.2
* Fix issue with multi-store connection
* Improve tracking-link
* Fix issue adding trackings without courier

####2014-11-09 v1.5.1
* Provide feedback when updating the APP

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
