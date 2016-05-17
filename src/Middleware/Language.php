<?php namespace App\Middleware;

class Language
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * Language middleware invokable class
     *
     * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
     * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
     * @param  callable                                 $next     Next middleware
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke($request, $response, $next)
    {
        $settings = $this->container['settings'];
        $defaultLang = $settings['default_region'];
        $expireDate = time() + (365 * 24 * 60 * 60);

        if (!empty($request->getHeader('Lang'))) {
            setcookie('lang', $request->getHeader('Lang')[0], $expireDate, '/');
        } else {
            if (empty($_SESSION['lang'])) {
                if (empty($_COOKIE['lang'])) {
                    setcookie('lang', $defaultLang, $expireDate, '/');
                    $_SESSION['lang'] = $defaultLang;
                } else {
                    $_SESSION['lang'] = $_COOKIE['lang'];
                }
            }
        }

        $response = $next($request, $response);
        return $response;
    }
}
