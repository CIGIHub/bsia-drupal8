<?php

namespace Drupal\bsia_blocks\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'Research Menu' Block
 *
 * @Block(
 *   id = "research_menu",
 *   admin_label = @Translation("Research Menu Block"),
 * )
 */
class ResearchMenu extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {

    $links = array(
      array("Research Clusters", "/research#cluster"),
      array("Affiliated Research Projects", "/research#projects"),
      array("Affiliated Centres", "/research#centres"),
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
