<?php

namespace Drupal\bsia_blocks\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'About Menu' Block
 *
 * @Block(
 *   id = "about_menu",
 *   admin_label = @Translation("About Menu Block"),
 * )
 */
class AboutMenu extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {

    $links = array(
      array("About", "/balsillie-school-of-international-affairs"),
      array("Director's Message", "/directors-message"),
      array("Our Partners", "/about/our-partners"),
      array("Board of Directors", "/about/board"),
      array("Staff Listing", "/about/staff-listing"),
      array("CIGI Campus", "/about/cigi-campus"),
      array("Governance", "/about/governance"),
      array("Annual Reports", "/about/annual-reports"),
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
