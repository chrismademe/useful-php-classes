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
    private $route;

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
        $this->route = '/'. (isset($_GET['path']) ? rtrim($_GET['path'], '/') : 'index');
        $this->setindex();

        // Core routes
        $this->addRoute([
            $this->not_found,
            '/index'
        ]);
    }

    /**
     * Add Route
     */
    public function addRoute( $route ) {
        if ( is_array($route) ) {
            foreach ( $route as $r ) {
                $this->addRoute($r);
            }
        } else {
            if ( !array_key_exists($route, $this->routes) ) {
                $this->routes[$route] = [];
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
            $this->route = $route;
        } else {
            $this->route = $this->not_found;
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
        return $route === $this->route;
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

        $this->index = explode('/', $route);

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
$route->addRoute('/about/services');

// Set route for this example
$route->doRoute('/about/services');

// Get route
$route->getRoute(); // /about/services

// Get index
$route->getIndex(); // array('about', 'services');

// Echo first index key
echo $route->getIndex(1); // about

// Check if route matches
if ( $route->hasRoute('/about/services') ) {
    echo 'Route exists';
}
