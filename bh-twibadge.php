<?php
/* 
Copyright (c) 2009-2010 Blog Highlight. All rights reserved.

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
 any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

Plugin Name: TwiBadge
Plugin URI: http://www.bloghighlight.com/wordpress-plugins/twibadge/
Description: This is a WordPress plugin to show Twitter Badge in your blog. Your audience can easily follow your tweets without going through Twitter website. This plugin is brought to you by <a href="http://www.bloghighlight.com">Blog Highlight</a>.
Version: 1.0.8
Author: Chung Bey Luen
Author URI: http://www.bloghighlight.com
*/

if (!class_exists("BHTwiBadge")) {
	class BHTwiBadge {
		var $adminOptionsName = "BHTwiBadgeAdminOptions";
		
		// Constructor
		function BHTwiBadge() {
			// Do nothing
		}
		
		// Initialize
		function init() {
			$this->getAdminOptions();
		}
		
		//Return an array of admin options
		function getAdminOptions() {
			$twiBadgeAdminOptions = array(
				'username' => '',
				'fiw_width' => '200',
				'fiw_height' => '350',
				'fiw_shell_background' => '#333333',
				'fiw_shell_text' => '#ffffff',
				'fiw_tweet_background' => '#000000',
				'fiw_tweet_text' => '#ffffff',
				'fiw_tweet_link' => '#4aed05',
				'widget_footer_flag' => 'true',
				'widget_title' => 'TwiBadge',
				'widget_title_flag' => 'true',
				'fiw_tweet_count' => '30');
			$devOptions = get_option($this->adminOptionsName);
			if (!empty($devOptions)) {
				foreach ($devOptions as $key => $option)
					$twiBadgeAdminOptions[$key] = $option;
			}
			update_option($this->adminOptionsName, $twiBadgeAdminOptions);
			return $twiBadgeAdminOptions;
		}
		
		// Show Twitter Badge With No Widget
		function showTwiBadgeNoWidget() {
			// Read admin otpions
			$devOptions = $this->getAdminOptions();
?>
			<!-- TwiBadge -->
			<script src="http://widgets.twimg.com/j/2/widget.js"></script>
			<script>
			new TWTR.Widget({
			  version: 2,
			  type: "profile",
			  rpp: <?php echo $devOptions['fiw_tweet_count']; ?>,
			  interval: 6000,
			  width: <?php echo $devOptions['fiw_width']; ?>,
			  height: <?php echo $devOptions['fiw_height']; ?>,
			  theme: {
				shell: {
				  background: "<?php echo $devOptions['fiw_shell_background']; ?>",
				  color: "<?php echo $devOptions['fiw_shell_text']; ?>"
				},
				tweets: {
				  background: "<?php echo $devOptions['fiw_tweet_background']; ?>",
				  color: "<?php echo $devOptions['fiw_tweet_text']; ?>",
				  links: "<?php echo $devOptions['fiw_tweet_link']; ?>"
				}
			  },
			  features: {
				scrollbar: true,
				loop: false,
				live: false,
				hashtags: true,
				timestamp: true,
				avatars: false,
				behavior: "all"
			  }
			}).render().setUser("<?php echo $devOptions['username']; ?>").start();
			</script>
<?php
		}
		
		// Show Twitter Badge
		function showTwiBadgeInPost() {
			// Read admin otpions
			$devOptions = $this->getAdminOptions();

			/*
			return '
			<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,124,0" width="' . $devOptions['fiw_width'] . '" height="'. $devOptions['fiw_height'] . '" id="TwitterWidget" align="middle">
				<param name="allowScriptAccess" value="sameDomain" />
				<param name="allowFullScreen" value="false" />
				<param name="movie" value="http://static.twitter.com/flash/widgets/profile/TwitterWidget.swf" />
				<param name="quality" value="high" />
				<param name="bgcolor" value="#000000" />
				<param name="FlashVars" value="userID=' . $devOptions['userid'] . '&styleURL=http://static.twitter.com/flash/widgets/profile/' . $devOptions['fiw_style'] . '.xml">
				<embed src="http://static.twitter.com/flash/widgets/profile/TwitterWidget.swf" quality="high" bgcolor="#000000" width="' . $devOptions['fiw_width'] . '" height="'. $devOptions['fiw_height'] . '" name="TwitterBadge" align="middle" allowScriptAccess="sameDomain" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" FlashVars="userID=' . $devOptions['userid'] . '&styleURL=http://static.twitter.com/flash/widgets/profile/' . $devOptions['fiw_style'] . '.xml"/>
			</object>';
			*/
			
			return '
			<script src="http://widgets.twimg.com/j/2/widget.js"></script>
			<script>
			new TWTR.Widget({
			  version: 2,
			  type: "profile",
			  rpp: ' . $devOptions['fiw_tweet_count'] . ',
			  interval: 6000,
			  width: ' . $devOptions['fiw_width'] . ',
			  height: ' . $devOptions['fiw_height'] . ',
			  theme: {
				shell: {
				  background: "' . $devOptions['fiw_shell_background'] . '",
				  color: "' .  $devOptions['fiw_shell_text'] . '"
				},
				tweets: {
				  background: "' . $devOptions['fiw_tweet_background'] . '",
				  color: "' . $devOptions['fiw_tweet_text'] . '",
				  links: "' . $devOptions['fiw_tweet_link'] . '"
				}
			  },
			  features: {
				scrollbar: true,
				loop: false,
				live: false,
				hashtags: true,
				timestamp: true,
				avatars: false,
				behavior: "all"
			  }
			}).render().setUser("' . $devOptions['username'] . '").start();
			</script>';
		}
		
		// Show Twitter Badge
		function showTwiBadge($args) {
			// Read admin otpions
			$devOptions = $this->getAdminOptions();

			extract($args);
			echo $before_widget;
			
			if ($devOptions['widget_title_flag'] == "true") {
				echo $before_title;
				echo $devOptions['widget_title'];
				echo $after_title;
			}
?>
			<!-- TwiBadge -->
			<script src="http://widgets.twimg.com/j/2/widget.js"></script>
			<script>
			new TWTR.Widget({
			  version: 2,
			  type: "profile",
			  rpp: <?php echo $devOptions['fiw_tweet_count']; ?>,
			  interval: 6000,
			  width: <?php echo $devOptions['fiw_width']; ?>,
			  height: <?php echo $devOptions['fiw_height']; ?>,
			  theme: {
				shell: {
				  background: "<?php echo $devOptions['fiw_shell_background']; ?>",
				  color: "<?php echo $devOptions['fiw_shell_text']; ?>"
				},
				tweets: {
				  background: "<?php echo $devOptions['fiw_tweet_background']; ?>",
				  color: "<?php echo $devOptions['fiw_tweet_text']; ?>",
				  links: "<?php echo $devOptions['fiw_tweet_link']; ?>"
				}
			  },
			  features: {
				scrollbar: true,
				loop: false,
				live: false,
				hashtags: true,
				timestamp: true,
				avatars: false,
				behavior: "all"
			  }
			}).render().setUser("<?php echo $devOptions['username']; ?>").start();
			</script>
<?php
			if ($devOptions['widget_footer_flag'] == "true") {
?>
				<p><?php _e('Powered by <a href="http://www.bloghighlight.com" title="Blog Highlight: Blogging Tips" alt="Blog Highlight: Blogging Tips">Blog Highlight</a>.', 'BHTwiBadge'); ?></p>
<?php
			}
			
			echo $after_widget;
		}
		
		//Prints out the admin page
		function printAdminPage() {
			$devOptions = $this->getAdminOptions();
			$errMsg = '';
				
			if (isset($_POST['updateBHTwiBadgeOptions'])) {
				if (isset($_POST['BHTwiBadgeUsername'])) {
					$devOptions['username'] = $_POST['BHTwiBadgeUsername'];
					
					//$url = 'http://twitter.com/users/show/' . $devOptions['username'] . '.xml';
					//$session = curl_init($url);
					//curl_setopt($session, CURLOPT_HEADER, false);
					//curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
					//$xml = curl_exec($session);
					//curl_close($session);
					//$doc = new SimpleXmlElement($xml, LIBXML_NOCDATA);
					//$user = '' . $doc->id;
					//$devOptions['userid'] = $user;
					
					//if (empty($user)) {
					//	$errMsg = 'Invalid username.';
					//}
				}
				if (isset($_POST['BHTwiBadgeFIWTweetCount'])) {
					$devOptions['fiw_tweet_count'] = $_POST['BHTwiBadgeFIWTweetCount'];
					
					if ($devOptions['fiw_tweet_count'] > 30) {
						$errMsg = 'Tweet count must be less than 30.';
					}
				}
				if (isset($_POST['BHTwiBadgeFIWWidth'])) {
					$devOptions['fiw_width'] = $_POST['BHTwiBadgeFIWWidth'];
				}
				if (isset($_POST['BHTwiBadgeFIWHeight'])) {
					$devOptions['fiw_height'] = $_POST['BHTwiBadgeFIWHeight'];
				}
				if (isset($_POST['BHTwiBadgeFIWStyle'])) {
					$devOptions['fiw_style'] = $_POST['BHTwiBadgeFIWStyle'];
				}
				if (isset($_POST['BHTwiBadgeFIWShellBackground'])) {
					$devOptions['fiw_shell_background'] = $_POST['BHTwiBadgeFIWShellBackground'];
				}
				if (isset($_POST['BHTwiBadgeFIWShellText'])) {
					$devOptions['fiw_shell_text'] = $_POST['BHTwiBadgeFIWShellText'];
				}
				if (isset($_POST['BHTwiBadgeFIWTweetBackground'])) {
					$devOptions['fiw_tweet_background'] = $_POST['BHTwiBadgeFIWTweetBackground'];
				}
				if (isset($_POST['BHTwiBadgeFIWTweetText'])) {
					$devOptions['fiw_tweet_text'] = $_POST['BHTwiBadgeFIWTweetText'];
				}
				if (isset($_POST['BHTwiBadgeFIWTweetLink'])) {
					$devOptions['fiw_tweet_link'] = $_POST['BHTwiBadgeFIWTweetLink'];
				}
				if (isset($_POST['BHTwiBadgeFooterFlag'])) {
					$devOptions['widget_footer_flag'] = $_POST['BHTwiBadgeFooterFlag'];
				}
				if (isset($_POST['BHTwiBadgeWidgetTitle'])) {
					$devOptions['widget_title'] = $_POST['BHTwiBadgeWidgetTitle'];
				}
				if (isset($_POST['BHTwiBadgeWidgetTitleFlag'])) {
					$devOptions['widget_title_flag'] = $_POST['BHTwiBadgeWidgetTitleFlag'];
				}
				update_option($this->adminOptionsName, $devOptions);
?>
				<div class="updated"><p><strong>
<?php
					if (!empty($errMsg)) {
						_e($errMsg, 'BHTwiBadge');
					} else {
						_e("Options Updated.", 'BHTwiBadge');
					}
?>
				</strong></p></div>
<?php
			}
?>
			<div class="wrap">
				<form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
					<h2>TwiBadge</h2>
					<p><?php _e('TwiBadge has required a great deal of time and effort to develop. If the plugin is useful to you then you can encourage me by sending an thank you email or subscribe to my blog newsletter or feed for free to receive latest updates. This will act as an incentive for me to carry on developing it, providing countless hours of support, and including any enhancements that are suggested. Once again, thank you for your support!', 'BHTwiBadge'); ?></p>
					
					<p><?php _e('TwiBadge is brought to you by Chung Bey Luen, from <a href="http://www.bloghighlight.com">BlogHighlight</a>.', 'BHTwiBadge'); ?></p>
					
					<br/><br/>
					
					<h3><?php _e('Step 1', 'BHTwiBadge'); ?></h3>
					<p><?php _e('Fill in the username of your Twitter account.', 'BHTwiBadge'); ?></p>
					<p><label for="BHTwiBadgeUsername"><?php _e('Twitter Username:', 'BHTwiBadge'); ?> <input type="text" name="BHTwiBadgeUsername" width="50" maxlength="15" value="<?php echo $devOptions['username']; ?>"></label></p>
					
					<br/><br/>
								
					<h3><?php _e('Step 2', 'BHTwiBadge'); ?></h3>
					<p><?php _e('Customize the look of your Twitter Badge.', 'BHTwiBadge'); ?></p>
					<p><label for="BHTwiBadgeFIWWidth"><?php _e('Width:', 'BHTwiBadge'); ?> <input type="text" name="BHTwiBadgeFIWWidth" width="50" maxlength="4" value="<?php echo $devOptions['fiw_width']; ?>"></label></p>
					<p><label for="BHTwiBadgeFIWHeight"><?php _e('Height:', 'BHTwiBadge'); ?> <input type="text" name="BHTwiBadgeFIWHeight" width="50" maxlength="4" value="<?php echo $devOptions['fiw_height']; ?>"></label></p>

					<p><label for="BHTwiBadgeFIWTweetCount"><?php _e('Tweet Count:', 'BHTwiBadge'); ?> <input type="text" name="BHTwiBadgeFIWTweetCount" width="50" maxlength="2" value="<?php echo $devOptions['fiw_tweet_count']; ?>"></label></p>
					
					<p><label for="BHTwiBadgeFIWShellBackground"><?php _e('Shell Background Color:', 'BHTwiBadge'); ?> <input type="text" name="BHTwiBadgeFIWShellBackground" width="50" maxlength="7" value="<?php echo $devOptions['fiw_shell_background']; ?>"></label></p>
					
					<p><label for="BHTwiBadgeFIWShellText"><?php _e('Shell Text Color:', 'BHTwiBadge'); ?> <input type="text" name="BHTwiBadgeFIWShellText" width="50" maxlength="7" value="<?php echo $devOptions['fiw_shell_text']; ?>"></label></p>
					
					<p><label for="BHTwiBadgeFIWTweetBackground"><?php _e('Tweet Background Color:', 'BHTwiBadge'); ?> <input type="text" name="BHTwiBadgeFIWTweetBackground" width="50" maxlength="7" value="<?php echo $devOptions['fiw_tweet_background']; ?>"></label></p>
					
					<p><label for="BHTwiBadgeFIWTweetText"><?php _e('Tweet Text Color:', 'BHTwiBadge'); ?> <input type="text" name="BHTwiBadgeFIWTweetText" width="50" maxlength="7" value="<?php echo $devOptions['fiw_tweet_text']; ?>"></label></p>
					
					<p><label for="BHTwiBadgeFIWTweetLink"><?php _e('Tweet Link Color:', 'BHTwiBadge'); ?> <input type="text" name="BHTwiBadgeFIWTweetLink" width="50" maxlength="7" value="<?php echo $devOptions['fiw_tweet_link']; ?>"></label></p>
					
					<p><label for="BHTwiBadgeWidgetTitle"><?php _e('Widget Title:', 'BHTwiBadge'); ?> <input type="text" name="BHTwiBadgeWidgetTitle" width="50" maxlength="20" value="<?php echo $devOptions['widget_title']; ?>"></label></p>
					<p><?php _e('Show \'Powered by TwiBadge\' in the TwiBadge widget?', 'BHTwiBadge'); ?></p>
					<p><label for="BHTwiBadgeFooterFlagYes"><input type="radio" name="BHTwiBadgeFooterFlag" value="true" <?php if ($devOptions['widget_footer_flag'] == "true") { echo 'checked="checked"'; }?> /> <?php _e('Yes', 'BHTwiBadge'); ?></label>
					&nbsp;&nbsp;&nbsp;&nbsp;
					<label for="BHTwiBadgeFooterFlagNo"><input type="radio" name="BHTwiBadgeFooterFlag" value="false" <?php if ($devOptions['widget_footer_flag'] == "false") { echo 'checked="checked"'; }?> /> <?php _e('No', 'BHTwiBadge'); ?></label>
					</p>
					<p><?php _e('Show widget title?', 'BHTwiBadge'); ?></p>
					<p><label for="BHTwiBadgeWidgetTitleFlagYes"><input type="radio" name="BHTwiBadgeWidgetTitleFlag" value="true" <?php if ($devOptions['widget_title_flag'] == "true") { echo 'checked="checked"'; }?> /> <?php _e('Yes', 'BHTwiBadge'); ?>
					&nbsp;&nbsp;&nbsp;&nbsp;
					<label for="BHTwiBadgeWidgetTitleFlagNo"><input type="radio" name="BHTwiBadgeWidgetTitleFlag" value="false" <?php if ($devOptions['widget_title_flag'] == "false") { echo 'checked="checked"'; }?> /> <?php _e('No', 'BHTwiBadge'); ?>
					</p>
					
					<br/><br/>
					
					<h3><?php _e('Step 3', 'BHTwiBadge'); ?></h3>
					<p><?php _e('Just click the button below and you\'re done!', 'BHTwiBadge'); ?></p>
					
					<div class="submit">
						<input type="submit" name="updateBHTwiBadgeOptions" value="<?php _e('Update Options', 'BHTwiBadge') ?>" />
					</div>
				</form>
			</div>
<?php
		} // End of function printAdminPage
	} // End of class BHTwiBadge
}

