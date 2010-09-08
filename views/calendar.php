<?php defined('SYSPATH') OR die('No direct access allowed.');

// Get the day names
$days = Calendar::days(2);

// Previous and next month timestamps
$next = mktime(0, 0, 0, $month + 1, 1, $year);
$prev = mktime(0, 0, 0, $month - 1, 1, $year);

// Import the GET query array locally and remove the day
$qs = $_GET;
unset($qs['day']);

// Previous and next month query URIs
$path_info = Arr::get($_SERVER, 'PATH_INFO');
$prev = $path_info.URL::query(array_merge($qs, array('month' => date('n', $prev), 'year' => date('Y', $prev))));
$next = $path_info.URL::query(array_merge($qs, array('month' => date('n', $next), 'year' => date('Y', $next))));

?>
<table class="calendar">
	<caption>
		<span class="prev"><?php echo html::anchor($prev, '&larr;') ?></span>
		<span class="title"><?php echo strftime('%B %Y', mktime(0, 0, 0, $month, 1, $year)) ?></span>
		<span class="next"><?php echo html::anchor($next, '&rarr;') ?></span>
	</caption>
	<thead>
		<tr>
			<?php foreach ($days as $weekday_name): ?>
			<th><?php echo $weekday_name ?></th>
			<?php endforeach ?>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($weeks as $week): ?>
		<tr>
			<?php foreach ($week as $day):
				list($number, $current, $data) = $day;
				
				$output = NULL;
				$classes = array();
				if (is_array($data))
				{
					$classes = $data['classes'];
					if ( ! empty($data['output']))
					{
						$output = '<ul class="output"><li>'.implode('</li><li>', $data['output']).'</li></ul>';
					}
				}
			?>
			<td class="<?php echo implode(' ', $classes) ?>">
				<span class="day"><?php echo $day[0] ?></span>
				<?php echo $output ?>
			</td>
			<?php endforeach ?>
		</tr>
		<?php endforeach ?>
	</tbody>
</table>