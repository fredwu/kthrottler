<?php defined('SYSPATH') or die('No direct script access.');
/**
 * KThrottler
 * 
 * An action throttler ported from Action Throttler for Rails
 * 
 * @link    http://github.com/fredwu/kthrottler
 * @link    http://github.com/fredwu/action_throttler
 * @package KThrottler
 * @author  Fred Wu
 * @license http://www.opensource.org/licenses/mit-license.php
 */
class KThrottler_Actions {
	/**
	 * Actions taken from the configuration
	 *
	 * @var array
	 */
	public $actions;
	
	public function __construct()
	{
		$this->actions = Kohana::config('kthrottler');
	}
	
	/**
	 * Checks the database to see if an action can be run
	 *
	 * @param  string  $action the name of the action to be run
	 * @param  mixed   $ref    (optional) the reference object
	 * @return boolean
	 */
	public function can_be_run($action, $ref = '')
	{
		$times_run = DB::select()->from('kthrottler_logs')
		  ->where('scope', '=', $action)
		  ->and_where('reference', '=', $this->normalise_ref($ref))
		  ->and_where('created_at', '>=', $this->datetime_since($this->actions[$action]['duration']))
		  ->execute()
		  ->count();
		
		return $times_run < $this->actions[$action]['limit'] ? true : false;
	}
	
	/**
	 * @see self::can_be_run()
	 */
	public function cannot_be_run($action, $ref = '')
	{
		return ! $this->can_be_run($action, $ref);
	}
	
	/**
	 * Runs an action and registers it in the database
	 *
	 * @param  string  $action the name of the action to be run
	 * @param  mixed   $ref    (optional) the reference object
	 * @return boolean
	 */
	public function run($action, $ref = '')
	{
		if ($this->can_be_run($action, $ref))
		{
			DB::insert('kthrottler_logs', array('scope', 'reference', 'created_at'))
			  ->values(array($action, $this->normalise_ref($ref), $this->datetime_since('now')))
			  ->execute();
			
			return true;
		}
		else
		{
			return false;
		}
	}
	
	/**
	 * @see self::run()
	 */
	public function can_run($action, $ref = '')
	{
		return $this->run($action, $ref);
	}
	
	/**
	 * @see self::run()
	 */
	public function cannot_run($action, $ref = '')
	{
		return ! $this->run($action, $ref);
	}
	
	/**
	 * Converts a duration string into a MySQL DateTime string
	 *
	 * @param  string $duration 
	 * @return string
	 */
	private function datetime_since($duration)
	{
		$prefix = $duration == 'now' ? '' : '-';
		
		return date('Y-m-d H:i:s', strtotime($prefix.$duration));
	}
	
	/**
	 * Normalises the ref parameter so it can accept more than one type
	 *
	 * @param  mixed  $ref the ref parameter
	 * @return string      ref id
	 */
	private function normalise_ref($ref)
	{
		return (is_int($ref) or is_string($ref)) ? (string)$ref : (string)$ref->id;
	}
}