<?php

namespace VTalbot\Pjax;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\DomCrawler\Crawler;

class PjaxServiceProvider extends ServiceProvider {

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

		$this->app->after(function(Request $request, Response $response) use ($app) {
			if ($request->server->get('HTTP_X_PJAX')) {
				$crawler = new Crawler($response->getContent());
				$response->setContent($crawler->filter($request->server->get('HTTP_X_PJAX_CONTAINER'))->html());
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