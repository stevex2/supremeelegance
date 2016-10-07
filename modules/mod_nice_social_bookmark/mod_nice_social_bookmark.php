<?php
/* @package Joomla
 * @copyright Copyright (C) Open Source Matters. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * @extension Nice Social Bookmark
 * @copyright Copyright (C) Nikola Biskup salamander-studios.com
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
defined('_JEXEC') or die('Restricted access');// no direct access
if( isset($_SERVER['HTTPS'] )  && $_SERVER['HTTPS'] != 'off' ) 
{    $htp="https";
}
else
{    $htp="http";
}
$url = $htp."://".$_SERVER['HTTP_HOST'] . getenv('REQUEST_URI');  
$rss_url = $htp."://".$_SERVER['HTTP_HOST'];
$isize = $params->get('isize');
$iset = $params->get('iset');
$iposition = $params->get('iposition');
$tweetbtn = $params->get('tweetbtn');
$tweetbtnsize = $params->get('tweetbtnsize');
$tweetflwsize = $params->get('tweetflwsize');
$tweettext = $params->get('tweettext');
if ($params->get('s25')==0){$tweetfollowcount = "false";}
else{$tweetfollowcount = "true";}
if ($params->get('tweetname')!=""){$tweetname = $params->get('tweetname');}
else{$tweetname = "twitterapi";}
$linkedcount  = $params->get('linkedcount');
$linkedurl  = $params->get('linkedurl');
$document = JFactory::getDocument();
/*$title = $document->getTitle();
htmlspecialchars(urldecode($title));*/
$title = urlencode($document->getTitle());
$opac = $params->get('opac');
$porient = $params->get('porient');
$piname = $params->get('piname');
$imagetobepinned = $params->get('imagetobepinned');
if ($opac=="yes"){
		$document->addStyleSheet('modules/mod_nice_social_bookmark/css/nsb-opac.css');
		}
		elseif ($opac=="invert"){$document->addStyleSheet('modules/mod_nice_social_bookmark/css/nsb-opac-inv.css');
		}
		else{$document->addStyleSheet('modules/mod_nice_social_bookmark/css/nsb.css');
		}
       
$twlink = $params->get('twlink');
$fblink = $params->get('fblink');
$mslink = $params->get('mslink');
$lilink = $params->get('lilink');
$rsslink = $params->get('rsslink');
if($params->get("plusoneurl")!=""){$plusoneurl	= $params->get("plusoneurl");}
else {$plusoneurl	= $url;}
$size 	= $params->get("size");
$lang 	= $params->get("Locale");
$googlecount 	= $params->get("googlecount");
$customlink1 = $params->get("customlink1");
$customicon1 = $params->get("customicon1");
$customalt1 = $params->get("customalt1");
$customlink2 = $params->get("customlink2");
$customicon2 = $params->get("customicon2");
$customalt2 = $params->get("customalt2");
$customlink3 = $params->get("customlink3");
$customicon3 = $params->get("customicon3");
$customalt3 = $params->get("customalt3");
$customlink4 = $params->get("customlink4");
$customicon4 = $params->get("customicon4");
$customalt4 = $params->get("customalt4");
$padding = $params->get("padding");
$nofollow = $params->get("nofollow");
$follower = '';
if($nofollow == "yes"){$follower = 'rel="nofollow"';}
$doc=JFactory::getDocument();
$css=array();
$css[]='.nsb_container a.icons{';
$css[]="\tpadding:".$params->get('padding').'px; float:'.$params->get('iposition').'; display:inline-block;';
$css[]='}#plusone{padding:'.$params->get('padding').'px !important;}';
$doc->addStyleDeclaration(implode("\n",$css));

echo '<div class="nsb_container">';
$tt = $params->get('s1', '1');
if ($tt == "1")
{
    if ($fblink == ""){
    $p[] = $params->get('counter1');
    $h[] = '<a id="l1" class="icons" target="_blank" '.$follower.' href="http://www.facebook.com/sharer.php?u='.$url.'&amp;title='.$title.'"><img title="Facebook" src="modules/mod_nice_social_bookmark/icons/facebook_'.$iset.'_'.$isize.'.png" alt="Facebook" /></a>';
    }
    else{ 
    $p[] = $params->get('counter1');
    $h[] = '<a id="l1" class="icons" target="_blank" '.$follower.' href="http://'.$fblink.'"><img title="Facebook" src="modules/mod_nice_social_bookmark/icons/facebook_'.$iset.'_'.$isize.'.png" alt="Facebook" /></a>';
    }
}

