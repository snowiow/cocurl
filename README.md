# COCUrl(Clash of Clans + cURL)
- [Intro](#intro)
- [Installation](#installation)
- [How to use?](#how to use?)

# Intro
COCUrl is a PHP framework with the goal to interact with the Clash of Clans Developer API more easily. It creates an object oriented layer above the raw cURL requests and offers Objects and Enums for the most common types returned by the CoC API. Sending requests is as easy as calling some functions on a object.

# Installation
Installation via composer is currently supported. Just add the following line to the require key in your ```composer.json``` file inside your project directory.
```json
"require": {
  "snowiow/cocurl": "dev-master"
}
```
Instead of dev-master you can also use any specified version you like. For more informations visit the [composer website](https://getcomposer.org/doc/01-basic-usage.md) 

# How to use?
Everything starts with the ```Client``` class. It needs an API key to be created. 
```php
$client = COCUrl\Client('my-api-key');
```
With the ```$client``` instance you are able to do all calls, that are available in the CoC API Beta. All calls are done as function calls. For example, if we want to retrieve all locations we do the following:  
```php
$client = COCUrl\Client('my-api-key');
$locations = $client->locations();
```
```$locations``` is an array with Location objects. All the data is available as public attributes. For example we can get the name of the first location we found by executing the following line:
```php
$locations[0]->name; 
```
If you want to do a specialised request under the same URL it is also possible over the same method. This is mostly implemented with the help of standard parameters. This behaviour is pulled through the whole COCUrl Framework. For example, if you know the id of the Location you want to retrieve. The call would look like this:  
```php
$location = $client->locations(32000094); //Returns a Location object of Germany
echo $location->name; //Would print Germany
```
For a complete reference of what's implemented at this state, please refer to the [ClientTest Class](https://github.com/snowiow/cocurl/blob/master/tests/ClientTest.php). 
