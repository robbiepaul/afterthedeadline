
# After The Deadline API PHP Wrapper
[![Latest Stable Version](https://poser.pugx.org/robbiep/afterthedeadline/v/stable)](https://packagist.org/packages/robbiep/afterthedeadline) [![Total Downloads](https://poser.pugx.org/robbiep/afterthedeadline/downloads)](https://packagist.org/packages/robbiep/afterthedeadline) [![Latest Unstable Version](https://poser.pugx.org/robbiep/afterthedeadline/v/unstable)](https://packagist.org/packages/robbiep/afterthedeadline) [![License](https://poser.pugx.org/robbiep/afterthedeadline/license)](https://packagist.org/packages/robbiep/afterthedeadline) [![StyleCI](https://styleci.io/repos/49351188/shield)](https://styleci.io/repos/49351188)

This is a PHP wrapper for the [After the Deadline API](http://www.afterthedeadline.com/api.slp)
> After the Deadline is a language checker for the web with: Contextual Spell Checking, Advanced Style Checking and Intelligent Grammar Checking

 
## Installation
 
Install this package through [Composer](https://getcomposer.org/). 

Add this to your `composer.json` dependencies:

```js
"require": {
   "robbiep/afterthedeadline": "^0.0"
}
```

Run `composer install` to download the required files.

## Usage 

```php
require_once('vendor/autoload.php');

$atd = new \RobbieP\Afterthedeadline\Afterthedeadline(['key' => md5('<unique string>')]);

$atd->checkDocument("I started my schooling as the majority did in my area, at the local primarry school.");

# `getResults` will return an array of objects (Spelling, Grammar, Suggestion) or `false` if there were no results
$results = $atd->getResults();

# (Optionally) you can get formatted text back where the results have been wrapped with 
# <span class="atd-{type}" data-suggestions="{suggestions}">word</span>

echo $atd->getFormatted(); 
```
Results in:
```html
<div id="atd-content">I started my schooling as the 
<span class="atd-suggestion" data-info="" data-suggestions="['greatest','most']">majority</span> 
did in my area, at the local 
<span class="atd-spelling" data-suggestions="['primary','primacy','primarily','remarry']">primarry</span> 
school.</div>
```
(Experimental) I've written some basic JavaScript using jQuery and Bootstrap to provide a 
simple UI to correct/ignore the results
```php 
echo $m->getFormatted()->getStylesAndScript(); ?>
```
## Support for other languages
At the moment After the Deadline supports English by default but German `de`, French `fr`, Spanish `es`, Portugese `pt`

You can either set it in the constructor:
```php
$atd = new \RobbieP\Afterthedeadline\Afterthedeadline(['key' => md5('<unique string>'), 'lang' => 'de']);
# You must use 2 letter country code
```
Or you can set it inline:
```php
$atd = new \RobbieP\Afterthedeadline\Afterthedeadline(['key' => md5('<unique string>')]);
$atd->setLanguage(\RobbieP\Afterthedeadline\Language::GERMAN);
```

## If you're using it in Laravel...
I've included a ServiceProvider class and a config if you need to change any options. You need to add the ServiceProvider to `config/app.php`

```php
'providers' => array(
    ...
    RobbieP\Afterthedeadline\AfterthedeadlineServiceProvider::class
)
```
If you want to use the Facade:
```php
'aliases' => array(
    ...
    'Afterthedeadline' => RobbieP\Afterthedeadline\Facades\Afterthedeadline::class,
)
```

You will need to publish the config `php artisan vendor:publish` put your self generated API key in there.

### Usage (in Laravel)

```php
$results = \Afterthedeadline::checkDocument("some content")
                            ->getResults();
```

## Contributing
 
1. Fork it
2. Create your feature branch: `git checkout -b my-new-feature`
3. Commit your changes: `git commit -am 'Add some feature'`
4. Push to the branch: `git push origin my-new-feature`
5. Submit a pull request 
  
  
