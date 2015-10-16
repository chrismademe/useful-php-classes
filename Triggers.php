<?php

namespace Triggers;

class Triggers {

    /**
     * Triggers array
     */
    protected $triggers = [];

    /**
     * Actions array
     */
    protected $actions  = [];

    /**
     * Construct
     * Defines core triggers
     */
    public function __construct() {
        $this->addTrigger([
            'before_theme_load',
            'after_theme_load',
            'before_theme_header',
            'after_theme_header',
            'before_theme_body',
            'after_theme_body',
            'before_theme_footer',
            'after_theme_footer'
        ]);
    }

    /**
     * Add Trigger
     */
    public function addTrigger( $trigger ) {
        if ( is_array($trigger) ) {
            foreach( $trigger as $tr ) {
                $this->addTrigger($tr);
            }
        } else {
            if ( !in_array($trigger, $this->triggers) ) {
                $this->triggers[] = $trigger;
            }
        }
    }

    /**
     * Do Trigger
     */
    public function doTrigger( $trigger ) {
        if ( in_array($trigger, $this->triggers) && array_key_exists($trigger, $this->actions) ) {
            foreach ( $this->actions[$trigger] as $action ) {
                $this->doAction($action);
            }
        }
    }

    /**
     * Get Triggers
     */
    public function getTriggers() {
        return $this->triggers;
    }

    /**
     * Add Action
     */
    public function addAction( $trigger, $action ) {
        if ( is_array($action) ) {
            foreach( $action as $act ) {
                $this->addAction($trigger, $act);
            }
        } else {
            if ( in_array($trigger, $this->triggers) ) {
                $this->actions[$trigger][] = $action;
            }
        }
    }

    /**
     * Do Action
     */
    public function doAction( $action ) {
        if ( function_exists($action) ) {
            $action();
        }
    }

    /**
     * Get Actions
     */
    public function getActions() {
        return $this->actions;
    }

}

/********************************
 ** Example                    **
 ********************************/

// Instantiate Triggers
$triggers = new Triggers\Triggers();

// Add an action
$triggers->addAction('after_theme_load', 'do_something');

// Do Something
function do_something() {
    echo 'Hello World!';
}

// Trigger all 'after_theme_load' actions
$triggers->doTrigger('after_theme_load');
