<?php

/**
 * Youtube
 * Class for retreiving data from the Youtube API
 *
 * @TODO:   Write an extending class to allow
 *          sending data back to the API
 */

namespace Youtube;

class Youtube {

    /**
     * Config
     * Array containing config including
     * API keys and secrets
     */
    private $config     = [];

    /**
     * Endpoints
     * Array containing API endpoints
     */
    private $endpoints  = [];

    /**
     * Construct
     * Set default config
     */
    public function __construct( $config = false ) {
        if ( $config === false ) {
            $this->config = [
                'key'           => 'xxxxxxx',
                'secret'        => 'xxxxxxx',
                'user_token'    => false
            ];
        }

        $this->endpoints = [
            'videos'        => ['list', 'getRating'],
            'playlists'     => ['list'],
            'channels'      => ['list'],
            'activities'    => ['list']
        ];
    }

}
