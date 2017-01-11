<?php

namespace Drupal\bsia_blocks\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'Events Menu' Block
 *
 * @Block(
 *   id = "events_menu",
 *   admin_label = @Translation("Events Menu Block"),
 * )
 */
class EventsMenu extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {

    $links = array(
      array("Event Recaps", "/events/recap"),
      array("Past Events", "/events/archive"),
    );

   $menu_links = array();

    foreach( $links as $key=>$data ){     
      $item = "<li class='menu-item'><a href=" . $data[1] . "/>" . $data[0] . "</a></li>";
      array_push($menu_links, $item);
    }
    $menu = join(" ", $menu_links);
   
	  return array(
			'#markup' => "<ul class=menu>" . $menu . "</ul>",
		);
  }
}
