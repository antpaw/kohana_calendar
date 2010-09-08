<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Calendar extends Controller
{

	public function action_index()
	{
		$calendar = new Calendar(Arr::get($_GET, 'month', date('m')), Arr::get($_GET, 'year', date('Y')));
		$calendar->attach(
			$calendar->event()
			->condition('timestamp', time())
			->output(html::anchor('http://google.de', 'google'))
		);

		$data = array(
			'content' => $calendar->render()
		);

		$this->request->response = new View('index', $data);
	}
}