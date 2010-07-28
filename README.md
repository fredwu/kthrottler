# KThrottler

There is also a Ruby version (for [Rails](http://rubyonrails.org/)), see here: <http://github.com/fredwu/action_throttler>

## Introduction

KThrottler is an easy to use Kohana module to quickly throttle application actions based on configurable duration and limit. 

Brought to you by [Wuit](http://wuit.com).

## Features

* Easy to use, easy to configure
* Lightweight
* Supports Kohana v3

## Prerequisites

* Kohana's built-in DB module

## Usage

### Download and install the module

	git clone git://github.com/fredwu/kthrottler.git

### Enable the module

In your bootstrap file (`application/bootstrap.php`), enable KThrottler like this:

	Kohana::modules(array(
		'database'    => MODPATH.'database',
	    'kthrottler'  => MODPATH.'kthrottler',
	));

### Set up the database table

Import the `kthrottler_logs_db.sql` file supplied.

### Configure the actions

The configuration file is located at `config/kthrottler.php`. Please copy it to your `application/config` folder.

The configuration array looks like this:

	return array
	(
		'mail' => array
		(
			'duration' => '1 hour',
			'limit'    => 10,
		),
	);

You can add as many configuration elements as you like, just make sure you label them properly (i.e. like `mail` in the example).

In the example, we are setting the `mail` action to perform at most 10 times within 1 hour duration.

### Register the actions in your app

Now we will need to register the actions so they are recorded in the database.

To simply run an action, in your app (presumably somewhere in the controller), do this:

	KThrottler::actions()->run('mail');

`KThrottler::actions()->run()` will return true or false depending on whether or not the action is being throttled.

`KThrottler::actions()->run()` has an alias `KThrottler::actions()->can_run()` and a negative alias `KThrottler::actions()->cannot_run()`.

Typically, we would want to produce feedback to the user when an action is throttled, you can do so by:

	if (`KThrottler::actions()->cannot_run('mail')`)
		// tell the user that this action is not performed
	end

`KThrottler::actions()->run()` also takes an optional reference parameter:

`KThrottler::actions()->run('mail', $current_user)`

The reference parameter is very useful because we can track and throttle the action based on a reference, such as a user. The parameter accepts a String, an Integer or an ORM object.

Note that `KThrottler::actions()->run()` and its aliases will perform the action when possible. If you only want to check to see if an action can be performed, you can do this:

	`KThrottler::actions()->can_be_run('mail', $current_user)`

`KThrottler::actions()->can_be_run()` returns true or false without performing the action, and it also has a negative alias, `KThrottler::actions()->cannot_be_run()`.

## Author

Copyright (c) 2010 Fred Wu (<http://fredwu.me>) and [Wuit](http://wuit.com), released under the MIT license
