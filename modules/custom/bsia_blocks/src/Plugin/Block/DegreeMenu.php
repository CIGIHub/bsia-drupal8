<?php

namespace Drupal\bsia_blocks\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'Degree Menu' Block
 *
 * @Block(
 *   id = "degree_menu",
 *   admin_label = @Translation("Degree Menu Block"),
 * )
 */
class DegreeMenu extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {

    $links = array(
      array("Ph.D. in Global Governance", "/phd-global-governance",
        array(array("Course Offerings", "/global-governance-course-offerings-phd"),
              array("Frequently Asked Questions", "/frequently-asked-questions-phd"),
              array("PH.D. Publications", "/phd-publications"),
        ),
      ),
      array("MIPP", "/master-of-international-public-policy",
        array(array("Course Offerings", "/course-offerings-mipp"),
              array("Frequently Asked Questions", "/frequently-asked-questions-mipp"),
              array("African Leaders of Tomorrow", "/african-leaders-of-tomorrow-scholarship-program"),
        ),
      ),
      array("MBA/MIPP", "/mbamipp-double-degree"),
      array("MA Global Governance", "/master-of-arts-global-governance",
        array(array("Course Offerings", "/global-governance-course-offerings-magg"),
              array("Frequently Asked Questions", "/frequently-asked-questions-magg"),
              array("Warwick Double Degree FAQ", "/uw-warwick-double-degree-faq"),
        ),
      ),
      array("Applications", "/applications"),
      array("Scholarships and Awards", "/scholarships-and-awards"),
      array("Internships", "/internships"),
    );

    $menu_links = array();
    $logger = \Drupal::logger('bsia_degreemenu');

    foreach( $links as $key=>$data ){
      $length = count($data);
      //$logger->notice("length:" . print_r($length, true));

      if($length > 2){
        $item = "<li class='menu-item menu-item--expanded'><a href=" . $data[1] . "/>" . $data[0] . "</a>";
      }
      else{
        $item = "<li class='menu-item'><a href=" . $data[1] . "/>" . $data[0] . "</a></li>";
      }
     
      array_push($menu_links, $item);

      //if there is a submenu build it
      if($length > 2){
        array_push($menu_links, "<ul class='menu'>");
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
