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

					// Filter to given container
					$response_filtered = $crawler->filter($request->server->get('HTTP_X_PJAX_CONTAINER'));

					// Container must exist
					if ($response_filtered->count() != 0) {
						$response->setContent($response_filtered->html());
					}

					// Updating address bar with the last URL in case there were redirects
					$response->header('X-PJAX-URL', $request->getRequestUri());
				}
			}

			return $response;
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