if (class_exists("BHTwiBadge")) {
	$twibadge_plugin = new BHTwiBadge();
}

// Register Twitter Badge Widget
if (!function_exists("registerBHTwiBadgeWidget")) {
	function registerBHTwiBadgeWidget() {
		global $twibadge_plugin;
		if (!isset($twibadge_plugin)) {
			return;
		}
		if (function_exists('register_sidebar_widget')) {
			register_sidebar_widget(__('TwiBadge'), array(&$twibadge_plugin, 'showTwiBadge'));
		}
	}	
}

// Initialize admin panel
if (!function_exists("initBHTwiBadgeAdminPanel")) {
	function initBHTwiBadgeAdminPanel() {
		global $twibadge_plugin;
		if (!isset($twibadge_plugin)) {
			return;
		}
		if (function_exists('add_options_page')) {
			add_options_page('TwiBadge', 'TwiBadge', 9, basename(__FILE__), array(&$twibadge_plugin, 'printAdminPage'));
		}
	}	
}

// Allow to show TwiBadge anyplace
if (!function_exists("showTwitterBadge")) {
	function showTwitterBadge() {
		global $twibadge_plugin;
		if (!isset($twibadge_plugin)) {
			return;
		}
		$twibadge_plugin->showTwiBadgeNoWidget();
	}	
}

//Actions and Filters	
if (isset($twibadge_plugin)) {
	//Actions
	add_action('plugins_loaded', 'registerBHTwiBadgeWidget');
	add_action('activate_bh-twibadge/bh-twibadge.php',  array(&$twibadge_plugin, 'init'));
	add_action('admin_menu', 'initBHTwiBadgeAdminPanel');
	add_shortcode('twibadge', array(&$twibadge_plugin, 'showTwiBadgeInPost'));
}

?>