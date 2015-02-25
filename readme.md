## PJAX for Laravel 5

Enable the use of PJAX in Laravel 5.

#### Installation

Add `jacobbennett/pjax` to `require` section in your `composer.json`

	"jacobbennett/pjax": "0.*"

Add `'JacobBennett\Pjax\PjaxMiddleware',` to `$middleware` in `app/Http/Kernel.php`

#### How to use

This middleware will check, before outputting the http response, for the `X-PJAX`'s 
header in the request. If found, it will crawl the response to return the requested 
element defined by `X-PJAX-Container`'s header.

Works great with [jquery.pjax.js](https://github.com/defunkt/jquery-pjax).
