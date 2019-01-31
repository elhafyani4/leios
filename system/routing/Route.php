<?php

namespace system\routing;

/**
 * This class represent a route
 */
class Route{

	/**
	 * Controller Name
	 */
	public $controller;

	/**
	 * Action Name
	 */
	public $action;

	/**
	 * List of Arguments
	 */
	public $args = array();
}
