<?php

namespace Route;

error_reporting(E_ALL);
ini_set('display_errors', 'on');

class Route {

    /**
     * Routes
     * Array of available routes
     */
    private $routes     = [];

    /**
     * Route
     * Current route
     */
    private $route      = [];

    /**
     * Index
     * Array of segments in current route
     */
    private $index      = [];

    /**
     * Not Found
     * Route for 404 error page
     */
    private $not_found  = '/404';

    /**
     * Construct
     * Set default path & index
     */
    public function __construct() {
        $this->route = ['route' => '/'. (isset($_GET['path']) ? rtrim($_GET['path'], '/') : 'index')];
        $this->setindex();

        // Core routes
        $this->addRoutes([
            $this->not_found => [
                $this->not_found,
            ],
            '/index' => [
                '/index'
            ]
        ]);
    }

    /**
     * Add Route
     */
    public function addRoute( $route, $view = false, $controller = false ) {
        if ( !array_key_exists($route, $this->routes) ) {
            $this->routes[$route] = [
                'route' => $route,
                'view' => $view,
                'controller' => $controller
            ];
        }
    }

    /**
     * Add Routes
     * Add an array of routes
     */
    public function addRoutes( $routes ) {
        if ( !is_array($routes) ) {
            return false;
        } else {
            foreach ( $routes as $route ) {
                $route[1] = (isset($route[1]) ? $route[1] : false);
                $route[2] = (isset($route[2]) ? $route[2] : false);

                $this->addRoute($route[0], $route[1], $route[2]);
            }
        }
    }

    /**
     * Get Routes
     * Return array of available routes
     */
    public function getRoutes() {
        return $this->routes;
    }

    /**
     * Do Route
     * Override the browser URL
     */
    public function doRoute( $route ) {
        if ( is_string($route) && $this->hasRoute($route) ) {
            $this->route = $this->routes[$route];
        } else {
            $this->route = $this->routes[$this->not_found];
        }

        $this->setIndex();
    }

    /**
     * Get Route
     * Get current route
     */
    public function getRoute() {
        return $this->route;
    }

    /**
     * Is Route
     */
    public function isRoute( $route ) {
        return $route === $this->route['route'];
    }

    /**
     * Has Route
     */
    public function hasRoute( $route ) {
        return array_key_exists($route, $this->routes);
    }

    /**
     * Set Index
     */
    public function setIndex( $route = false ) {
        if ( $route === false ) {
            $route = $this->route;
        }

        $this->index = explode('/', $route['route']);

        unset($this->index[0]); // Remove empty key
    }

    /**
     * Get Index
     * Get current route index
     */
    public function getIndex( $key = false ) {
        if ( $key !== false ) {
            return $this->index[$key];
        } else {
            return $this->index;
        }
    }

    /**
     * Has Index
     */
    public function hasIndex( $key ) {
        return array_key_exists($key, $this->index);
    }

}

/********************************
 ** Examples                    *
 ********************************/

// Instantiate Route
$route = new Route;

// Add new route
$route->addRoute('/about/services', 'services-page');

// Set route for this example
$route->doRoute('/about/services');

// Get route
$route->getRoute(); // /about/services
print_r($route->getRoute());

// Get index
$route->getIndex(); // array('about', 'services');

// Echo first index key
echo $route->getIndex(1); // about

// Check if route matches
if ( $route->hasRoute('/about/services') ) {
    echo 'Route exists';
}
