<?php

namespace Drupal\datetime\Plugin\views\filter;

use Drupal\Component\Datetime\DateTimePlus;
use Drupal\Core\Datetime\DateFormatterInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\datetime\Plugin\Field\FieldType\DateTimeItem;
use Drupal\views\FieldAPIHandlerTrait;
use Drupal\views\Plugin\views\filter\Date as NumericDate;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Date/time views filter.
 *
 * Even thought dates are stored as strings, the numeric filter is extended
 * because it provides more sensible operators.
 *
 * @ingroup views_filter_handlers
 *
 * @ViewsFilter("datetime")
 */
class Date extends NumericDate implements ContainerFactoryPluginInterface {

  use FieldAPIHandlerTrait;

  /**
   * The date formatter service.
   *
   * @var \Drupal\Core\Datetime\DateFormatterInterface
   */
  protected $dateFormatter;

  /**
   * Date format for SQL conversion.
   *
   * @var string
   *
   * @see \Drupal\views\Plugin\views\query\Sql::getDateFormat()
   */
  protected $dateFormat = DATETIME_DATETIME_STORAGE_FORMAT;

  /**
   * Determines if the timezone offset is calculated.
   *
   * @var bool
   */
  protected $calculateOffset = TRUE;

  /**
   * The request stack used to determin current time.
   *
   * @var \Symfony\Component\HttpFoundation\RequestStack
   */
  protected $requestStack;

  /**
   * Constructs a new Date handler.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin ID for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Datetime\DateFormatterInterface $date_formatter
   *   The date formatter service.
   * @param \Symfony\Component\HttpFoundation\RequestStack $request_stack
   *   The request stack used to determine the current time.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, DateFormatterInterface $date_formatter, RequestStack $request_stack) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->dateFormatter = $date_formatter;
    $this->requestStack = $request_stack;

    $definition = $this->getFieldStorageDefinition();
    if ($definition->getSetting('datetime_type') === DateTimeItem::DATETIME_TYPE_DATE) {
      // Date format depends on field storage format.
      $this->dateFormat = DATETIME_DATE_STORAGE_FORMAT;
      // Timezone offset calculation is not applicable to dates that are stored
      // as date-only.
      $this->calculateOffset = FALSE;
    }
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('date.formatter'),
      $container->get('request_stack')
    );
  }

  /**
   * Override parent method, which deals with dates as integers.
   */
  protected function opBetween($field) {
    $timezone = ($this->dateFormat === DATETIME_DATE_STORAGE_FORMAT)
      ? DATETIME_STORAGE_TIMEZONE
      : drupal_get_user_timezone();

    // Although both 'min' and 'max' values are required,
    // default empty 'min' value as UNIX timestamp 0.
    $min = (!empty($this->value['min'])) ? $this->value['min'] : '@0';

    $a = new DateTimePlus($min, new \DateTimeZone($timezone));
    $b = new DateTimePlus($this->value['max'], new \DateTimeZone($timezone));

    // For 'date' types with offset, user's 'now' could not be UTC 'now'.
    // So calculate the difference between user's timezone and UTC.
    $origin_offset = 0;
    if ($this->dateFormat === DATETIME_DATE_STORAGE_FORMAT && $this->value['type'] == 'offset') {
      $origin_offset = $origin_offset + timezone_offset_get(new \DateTimeZone(drupal_get_user_timezone()), new \DateTime($this->value['min'], new \DateTimeZone($timezone)));
    }

    // Convert to ISO format and format for query. UTC timezone is used since
    // dates are stored in UTC.
    $a = $this->query->getDateFormat($this->query->getDateField("'" . $this->dateFormatter->format($a->getTimestamp() + $origin_offset, 'custom', DATETIME_DATETIME_STORAGE_FORMAT, DATETIME_STORAGE_TIMEZONE) . "'", TRUE, $this->calculateOffset), $this->dateFormat, TRUE);
    $b = $this->query->getDateFormat($this->query->getDateField("'" . $this->dateFormatter->format($b->getTimestamp() + $origin_offset, 'custom', DATETIME_DATETIME_STORAGE_FORMAT, DATETIME_STORAGE_TIMEZONE) . "'", TRUE, $this->calculateOffset), $this->dateFormat, TRUE);

    // This is safe because we are manually scrubbing the values.
    $operator = strtoupper($this->operator);
    $field = $this->query->getDateFormat($this->query->getDateField($field, TRUE, $this->calculateOffset), $this->dateFormat, TRUE);
    $this->query->addWhereExpression($this->options['group'], "$field $operator $a AND $b");
  }

  /**
   * Override parent method, which deals with dates as integers.
   */
  protected function opSimple($field) {
    $timezone = ($this->dateFormat === DATETIME_DATE_STORAGE_FORMAT)
      ? DATETIME_STORAGE_TIMEZONE
      : drupal_get_user_timezone();

    $value = new DateTimePlus($this->value['value'], new \DateTimeZone($timezone));

    // For 'date' types with offset, user's 'now' could not be UTC 'now'.
    // So calculate the difference between user's timezone and UTC.
    $origin_offset = 0;
    if ($this->dateFormat === DATETIME_DATE_STORAGE_FORMAT && $this->value['type'] == 'offset') {
      $origin_offset = $origin_offset + timezone_offset_get(new \DateTimeZone(drupal_get_user_timezone()), new \DateTime($this->value['value'], new \DateTimeZone($timezone)));
    }

    // Convert to ISO. UTC timezone is used since
    // dates are stored in UTC.
    $value = $this->query->getDateFormat($this->query->getDateField("'" . $this->dateFormatter->format($value->getTimestamp() + $origin_offset, 'custom', DATETIME_DATETIME_STORAGE_FORMAT, DATETIME_STORAGE_TIMEZONE) . "'", TRUE, $this->calculateOffset), $this->dateFormat, TRUE);

    // This is safe because we are manually scrubbing the value.
    $field = $this->query->getDateFormat($this->query->getDateField($field, TRUE, $this->calculateOffset), $this->dateFormat, TRUE);
    $this->query->addWhereExpression($this->options['group'], "$field $this->operator $value");
  }

}
