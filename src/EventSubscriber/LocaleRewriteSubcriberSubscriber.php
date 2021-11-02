<?php

namespace App\EventSubscriber;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\RouterInterface;

class LocaleRewriteSubcriberSubscriber implements EventSubscriberInterface
{

    /**
     * @var $routeCollection RouteCollection
     */
    private $routeCollection;

    /**
     * @var array|string[]
     */
    private $supportedLocales;

    /** @var string */
    private $localeRouteParam;

    public function __construct(
        RouterInterface $router,
        array           $supportedLocales = array('de', 'en'),
                        $localeRouteParam = '_locale'
    )
    {
        $this->routeCollection = $router->getRouteCollection();
        $this->supportedLocales = $supportedLocales;
        $this->localeRouteParam = $localeRouteParam;
    }

    public function onKernelRequest(RequestEvent $event)
    {

        $request = $event->getRequest();
        $path = $request->getPathInfo();

        $route_exists = false; //by default assume route does not exist.

        foreach ($this->routeCollection as $routeObject) {
            /** @var Route $routeObject */
            $routePath = $routeObject->getPath();

            if ($routePath == "/{" . $this->localeRouteParam . "}" . $path) {
                $route_exists = true;
                break;
            }
        }

        //If the route does indeed exist then lets redirect there.
        if ($route_exists == true) {

            //Get the locale from the user's browser.
            $locale = explode('_', $request->getPreferredLanguage())[0];

            //If no locale from browser or locale not in list of known locales supported then set to defaultLocale set in config.yml
            if ($locale == "" || !$this->isLocaleSupported($locale)) {
                $locale = $request->getDefaultLocale();
            }

            $event->setResponse(new RedirectResponse("/" . $locale . $path));
        }

    }

    public function isLocaleSupported($locale): bool
    {
        $supportedLocale = array_filter($this->supportedLocales, function ($supportedLocale) use ($locale) {
            return in_array($supportedLocale, explode('_', $locale));
        });

        return !empty($supportedLocale);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'kernel.request' => 'onKernelRequest',
        ];
    }
}