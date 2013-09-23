<?php

namespace SimonStamm\LaravelPjax;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\DomCrawler\Crawler;

class LaravelPjaxServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$app = $this->app;

		$this->app->after(function($request, $response) use ($app)
		{
			// Only handle non-redirections
			if (!$response->isRedirection()) {
				// Must be a pjax-request
				if ($request->server->get('HTTP_X_PJAX')) {
					$crawler = new Crawler($response->getContent());

					// Filter to title (in order to update the browser title bar)
					$response_title = $crawler->filter('head > title');

					// Filter to given container
					$response_container = $crawler->filter($request->server->get('HTTP_X_PJAX_CONTAINER'));

					// Container must exist
					if ($response_container->count() != 0) {

						$title = '';
						// If a title-attribute exists
						if ($response_title->count() != 0) {
							$title = '<title>' . $response_title->html() . '</title>';
						}

						// Set new content for the response
						$response->setContent($title . $response_container->html());
					}

					// Updating address bar with the last URL in case there were redirects
					$response->header('X-PJAX-URL', $request->getRequestUri());
				}
			}
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}
