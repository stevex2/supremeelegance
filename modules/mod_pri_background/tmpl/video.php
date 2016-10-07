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
function gcd( $a, $b ){
    return ($a % $b) ? gcd($b,$a % $b) : $b;
}
function ratio( $x, $y ){
    $gcd = gcd($x, $y);
    return ($x/$gcd).'/'.($y/$gcd);
}
$ratio = ratio($params->get('video_background_width'), $params->get('video_background_height') );
if ($params->get('video_background_video_source') == 'local'){
	$sourceUrl = JURI::base().'/';
} else {
	$sourceUrl = '';
}
// Check mobile devices
if ($pri_background_detect->isMobile() or $pri_background_detect->isTablet()) {
	// Use image for mobile devices
	$document->addStyleDeclaration('
		'.$params->get('background_selector').' {
			background: url('.$sourceUrl . $params->get('video_background_poster').') !important;
			background-size: cover !important;
		}
	');
} else {
	//Desktop devices
	$document->addScript(JURI::base() .'modules/mod_pri_background/assets/js/videobackground.js');
	$document->addStyleDeclaration('
		'.$params->get('background_selector').' .video-background-container'.$module_id.' {
			z-index: -1;
			width: 100%;
			height: 100%;
			position:absolute;
			top: 0;
			left: 0;
			overflow:hidden !important;
		}
		'.$params->get('background_selector').' .video-background'.$module_id.' {
			z-index: -2;
			position:'.$params->get('video_background_video_position').';
		}
		'.$params->get('background_selector').'{
			position:relative;
			z-index:1;
		}
		'.$params->get('background_selector').' .video-background'.$module_id.' video {
			min-height: 100%;
			min-width: 100%;
		}
		.ui-video-background-controls {
			display: none;
		}
	');
}
?>
<?php if ($pri_background_detect->isMobile() or $pri_background_detect->isTablet()) { } else {?>
	<script type="text/javascript">
    (function($){
        $("<?php echo $params->get('background_selector'); ?>").prepend("<div class=video-background-container<?php echo $module_id; ?>><div class=video-background<?php echo $module_id; ?>></div></div>");
            $(".video-background<?php echo $module_id; ?>").videobackground({
                videoSource:	[["<?php echo $sourceUrl .''.$params->get('video_background_video_mp4'); ?>", "video/mp4"],
                                ["<?php echo $sourceUrl .''.$params->get('video_background_video_webm'); ?>", "video/webm"], 
                                ["<?php echo $sourceUrl .''.$params->get('video_background_video_ogg'); ?>", "video/ogg"]], 
                poster: 		"<?php echo $sourceUrl .''.$params->get('video_background_poster'); ?>",
                loop:           <?php echo $params->get('video_background_video_loop'); ?>,
                resizeTo:       'document',
                resize:       	false
            });
            if('<?php echo $params->get('video_background_video_audio'); ?>' == 'mute'){
                $(".video-background<?php echo $module_id; ?>").videobackground("<?php echo $params->get('video_background_video_audio'); ?>");
            }
			 var fullscreen<?php echo $module_id; ?> = function() {
			 <?php if ($params->get('video_background_video_position')== "absolute") { ?>
					var width = $('<?php echo $params->get('background_selector') ?>').width(),
						playerWidth, // player width, to be defined
						height = $('<?php echo $params->get('background_selector') ?>').height(),
						playerHeight, // player height, tbd
						$videoWrap = $('.video-background<?php echo $module_id; ?>');
				<?php } else { ?>
					var width = $(window).width(),
						playerWidth, // player width, to be defined
						height = $(window).height(),
						playerHeight, // player height, tbd
						$videoWrap = $('.video-background<?php echo $module_id; ?>');
				<?php } ?>
    
                // when screen aspect ratio differs from video, video must center and underlay one dimension
                if (width / (<?php echo $ratio; ?>) < height) { 
                    playerWidth = Math.ceil(height * (<?php echo $ratio; ?>)); // get new player width
                    $videoWrap.width(playerWidth).height(height).css({left: (width - playerWidth) / 2, top: 0}); 
                } else {
                    playerHeight = Math.ceil(width / (<?php echo $ratio; ?>)); 
                    $videoWrap.width(width).height(playerHeight).css({left: 0, top: (height - playerHeight) / 2}); 
                }
    
            }
            fullscreen<?php echo $module_id; ?>();
            $(window).on('resize', function() {
                fullscreen<?php echo $module_id; ?>();
            })
    })(jQuery);
    </script>
<?php } ?>