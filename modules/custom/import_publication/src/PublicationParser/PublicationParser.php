<?php

namespace Drupal\import_publication\PublicationParser;

/**
 * Parses the Publication and returns corresponding values
 */
class PublicationParser {

	/*
		 * Finds the year and returns it
	*/
	static public function getYear($publication) {
		//finds the date wrapped in ()
		preg_match("/\(.*\d{4}.*\)/", $publication, $matches);

		$logger = \Drupal::logger('import_publication');
		$logger->notice(t("REGEX:<pre>" . print_r($matches, true)) . "</pre>");

		if (!empty($matches)) {
			$wrappedYear = $matches[0];
			preg_match("/\d{4}/", $wrappedYear, $year);

			$logger->notice(t("REGEX year:<pre>" . print_r($year, true)) . "</pre>");
			return $year[0];
		}

		//else the date is not wrapped in ().
		preg_match("/\d{4}/", $publication, $year);
		$logger->notice(t("REGEX year not wrapped:<pre>" . print_r($year, true)) . "</pre>");
		return $year[0];

	}

	/*
		 * Returns the title wrapped in <em> tags
	*/
	static public function getTitle($publication) {
		$openEM = strpos($publication, "<em>") + 4;
		$closeEM = strpos($publication, "</em>");
		$title_length = $closeEM - $openEM;
		return substr($publication, $openEM, $title_length);
	}

	/*
		 * Returns the periodical wrapped in quotes
	*/
	static public function getPeriodical($publication) {
		preg_match("/“.*”|\".*\"/", $publication, $matches);

		if (!empty($matches)) {
			$periodicalData = $matches[0];
			$periodicalData = str_replace("\"", "", $periodicalData);
			$periodicalData = str_replace("“", "", $periodicalData);
			$periodicalData = str_replace("”", "", $periodicalData);
			return $periodicalData;
		}
		$logger = \Drupal::logger('import_publication');
		$logger->warning(t("Could not find periodical in " . $publication));

		return "";
	}

	/*
		 * Returns the author(s)
	*/
	static public function getAuthors($publication) {

		$logger = \Drupal::logger('import_publication');

		//first start with data using "(with <author name>, yyyy)"
		preg_match("/\(?with (.*), \d{4}/", $publication, $matches);
		if (!empty($matches)) {
			$logger->notice(t("authors:<pre>" . print_r($matches, true)) . "</pre>");
			return $matches[0];
		}

		//or it could simply by (with <author names>)
		preg_match("/\(with (.*)\)/", $publication, $matches);
		if (!empty($matches)) {
			$logger->notice(t("authors:<pre>" . print_r($matches, true)) . "</pre>");
			return $matches[0];
		}

		//Not found yet, so its probably at the start. remove strong tags
		$publication = strip_tags($publication, "<em>");

		//not found, so strip the first part of the string, up to a (, ", or <em>, or YYYY characters
		preg_match("/^([A-Za-z].*?) (\(|\"|“|<em>|\(?\d{4}\)?)/", $publication, $matches);
		if (!empty($matches)) {
			$logger->notice(t("authors (at start) :<pre>" . print_r($matches, true)) . "</pre>");
			$authors = $matches[0];

			//check if authors ends with a comma, if so, remove.
			if (stripos(strrev($authors), ",") === 0) {
				$authors = substr($authors, 0, -1);
			}
			return $authors;
		}

		$logger->warning(t("Could not find author in " . $publication));
		return "";

	}

}