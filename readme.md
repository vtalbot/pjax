## PJAX for Laravel 4

Enable the use of PJAX in Laravel 4.

#### Installation

Add `vtalbot/pjax` to `require` section in your `composer.json`

    composer require vtalbot/pjax

Add `'VTalbot\Pjax\PjaxServiceProvider',` to `providers` in your `app/config/app.php`

#### How to use

This service provider will check, before output the http response, for the `X-PJAX`'s 
header in the request. If found, it will crawl the response to return the requested 
element defined by `X-PJAX-Container`'s header.

Works great with [jquery.pjax.js](https://github.com/defunkt/jquery-pjax).

### Contribution

I'm open to any idea of features to add to it.