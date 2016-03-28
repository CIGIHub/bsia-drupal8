<?php

namespace Drupal\import_publication\PublicationParser;

/**
 * Parses the Publication and returns corresponding values
 */
class PublicationParser {

	protected $publication;
	protected $remainingData;
	protected $logger;

	public function __construct($publication) {
		$this->publication = $this->convert_smart_quotes($publication);
		$this->remainingData = $this->publication;
		$this->logger = \Drupal::logger('import_publication');
		//$this->logger->notice(t("New Publication String:" . $this->publication));

	}

	/*
		* Finds the year and returns it
	*/
	public function getYear() {
		//finds the date wrapped in ()
		preg_match("/\(.*\d{4}.*\)/", $this->publication, $matches);

		//$this->logger->notice(t("REGEX:<pre>" . print_r($matches, true)) . "</pre>");

		if (!empty($matches)) {
			$wrappedYear = $matches[0];
			preg_match("/\d{4}/", $wrappedYear, $year);

			//$this->logger->notice(t("REGEX year:<pre>" . print_r($year, true)) . "</pre>");

			$this->shortenRemainingData($year[0]);
			return $year[0];
		}

		//else the date is not wrapped in ().
		preg_match("/\d{4}/", $this->publication, $year);
		//$this->logger->notice(t("REGEX year not wrapped:<pre>" . print_r($year, true)) . "</pre>");

		$this->shortenRemainingData($year[0]);
		return $year[0];

	}

	/*
		* Returns the title wrapped in <em> tags
	*/
	public function getTitle() {
		preg_match("/<em>(.*?)<\/em>/", $this->publication, $matches);

		if (!empty($matches)) {
			$title = $matches[0];
			$this->shortenRemainingData($title);

			$title = substr($title, 4, -5);

			$title = $this->limit255($title);

			return $title;

		}

		$this->logger->warning(t("Could not find Title in " . $this->publication));

		return "";

	}

	/*
		    * Returns the periodical wrapped in quotes
	*/
	public function getPeriodical() {
		preg_match("/\".*\"/", $this->publication, $matches);

		if (!empty($matches)) {
			$periodicalData = $matches[0];

			$this->shortenRemainingData($periodicalData);
			$periodicalData = str_replace("\"", "", $periodicalData);

			$periodicalData = $this->limit255($periodicalData);

			return $periodicalData;
		}
		$this->logger->warning(t("Could not find periodical in " . $this->publication));

		return "";
	}

	/*
		* Returns the author(s)
	*/
	public function getAuthors() {

		//first start with data using "(with <author name>, yyyy)"
		preg_match("/\(?with (.*), \d{4}\)/", $this->publication, $matches);
		if (!empty($matches)) {
			//$this->logger->notice(t("authors:<pre>" . print_r($matches, true)) . "</pre>");
			$authors = $matches[0];
			$authors = trim(substr($authors, 5, -7));
			$this->shortenRemainingData($authors);
			return $authors;
		}

		//or it could simply be (with <author names>)
		preg_match("/\(with (.*)\)/", $this->publication, $matches);
		if (!empty($matches)) {
			//$this->logger->notice(t("authors:<pre>" . print_r($matches, true)) . "</pre>");
			$authors = $matches[0];

			$this->shortenRemainingData($authors);

			$authors = trim(substr($authors, 5, -1));

			return $authors;
		}

		//Not found yet, so its probably at the start. remove strong tags
		$publication = strip_tags($this->publication, "<em>");
		$this->remainingData = strip_tags($this->remainingData, "<em>");

		//not found, so strip the first part of the string, up to a (, ", or <em>, or YYYY characters
		preg_match("/^([A-Za-z].*?) (\(|\"|<em>|\(?\d{4}\)?)/", $publication, $matches);
		if (!empty($matches)) {
			//$this->logger->notice(t("authors (at start) :<pre>" . print_r($matches, true)) . "</pre>");
			$authors = $matches[0];

			//check if authors ends with a quote or bracket. If yes, then remove.
			if (stripos(strrev($authors), "\"") === 0 || stripos(strrev($authors), "(") === 0) {
				$authors = trim(substr($authors, 0, -1));
			}

			if (stripos(strrev($authors), strrev("<em>")) === 0) {
				$authors = trim(substr($authors, 0, -4));
			}

			if (stripos(strrev($authors), ",") === 0) {
				$authors = trim(substr($authors, 0, -1));
			}

			$this->shortenRemainingData($authors);
			return $authors;
		}

		$this->logger->warning(t("Could not find author in " . $publication));
		return "";

	}

	/*
		* Location has the rest of the data
	*/
	public function getLocation() {
		$this->remainingData = str_replace("(with , )", "", $this->remainingData);
		$this->remainingData = str_replace("()", "", $this->remainingData);
		$this->remainingData = str_replace(",", "", $this->remainingData);
		$this->remainingData = str_replace(".", "", $this->remainingData);

		return $this->limit255(trim(strip_tags($this->remainingData)));
	}

	/*
		 * takes the RemainingData string, and cuts out the $piece from it.
	*/
	private function shortenRemainingData($piece) {
		$start = strpos($this->remainingData, $piece);

		if ($start === false) {
			//not found
		} else {
			$end = strpos($this->remainingData, $piece) + strlen($piece);
			$this->remainingData = substr($this->remainingData, 0, $start) . substr($this->remainingData, $end);
		}

		//$this->logger->notice(t("Remaining String: " . $this->remainingData));

	}

	private function convert_smart_quotes($string) {
		$search = array(
			"‘",
			"’",
			"“",
			"”",
		);

		$replace = array(
			"'",
			"'",
			'"',
			'"',
		);

		return str_replace($search, $replace, $string);
	}

	private function limit255($str) {
		if (strlen($str) > 255) {
			$str = substr($str, 0, 255);
		}
		return $str;
	}

}