$tt = $params->get('s2', '1');
if ($tt == "1")
{ 
    if ($mslink == ""){
    $p[] = $params->get('counter2');
    $h[] = '<a id="l2" class="icons" target="_blank" '.$follower.' href="http://www.myspace.com/Modules/PostTo/Pages/?l=3&amp;u='.$url.'&amp;title='.$title.'"><img title="MySpace" src="modules/mod_nice_social_bookmark/icons/myspace_'.$iset.'_'.$isize.'.png" alt="MySpace" /></a>';
    }
    else{
    $p[] = $params->get('counter2');
    $h[] = '<a id="l2" class="icons" target="_blank" '.$follower.' href="http://'.$mslink.'"><img title="MySpace" src="modules/mod_nice_social_bookmark/icons/myspace_'.$iset.'_'.$isize.'.png" alt="MySpace" /></a>';
    }
}

$tt = $params->get('s3', '1');
if ($tt == "1")
{ 
    if ($twlink == ""){
    $p[] = $params->get('counter3');
    $h[] = '<a id="l3" class="icons" target="_blank" '.$follower.' href="http://twitter.com/home?status='.$url.'&amp;title='.$title.'"><img title="Twitter" src="modules/mod_nice_social_bookmark/icons/twitter_'.$iset.'_'.$isize.'.png" alt="Twitter" /></a>';
    }
    else{
    $p[] = $params->get('counter3');
    $h[] = '<a id="l3" class="icons" target="_blank" '.$follower.' href="http://'.$twlink.'"><img title="Twitter" src="modules/mod_nice_social_bookmark/icons/twitter_'.$iset.'_'.$isize.'.png" alt="Twitter" /></a>';
    }
}

$tt = $params->get('s4', '1');
if ($tt == "1")
{
    $p[] = $params->get('counter4');
    $h[] = '<a id="l4" class="icons" target="_blank" '.$follower.' href="http://digg.com/submit?phase=2&amp;url='.$url.'&amp;title='.$title.'"><img title="Digg" src="modules/mod_nice_social_bookmark/icons/digg_'.$iset.'_'.$isize.'.png" alt="Digg" /></a>';
}

$tt = $params->get('s5', '1');
if ($tt == "1")
{
    $p[] = $params->get('counter5');
    $h[] = '<a id="l5" class="icons" target="_blank" '.$follower.' href="http://del.icio.us/post?url='.$url.'&amp;title='.$title.'"><img title="Delicious" src="modules/mod_nice_social_bookmark/icons/delicious_'.$iset.'_'.$isize.'.png" alt="Delicious" /></a>';
}

$tt = $params->get('s6', '1');
if ($tt == "1")
{
    $p[] = $params->get('counter6');
    $h[] = '<a id="l6" class="icons" target="_blank" '.$follower.' href="http://www.stumbleupon.com/submit?url='.$url.'&amp;title='.$title.'"><img title="Stumbleupon" src="modules/mod_nice_social_bookmark/icons/stumbleupon_'.$iset.'_'.$isize.'.png" alt="Stumbleupon" /></a>';
}

$tt = $params->get('s7', '1');
if ($tt == "1")
{
    $p[] = $params->get('counter7');
    $h[] = '<a id="l7" class="icons" target="_blank" '.$follower.' href="http://www.google.com/bookmarks/mark?op=edit&amp;bkmk='.$url.'&amp;title='.$title.'"><img title="Google Bookmarks" src="modules/mod_nice_social_bookmark/icons/google_'.$iset.'_'.$isize.'.png" alt="Google Bookmarks" /></a>';
}

