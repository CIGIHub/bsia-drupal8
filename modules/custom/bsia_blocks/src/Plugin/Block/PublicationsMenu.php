<?php

namespace Drupal\bsia_blocks\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'Publications Menu' Block
 *
 * @Block(
 *   id = "publications_menu",
 *   admin_label = @Translation("Publications Menu Block"),
 * )
 */
class PublicationsMenu extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {

  $links = array(
      array("Publications", "/publications",
        array(array("Books", "/category/publication-type/books"),
              array("Refereed", "/category/publication-type/refereed"),
              array("Op Eds", "/category/publication-type/op-eds"),
              array("Policy Reports", "/category/publication-type/policy-reports"),
              array("Non Refereed", "/category/publication-type/non-refereed"),
        ),
      ),
      array("PH.D. Publications", "/phd-publications"),
    );

    $menu_links = array();

    foreach( $links as $key=>$data ){
     
      $item = "<li class='menu-item'><a href=" . $data[1] . "/>" . $data[0] . "</a></li>";
      array_push($menu_links, $item);

      //if there is a submenu build it
      if($data[2]){
        array_push($menu_links, "<li class='menu-item menu-item--expanded'><ul class='menu'>");
        foreach($data[2] as $key2=>$data2){
          $subitem = "<li class='menu-item'><a href=" . $data2[1] . "/>" . $data2[0] . "</a></li>";
          array_push($menu_links, $subitem);
        }
        array_push($menu_links, "</ul></li>");
      }
    }

    $menu = join(" ", $menu_links);
   
	  return array(
			'#markup' => "<ul class=menu>" . $menu . "</ul>",
		);
  }
}