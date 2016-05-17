<?php namespace App\Exception;

use Slim\Handlers\NotFound;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class NotFoundHandler extends NotFound
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * Custom NotFound class
     *
     * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
     * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response)
    {
        parent::__invoke($request, $response);

        $settings = $this->container['settings'];

        $lang = (empty($_SESSION['lang'])) ? $settings['default_region'] : $_SESSION['lang'];

        $errorPage = $settings['actual_patch'].'/'.$lang.'/404.html';
        $this->container['renderer']->render($response, $errorPage);
        return $response->withStatus(404);
    }
}