$tt = $params->get('s8', '1');
if ($tt == "1")
{
    $p[] = $params->get('counter8');
    $h[] = '<a id="l8" class="icons" target="_blank" '.$follower.' href="http://reddit.com/submit?url='.$url.'&amp;title='.$title.'"><img title="reddit" src="modules/mod_nice_social_bookmark/icons/reddit_'.$iset.'_'.$isize.'.png" alt="Reddit" /></a>';
}

$tt = $params->get('s9', '1');
if ($tt == "1")
{
    $p[] = $params->get('counter9');
    $h[] = '<a id="l9" class="icons" target="_blank" '.$follower.' href="http://www.newsvine.com/_tools/seed&amp;save?u='.$url.'&amp;h="><img title="newsvine" src="modules/mod_nice_social_bookmark/icons/newsvine_'.$iset.'_'.$isize.'.png" alt="Newsvine" /></a>';
}

$tt = $params->get('s100', '1');
if ($tt == "1")
{
    $p[] = $params->get('counter10');
    $h[] = '<a id="l10" class="icons" target="_blank" '.$follower.' href="http://technorati.com/faves?add='.$url.'&amp;title='.$title.'"><img title="technorati" src="modules/mod_nice_social_bookmark/icons/technorati_'.$iset.'_'.$isize.'.png" alt="Technorati" /></a>';
}

$tt = $params->get('s110', '1');
if ($tt == "1")
{
    if ($lilink == ""){
    $p[] = $params->get('counter11');
    $h[] = '<a id="l11" class="icons" target="_blank" '.$follower.' href="http://www.linkedin.com/shareArticle?mini=true&amp;url='.$url.'&amp;summary=%5B..%5D&amp;source="><img title="linkedin" src="modules/mod_nice_social_bookmark/icons/linkedin_'.$iset.'_'.$isize.'.png" alt="Linkedin" /></a>';
    }
    else{
    $p[] = $params->get('counter11');
    $h[] = '<a id="ll1" class="icons" target="_blank" '.$follower.' href="http://'.$lilink.'"><img title="LinkedIn" src="modules/mod_nice_social_bookmark/icons/linkedin_'.$iset.'_'.$isize.'.png" alt="LinkedIn" /></a>';
    }
}

$tt = $params->get('s14', '1');
if ($tt == "1")
{
    if ($rsslink == ""){
    $p[] = $params->get('counter12');
    $h[] = '<a id="l13" class="icons" target="_blank" '.$follower.' href="'.$rss_url.'/index.php?format=feed&amp;type=rss&amp;title='.$title.'"><img title="RSS Feed" src="modules/mod_nice_social_bookmark/icons/rss_'.$iset.'_'.$isize.'.png" alt="RSS Feed" /></a>';
    }
    else{
    $p[] = $params->get('counter12');
    $h[] = '<a id="l14" class="icons" target="_blank" '.$follower.' href="'.$rsslink.'"><img title="RSS Feed" src="modules/mod_nice_social_bookmark/icons/rss_'.$iset.'_'.$isize.'.png" alt="RSS Feed" /></a>';
    }
}

$tt = $params->get('s210', '1');
if ($tt == "1")
{
    $p[] = $params->get('counter13');
    $h[] = '<a id="l21" class="icons" target="_blank" '.$follower.' href="http://pinterest.com/'.$piname.'"><img title="Pinterest" src="modules/mod_nice_social_bookmark/icons/pinterest_'.$iset.'_'.$isize.'.png" alt="Pinterest" /></a>';
}

if($p)
{
    $out =  array_combine($p, $h);
    ksort($out);
    
    foreach($out as $x => $x_value) {
        echo $x_value;
    }
}

