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
if ($pri_background_detect->isMobile() or $pri_background_detect->isTablet()) { 
	$document->addStyleDeclaration('
		'.$params->get('background_selector').' {
			background: url('.JURI::base() .'/'. $params->get('youtube_background_poster').') !important;
 			background-size: cover !important;
			}
	');
	if ($params->get('youtube_background_position')== 'fixed') {
		$document->addStyleDeclaration('
			'.$params->get('background_selector').' {
				background-attachment: fixed !important;
			}
		');
	}
} else {
	$document->addScriptDeclaration("
	    var tag = document.createElement('script');
	    tag.src = 'https://www.youtube.com/iframe_api';
	    var firstScriptTag = document.getElementsByTagName('script')[0];
	    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
	");
	$document->addStyleDeclaration('
		.youtube-background-container'.$module_id.' {
			position:absolute;
			width:100%;
			height:100%;
			top:0;
			left:0;
			overflow:hidden;
			z-index:-1;
		}
		.youtube-background'.$module_id.' {
			background: url('.JURI::base() .'/'. $params->get('youtube_background_poster').');
			background-size: cover;
			position: '.$params->get('youtube_background_position').' !important;
			z-index:-2;
		}
		'.$params->get('background_selector').' {
			position: relative !important;
			overflow: hidden !important;
			z-index:1;
		}
	');
	if ($params->get('youtube_background_fullscreen') == "0") {
		$document->addStyleDeclaration('
			.youtube-background'.$module_id.' {
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
	<div class="youtube-background-container<?php echo $module_id; ?>">
         <div class="youtube-background<?php echo $module_id; ?>">
            <div id="youtube-video-<?php echo $module_id; ?>" style="visibility:hidden"></div>
            <div class="pri-overlay" style="position:absolute; height:100%; width:100%; left:0; top:0; background:rgb(0,0,0); opacity:0"></div>
        </div>
        </div>
    </div>
	<script type="text/javascript">
	var player<?php echo $module_id; ?>;
      function onYouTubeIframeAPIReady() {
          player<?php echo $module_id; ?> = new YT.Player('youtube-video-<?php echo $module_id; ?>', {
          playerVars: { 'autoplay': 1, 
		  				'controls': <?php echo $params->get('youtube_background_controls'); ?>,
						'autohide':1,
						'iv_load_policy': 3,
						'showinfo':0,
						'vq': '<?php echo $params->get('youtube_background_quality'); ?>',
						'loop':<?php echo $params->get('youtube_background_loop'); ?>,
						'wmode':'opaque',
						'playlist': '<?php echo $params->get('youtube_background_id'); ?>'
					   },
          videoId: '<?php echo $params->get('youtube_background_id'); ?>',
          height: '100%',
          width: '100%',
		  events: {
      		  'onReady': onPlayerReady<?php echo $module_id; ?>,
			  'onStateChange': onPlayerStateChange<?php echo $module_id; ?>
    	 } 
        });
      }
	  function onPlayerReady<?php echo $module_id; ?>(event) {
	    event.target.setVolume(<?php echo $params->get('youtube_background_volume'); ?>); 
	  }
	  function onPlayerStateChange<?php echo $module_id; ?>(event) {
		document.getElementById("youtube-video-<?php echo $module_id; ?>").style.visibility = "visible";
	  }
	(function($){
		$(".youtube-background-container<?php echo $module_id; ?>").appendTo("<?php echo $params->get('background_selector') ?>");
        <?php if ($params->get('youtube_background_fullscreen') == "1") { ?>
		// Code taken from jquery tubular
         var fullscreen<?php echo $module_id; ?> = function() {
			 <?php if ($params->get('youtube_background_position')== "absolute") { ?>
					var width = $('<?php echo $params->get('background_selector') ?>').width(),
						playerWidth, // player width, to be defined
						height = $('<?php echo $params->get('background_selector') ?>').height(),
						playerHeight, // player height, tbd
						$videoWrap = $('.youtube-background<?php echo $module_id; ?>');
				<?php } else { ?>
					var width = $(window).width(),
						playerWidth, // player width, to be defined
						height = $(window).height(),
						playerHeight, // player height, tbd
						$videoWrap = $('.youtube-background<?php echo $module_id; ?>');
				<?php } ?>
    
                // when screen aspect ratio differs from video, video must center and underlay one dimension
                if (width / (<?php echo $params->get('youtube_background_ratio'); ?>) < height) { 
                    playerWidth = Math.ceil(height * (<?php echo $params->get('youtube_background_ratio'); ?>)); // get new player width
                    $videoWrap.width(playerWidth).height(height).css({left: (width - playerWidth) / 2, top: 0}); 
                } else {
                    playerHeight = Math.ceil(width / (<?php echo $params->get('youtube_background_ratio'); ?>)); 
                    $videoWrap.width(width).height(playerHeight).css({left: 0, top: (height - playerHeight) / 2}); 
                }
    
            }
            fullscreen<?php echo $module_id; ?>();
            $(window).on('resize', function() {
                fullscreen<?php echo $module_id; ?>();
            })
            <?php } ?>
    })(jQuery);
    </script>
<?php } ?>
 
