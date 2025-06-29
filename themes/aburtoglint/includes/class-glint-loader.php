<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit;

/**
 * Glint Theme - Hook Loader Class
 *
 * Registers all actions and filters for the theme.
 */
class Glint_Loader {

    /**
     * Actions to register
     * @var array
     */
    protected array $actions = [];

    /**
     * Filters to register
     * @var array
     */
    protected array $filters = [];

    /**
     * Add a new action to the loader
     */
    public function add_action(string $hook, object $component, string $callback, int $priority = 10, int $accepted_args = 1): void {
        $this->actions[] = compact('hook', 'component', 'callback', 'priority', 'accepted_args');
    }

    /**
     * Add a new filter to the loader
     */
    public function add_filter(string $hook, object $component, string $callback, int $priority = 10, int $accepted_args = 1): void {
        $this->filters[] = compact('hook', 'component', 'callback', 'priority', 'accepted_args');
    }

    /**
     * Register all actions and filters with WordPress
     */
    public function run(): void {
        foreach ($this->actions as $hook) {
            add_action(
                $hook['hook'],
                [$hook['component'], $hook['callback']],
                $hook['priority'],
                $hook['accepted_args']
            );
        }

        foreach ($this->filters as $hook) {
            add_filter(
                $hook['hook'],
                [$hook['component'], $hook['callback']],
                $hook['priority'],
                $hook['accepted_args']
            );
        }
    }
}