$tt = $params->get('s16', '1');
if ($tt == "1")echo '<a id="l16" class="icons" target="_blank" '.$follower.' href="'.$customlink1.'"><img title="" src="'.$customicon1.'" alt="'.$customalt1.'" /></a>';
$tt = $params->get('s17', '1');
if ($tt == "1")echo '<a id="l17" class="icons" target="_blank" '.$follower.' href="'.$customlink2.'"><img title="" src="'.$customicon2.'" alt="'.$customalt2.'" /></a>';
$tt = $params->get('s18', '1');
if ($tt == "1")echo '<a id="l18" class="icons" target="_blank" '.$follower.' href="'.$customlink3.'"><img title="" src="'.$customicon3.'" alt="'.$customalt3.'" /></a>';
$tt = $params->get('s19', '1');
if ($tt == "1")echo '<a id="l19" class="icons" target="_blank" '.$follower.' href="'.$customlink4.'"><img title="" src="'.$customicon4.'" alt="'.$customalt4.'" /></a>';
$tt = $params->get('s15', '1');
if ($tt == "1"){
?>
<script src="https://apis.google.com/js/platform.js"  async="async">{lang: '<?php echo $lang?>'}</script>
<div class="g-plusone" data-annotation="<?php echo $googlecount;?>" data-width="<?php echo $googlewidth?>"  data-size="<?php echo htmlspecialchars($size); ?>"  data-href="<?php echo htmlspecialchars($plusoneurl);?>"></div>
<?php
}
$tt = $params->get('s200', '1');
if ($tt == "1"){
  $psize = $params->get('psize');
    $pshape = $params->get('pshape');
    if (($psize == "small") && ($pshape == "rect"))
        {$psizer="20";}
    if (($psize == "small") && ($pshape == "round"))
        {$psizer="16";}
    if (($psize == "large") && ($pshape == "rect"))
        {$psizer="28";}
    if (($psize == "large") && ($pshape == "round"))
        {$psizer="32";}      
?>
<span class="pinit">
<a href="//www.pinterest.com/pin/create/button/?url=<?php echo $url;?>&amp;media=<?php echo $imagetobepinned;?>&amp;description=<?php echo $title;?>" data-pin-do="buttonPin" data-pin-config="<?php echo $porient;?>" data-pin-color="<?php echo $params->get('pcolor'); ?>" data-pin-shape="<?php echo $params->get('pshape'); ?>" data-pin-height="<?php echo $psizer;?>"><img title="Pin It" alt="Pin It" src="//assets.pinterest.com/images/pidgets/pinit_fg_en_<?php echo $params->get('pshape'); ?>_<?php echo $params->get('pcolor'); ?>_<?php echo $psizer;?>.png" /></a>
</span>
<!-- Please call pinit.js only once per page -->
<script type="text/javascript"  async defer src="//assets.pinterest.com/js/pinit.js"></script>
<?php
 }
$tt = $params->get('s23', '1');
if ($tt == "1"){
?>
<a href="https://twitter.com/share" class="twitter-share-button" data-text="<?php echo $tweettext;?>" data-count="<?php echo $tweetbtn;?>" data-size="<?php echo $tweetbtnsize;?>" data-lang="en">Tweet</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.async=true;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
<?php
 }
$tt = $params->get('s24', '1');
if ($tt == "1"){
?>
<a href="https://twitter.com/<?php echo $tweetname; ?>" class="twitter-follow-button" data-show-count="<?php echo $tweetfollowcount;?>" data-size="<?php echo $tweetflwsize;?>" data-lang="en">Follow @twitterapi</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.async=true;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
<?php
 }
$tt = $params->get('s26', '1');
if ($tt == "1"){
?>
<script src="//platform.linkedin.com/in.js" type="text/javascript"  async="async"></script>
<script type="IN/Share" data-url="<?php echo $linkedurl; ?>" data-counter="<?php echo $linkedcount; ?>"></script>
<?php
 }
$tt = $params->get('s27', '1');
if ($tt == "1"){
?>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.async=true;
  js.src = "//connect.facebook.net/<?php echo $params->get('facebooklang');?>/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
  <div class="fb-like" data-href="<?php echo $url;?>" data-width="<?php echo $params->get('facebookwidth');?>" data-layout="<?php echo $params->get('facebooklayout');?>" data-action="like"  data-show-faces="<?php echo $params->get('facebookfaces');?>" data-send="<?php echo $params->get('facebooksend');?>" data-colorscheme="<?php echo $params->get('facebookcolorscheme');?>" ></div>
<div id="fb-root"></div>
  <?php
}
echo '</div><div style="clear:both;"></div>';
?>