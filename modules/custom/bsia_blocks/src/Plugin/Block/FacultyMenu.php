<?php

namespace Drupal\bsia_blocks\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'Faculty Menu' Block
 *
 * @Block(
 *   id = "faculty_menu",
 *   admin_label = @Translation("Faculty Menu Block"),
 * )
 */
class FacultyMenu extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {

    $links = array(
      array("Director", "/people/john-ravenhill"),
      array("Program Directors", "/faculty/program-directors"),
      array("CIGI Chairs", "/faculty/cigi-chairs"),
      array("Faculty", "/faculty"),
      array("Postdoctoral Fellows", "/faculty/postdoctoral-fellows"),
      array("BSIA Fellows (External)", "/faculty/bsia-fellows"),
      array("Visiting Fellows", "/faculty/visiting-fellows"),
      array("Staff Listing", "/about/staff-listing"),
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
