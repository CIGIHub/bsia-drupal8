<?php

namespace Drupal\bsia_blocks\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'Students Menu' Block
 *
 * @Block(
 *   id = "students_menu",
 *   admin_label = @Translation("Students Menu Block"),
 * )
 */
class StudentsMenu extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {

    $links = array(
      array("PH.D. Global Governance", "/current-students/ph.d.-in-global-governance"),
      array("MIPP", "/current-students/master-of-international-public-policy"),
      array("MA Global Governance", "/current-students/master-of-arts-in-global-governance"),
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
