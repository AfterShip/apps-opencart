# apps-opencart
- [apps-opencart](#apps-opencart)
    - [Introduction](#introduction)
    - [Features](#features)
    - [Supported themes](#supported-themes)
    - [Getting Started](#getting-started)
        - [Before new install](#before-new-install)
        - [Install](#new-install)
    - [FAQ and troubleshooting](#faq-and-troubleshooting)
    - [License](#license)

## Introduction
This extension allows you to add tracking numbers to your order. You can add unlimited tracking numbers per order.

With a Premium AfterShip account your customers can get email/SMS notifications with detailed tracking information.

To start you need a free account at http://www.aftership.com to manage the trackings, and allow the your customers to access tracking information using a link with the name of your store.


## Features
1. Each order can have more than one tracking number.
2. Tracking information in Admin page.
3. Tracking information in Customer's Order History page
4. Tracking information in Customer's Order information page
5. Support over 544 couriers.

## Supported themes

The following themes are supported for tracking shipments on the Customer's Order History page:

- Default
- MarketShop
- Pav floral

 *If you are a theme designer, collaborate with this repo in order to support your theme*


## Getting Started

### Before new install
* This extension DOES NOT overwrite any file.
* We highly recommend to make a backup before installing anything.

### New install
1. Download the new extension from [here](download/aftership.ocmod.zip).
2. Ensure the downloaded extension filename is ending with ```.ocmod.zip```.
3. Login to your OpenCart store as an admin user.
4. Go to ```Extensions``` > ```Extension Installer```.
5. Click Upload > select the ```.ocmod.zip``` extension you had downloaded earlier > Click Continue.
6. Go to ```Extensions > Modifications```. Click on the Refresh button. 
7. Go to ```ashboard > Settings > Theme```. Click on the Refresh button. 
8. Go to ```Extensions > Extensions ```. Choose Modules, Click on the AfterShip Track Shipment v2.2 install and click Edit
9. Once you are inside, enable the App, insert your Aftership API key and your username. If you don't have Aftership account, API or Username. Follow the next steps:
   * Create new Aftership account [here](https://accounts.aftership.com/register).
   * Create new Aftership API [here](https://www.aftership.com/apps), install API, and generate one API Key.
   * Create new Aftership Username [here](https://accounts.aftership.com/brand-settings).
10. Click on the Refresh button.
11. Verify that module is Enabled and the Courier List from AfterShip has been updated in OpenCart. 


## FAQ and troubleshooting
* What is the "AfterShip API Key"?

>AfterShip is an online service which help you to TRACK and NOTIFY your customer after the package is shipped.<br>
It is very useful as you can monitor ALL the shipments in one place.<br>
The API KEY is used to interact to your Aftership account using the API, so lets say you want to send to Aftership one tracking number, the Key will make us know which account made the request, so que can add it to your account.<br>
Create new Aftership API [here](https://www.aftership.com/apps), install API, and generate one API Key.

* What is the "AfterShip Username"

>The Aftership Username allows your customer to access to the tracking information of your account. So if you have the tracking number `1234567890`, you can provide a link like this to the customer and he will be able to access the tracking information: [https://yourusername.aftership.com/1234567890](https://yourusername.aftership.com/1234567890).<br>
Create new Aftership Username [here](https://accounts.aftership.com/brand-settings).

* Which couriers do you support?

>Until 2019-05-29, we supported over 544 couriers, detail please check at:[http://www.aftership.com](http://www.aftership.com)

## License
Copyright (c) 2019 Aftership  
Licensed under the MIT license.
