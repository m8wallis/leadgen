<?php
	/**
	 * Created by PhpStorm.
	 * User: marksimonds
	 * Date: 1/25/16
	 * Time: 4:13 PM
	 */

	require_once('../config.php');

	try
	{
	    /* initialize whatcounts */
	    $whatcounts = new ZayconWhatCounts\WhatCounts( WC_REALM, WC_PASSWORD );

	    $subscriber = new ZayconWhatCounts\Subscriber;
	    $subscriber->setFirstName("Joe");
	    $subscriber->setLastName("Smith");

	    $subscribers = $whatcounts->findSubscribers($subscriber);
		if (class_exists('Kint')) {
			Kint::dump($subscribers);
		} else {
			var_dump($subscribers);
		}
	}
	catch ( ZayconWhatCounts\Exception $e )
	{
	    if (class_exists('Kint')) {
				Kint::dump($e);
			} else {
				var_dump($e);
			}
	}