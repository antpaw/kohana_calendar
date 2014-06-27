<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Kohana event subject. Uses the SPL observer pattern.
 *
 * $Id: Event_Subject.php 3769 2008-12-15 00:48:56Z zombor $
 *
 * @package    Core
 * @author     Kohana Team
 * @copyright  (c) 2007-2008 Kohana Team
 * @license    http://kohanaphp.com/license.html
 */
abstract class Kohana_Event_Subject {

	// Attached subject listeners
	protected $listeners = array();

	/**
	 * Attach an observer to the object.
	 *
	 * @chainable
	 * @param   object  Event_Observer
	 * @return  object
	 */
	public function attach(Kohana_Event_Observer $obj)
	{
		if ( ! ($obj instanceof Kohana_Event_Observer))
			throw new Kohana_Exception('eventable.invalid_observer', get_class($obj), get_class($this));

		// Add a new listener
		$this->listeners[spl_object_hash($obj)] = $obj;

		return $this;
	}

	/**
	 * Detach an observer from the object.
	 *
	 * @chainable
	 * @param   object  Event_Observer
	 * @return  object
	 */
	public function detach(Event_Observer $obj)
	{
		// Remove the listener
		unset($this->listeners[spl_object_hash($obj)]);

		return $this;
	}

	/**
	 * Notify all attached observers of a new message.
	 *
	 * @chainable
	 * @param   mixed   message string, object, or array
	 * @return  object
	 */
	public function notify($message)
	{
		foreach ($this->listeners as $obj)
		{
			$obj->notify($message);
		}

		return $this;
	}

} // End Event Subject
