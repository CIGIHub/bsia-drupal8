<?php
/**
 * Provides a 'Hello' Block
 *
 * @Block(
 *   id = "connectwithus_social",
 *   admin_label = @Translation("Connect With Us Social"),
 * )
 */

namespace Drupal\bsia_connect\Plugin\Block;

use Drupal\Core\Block\BlockBase;

class BSIAConnectBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {
    return array(
      '#markup' => ('<h3>Connect with us on Social Media</h3>

				<div class="connect-social">
					<div class="share-link"><a class="social-circle" href="https://twitter.com/BalsillieSIA"><i class="fa fa-twitter"></i></a></div>
					<div class="share-link"><a class="social-circle" href="https://www.facebook.com/balsillieschool/timeline/"><i class="fa fa-facebook"></i></a></div>
					<div class="share-link"><a class="social-circle" href="https://www.youtube.com/user/BalsillieSchool"><i class="fa fa-youtube"></i></a></div>
				</div>
				<div class="clearfloat"></div>

				<h3 class="strong">Find directions to the School</h3>
				<p>Building Information: <br>
					Balsillie School of International Affairs<br>
					67 Erb Street West<br>
					Waterloo, ON N2L 6C2<br>
					Canada
				</p>
				<p>Phone: 1.226.772.3001</p>
				<p><a href="https://www.google.ca/maps/place/67+Erb+St+W,+Waterloo,+ON+N2L+6C2/@43.463645,-80.525616,17z/data=!3m1!4b1!4m2!3m1!1s0x882bf4126eab0155:0x48ec3237e30666a0">Google Maps to the BSIA</a>.
				</p>
				<p>&nbsp;</p>
				<p><strong>For room and event inquiries, please email <a href="mailto:events@balsillieschool.ca">events@balsillieschool.ca</a> or call 226.772.3099.</strong></p>

				'),
    );
  }
}
?>