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
class KThrottler {
	/**
	 * @var KThrottler_Actions
	 */
	public static $instance;
	
	/**
	 * Creates a KThrottler_Actions singleton
	 *
	 * @return KThrottler_Actions
	 */
	public static function actions()
	{
		empty(KThrottler::$instance) and KThrottler::$instance = new KThrottler_Actions();
		return KThrottler::$instance;
	}
}