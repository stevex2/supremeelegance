<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_pri_background
 * @version     2.5
 *
 * @copyright   Copyright (C) 2010 - 2014 Devpri. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die('Restricted access');
$document = JFactory::getDocument();
// Check mobile devices
if ($pri_background_detect->isMobile() or $pri_background_detect->isTablet()) { 
	// Use image background for mobile devices
	$document->addStyleDeclaration('
		'.$params->get('background_selector').' {
			background: url('.JURI::base() .'/'. $params->get('vimeo_background_poster').') !important;
			background-size: cover !important;
		}
	');
	if ($params->get('vimeo_background_position')== 'fixed') {
		$document->addStyleDeclaration('
			'.$params->get('background_selector').' {
				background-attachment: fixed !important;
			}
		');
	}
} else {
	// Desktop devices
	$document->addScript('//f.vimeocdn.com/js/froogaloop2.min.js');
	$document->addStyleDeclaration('
		.vimeo-background-container'.$module_id.' {
			position:absolute;
			width:100%;
			height:100%;
			top:0;
			left:0;
			overflow:hidden;
			z-index:-1;
		}
		.vimeo-background'.$module_id.' {
			background: url('.JURI::base() .'/'. $params->get('vimeo_background_poster').');
			background-size: cover;
			position: '.$params->get('vimeo_background_position').' !important;
			z-index:-2;
		}
		'.$params->get('background_selector').' {
			position: relative !important;
			overflow: hidden !important;
			z-index:1;
		}
	');
	if ($params->get('vimeo_background_fullscreen') == "0") {
		$document->addStyleDeclaration('
			.vimeo-background'.$module_id.' {
				top:0;
				left:0;
				height: 100%;
				width: 100%;
			}
		');
	} 
}
?>


 
 <?php if ($pri_background_detect->isMobile() or $pri_background_detect->isTablet()) { } else {?>
	<div class="vimeo-background-container<?php echo $module_id; ?>">
        <div class="vimeo-background<?php echo $module_id; ?>">
        	<iframe id="pri-vimeo-iframe-<?php echo $module_id; ?>" 
            src="//player.vimeo.com/video/<?php echo $params->get('vimeo_background_id'); ?>?api=1&autoplay=1
            &loop=<?php echo $params->get('vimeo_background_loop'); ?>&badge=0&byline=0&=portrait=0&title=0
            &player_id=pri-vimeo-iframe-<?php echo $module_id; ?>" width="100%" height="100%" 
            frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
            <div class="pri-overlay" style="position:absolute; height:100%; width:100%; left:0; top:0; background:rgb(0,0,0); opacity:0"></div>
        </div>
	</div>

	<script type="text/javascript">
	 (function($){
    	$(".vimeo-background-container<?php echo $module_id; ?>").appendTo("<?php echo $params->get('background_selector') ?>");
        <?php if ($params->get('vimeo_background_fullscreen') == "1") { ?>
		// Code taken from jquery tubular
         var fullscreen<?php echo $module_id; ?> = function() {
			 <?php if ($params->get('vimeo_background_position')== "absolute") { ?>
					var width = $('<?php echo $params->get('background_selector') ?>').width(),
						playerWidth, // player width, to be defined
						height = $('<?php echo $params->get('background_selector') ?>').height(),
						playerHeight, // player height, tbd
						$videoWrap = $('.vimeo-background<?php echo $module_id; ?>');
				<?php } else { ?>
					var width = $(window).width(),
						playerWidth, // player width, to be defined
						height = $(window).height(),
						playerHeight, // player height, tbd
						$videoWrap = $('.vimeo-background<?php echo $module_id; ?>');
				<?php } ?>
    
                // when screen aspect ratio differs from video, video must center and underlay one dimension
                if (width / (<?php echo $params->get('vimeo_background_ratio'); ?>) < height) { 
                    playerWidth = Math.ceil(height * (<?php echo $params->get('vimeo_background_ratio'); ?>)); // get new player width
                    $videoWrap.width(playerWidth).height(height).css({left: (width - playerWidth) / 2, top: 0}); 
                } else {
                    playerHeight = Math.ceil(width / (<?php echo $params->get('vimeo_background_ratio'); ?>)); 
                    $videoWrap.width(width).height(playerHeight).css({left: 0, top: (height - playerHeight) / 2}); 
                }
            }
            fullscreen<?php echo $module_id; ?>();
            $(window).on('resize', function() {
                fullscreen<?php echo $module_id; ?>();
            })
            <?php } ?>
    })(jQuery);
	var iframe<?php echo $module_id; ?> = document.getElementById('pri-vimeo-iframe-<?php echo $module_id; ?>');
	var player<?php echo $module_id; ?> = $f(iframe<?php echo $module_id; ?>);
	/* Set volume */
	player<?php echo $module_id; ?>.addEvent('ready', function() {
		 player<?php echo $module_id; ?>.api('setVolume', 0<?php echo $params->get('vimeo_background_volume'); ?>); 
	});
    </script>
<?php } ?>
