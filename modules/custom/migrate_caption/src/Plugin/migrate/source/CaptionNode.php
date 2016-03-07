<?php

/**
 * @file
 * Contains \Drupal\migrate_caption\Plugin\migrate\source\CaptionNode.
 */

namespace Drupal\migrate_caption\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;
use Drupal\migrate\Row;

/**
 * Source plugin for caption content.
 *
 * @MigrateSource(
 *   id = "caption_node"
 * )
 */
class CaptionNode extends SqlBase {

	/**
	 * {@inheritdoc}
	 */
	public function query() {
		/**
		 * An important point to note is that your query *must* return a single row
		 * for each item to be imported. Here we might be tempted to add a join to
		 * migrate_example_beer_topic_node in our query, to pull in the
		 * relationships to our categories. Doing this would cause the query to
		 * return multiple rows for a given node, once per related value, thus
		 * processing the same node multiple times, each time with only one of the
		 * multiple values that should be imported. To avoid that, we simply query
		 * the base node data here, and pull in the relationships in prepareRow()
		 * below.
		 */
		$query = $this->select('content_field_image', 'cfi')
			->fields('cfi', ['nid', 'field_image_data']);
		return $query;
	}

	/**
	 * {@inheritdoc}
	 */
	public function fields() {
		$fields = [
			'nid' => $this->t('Node ID'),
			'field_image_data' => $this->t('Caption Description'),
		];

		return $fields;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getIds() {
		return [
			'nid' => [
				'type' => 'integer',
				'alias' => 'n',
			],
		];
	}

}
