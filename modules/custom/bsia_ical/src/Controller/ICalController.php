<?php
/**
 * @file
 * Contains \Drupal\bsia_ical\Controller\ICalController.
 */

namespace Drupal\bsia_ical\Controller;

use Drupal\Core\Controller\ControllerBase;

class ICalController extends ControllerBase {
	public function createICal($nid) {

		$node = \Drupal\node\Entity\Node::load($nid);

		$eventdate = $node->get('field_event_date')->getValue();
		$title = $node->get('title')->getValue();

		$title = $title[0]['value'];
		$startdate = $eventdate[0]['value'];
		$enddate = $eventdate[1]['value'];

		if (empty($enddate)) {
			$enddate = $startdate;
		}

		$startdate = self::convertDateToICal($startdate);
		$enddate = self::convertDateToICal($enddate);
		$filecontents = self::buildICSFile($startdate, $enddate, $title, $nid);

		// open raw memory as file so no temp files needed, you might run out of memory though
		$file = fopen('php://memory', 'w');

		fwrite($file, $filecontents);
		// reset the file pointer to the start of the file
		rewind($file);
		// tell the browser it's going to be a calendar file
		header('Content-Type: text/calendar; charset=utf-8');
		// tell the browser we want to save it instead of displaying it
		header('Content-Disposition: attachment; filename="calendar.ics";');
		header('Cache-Control: store, no-cache, must-revalidate, post-check=0, pre-check=0');
		// make php send the generated file to the browser
		fpassthru($file);
		exit;

		/*
			return array(
				'#type' => 'markup',
				'#markup' => $this->t('Hello, ical World!<pre>' . $filecontents . "</pre>"),
			);
		*/
	}

	/**
	 * simple date formatting to convert into 20160420T200000Z. date must be in 2016-04-20T20:00:00Z format
	 */
	private function convertDateToICal($date) {
		return str_replace("-", "", str_replace(":", "", $date)) . "Z";
	}

	private function buildICSFile($stardate, $endate, $title, $nid) {
		return "BEGIN:VCALENDAR\n" .
			"VERSION:2.0\n" .
			"METHOD:REQUEST\n" .
			"PRODID:-//Drupal iCal API//EN\n" .
			"BEGIN:VEVENT\n" .
			"UID:calendar." . $nid . ".field_event_date.0.0\n" .
			"ORGANIZER;CN=\"Balsillie School of International Affairs\":mailto:no-reply@balsillieschool.ca\n" .
			"SUMMARY:" . $title . "\n" .
			"DTSTAMP:" . $stardate . "\n" .
			"DTSTART:" . $stardate . "\n" .
			"DTEND:" . $endate . "\n" .
			"END:VEVENT\n" .
			"END:VCALENDAR";

	}
}
