<?php defined('SYSPATH') or die('No direct script access.');
/**
 * KThrottler
 * 
 * An action throttler ported from Action Throttler for Rails
 * 
 * @link    http://github.com/fredwu/kthrottler
 * @link    http://github.com/fredwu/action_throttler
 * @author  Fred Wu
 * @license http://www.opensource.org/licenses/mit-license.php
 */
return array
(
	'mail' => array
	(
		'duration' => '1 hour',
		'limit'    => 10,
	),
);