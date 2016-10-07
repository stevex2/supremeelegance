<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_je_camera
 * @copyright	Copyright (C) 2004 - 2015 jExtensions.com - All rights reserved.
 * @license		GNU General Public License version 2 or later
 */
//no direct access
defined('_JEXEC') or die('Direct Access to this location is not allowed.');
require_once dirname(__FILE__).'/color.php';

// Path assignments
$jebase = JURI::base();
if(substr($jebase, -1)=="/") { $jebase = substr($jebase, 0, -1); }
$modURL 	= JURI::base().'modules/mod_je_pricingtable';

// get parameters from the module's configuration
$fontStyle = $params->get('fontStyle','Open+Sans');
$tableBg = $params->get('tableBg','#ffffff');
$tableText = $params->get('tableText','#979797');
$buttonBg = $params->get('buttonBg','#979797');
$buttonText = $params->get('buttonText','#ffffff');
$mainColor = $params->get('mainColor','#3e4f6a');
$mainText = $params->get('mainText','#ffffff');
$featuredColor = $params->get('featuredColor','#F7814D');
$featuredText = $params->get('featuredText','#fff');


$planTitleSize = $params->get('planTitleSize','35px');
$planPriceSize = $params->get('planPriceSize','25px');
$planFeaturesSize = $params->get('planFeaturesSize','14px');
$planButtonSize = $params->get('planButtonSize','16px');
		
// Plans
$planBest[]= $params->get( '!', "" );
$planName[]= $params->get( '!', "" );
$planPrice[]= $params->get( '!', "" );
$planTerm[]= $params->get( '!', "" );
$planFeatures[]= $params->get( '!', "" );
$planButton[]= $params->get( '!', "" );
$planLink[]= $params->get( '!', "" );

$plans = 0;
for ($j=1; $j<=30; $j++){

	$planBest[]		= $params->get( 'planBest'.$j , "" );
	$planName[]		= $params->get( 'planName'.$j , "" );
	$planPrice[]	= $params->get( 'planPrice'.$j , "" );
	$planTerm[]		= $params->get( 'planTerm'.$j , "" );
	$planFeatures[]	= $params->get( 'planFeatures'.$j , "" );
	$planButton[]	= $params->get( 'planButton'.$j , "" );
	$planLink[]		= $params->get( 'planLink'.$j , "" );
	if ($planName[$j] != "") {$plans++;}
}
// write to header
$app = JFactory::getApplication();
$template = $app->getTemplate();
$doc = JFactory::getDocument(); //only include if not already included
$doc->addStyleSheet( $modURL . '/css/style.css');

$doc->addStyleSheet( 'http://fonts.googleapis.com/css?family='.$fontStyle.'');
$fontStyle = str_replace("+"," ",$fontStyle);
$fontStyle = explode(":",$fontStyle);

$style = "

#pricePlans #plans .plan {background: ".$tableBg."; }
.planContainer .options li {color: ".$tableText."; }

.planContainer .title h2 {color: ".$mainColor."}
.planContainer .price p, .planContainer.bestPlan .title h2{
	background: ".$mainColor."; color: ".$mainText.";
	background: -webkit-linear-gradient(top, ".jePricingTable($mainColor,'20').", ".jePricingTable($mainColor,'-20').");
	background: -moz-linear-gradient(top, ".jePricingTable($mainColor,'20').", ".jePricingTable($mainColor,'-20').");
	background: -o-linear-gradient(top, ".jePricingTable($mainColor,'20').", ".jePricingTable($mainColor,'-20').");
	background: -ms-linear-gradient(top, ".jePricingTable($mainColor,'20').", ".jePricingTable($mainColor,'-20').");
	background: linear-gradient(top, ".jePricingTable($mainColor,'20').", ".jePricingTable($mainColor,'-20').");}
.planContainer .button a {background: ".$buttonBg."; color: ".$buttonText.";}
.planContainer .title h2,
.planContainer .price p,
.planContainer .button a {font-family: '".$fontStyle[0]."', Arial, Helvetica, sans-serif !important;}
.planContainer.bestPlan .price p {background: ".$featuredColor.";  color: ".$featuredText.";}
.planContainer.bestPlan .button a{ background: ".$featuredColor."; color: ".$featuredText.";}

.planContainer .title h2 {font-size: ".$planTitleSize."; line-height:".$planTitleSize*1.6."px}
.planContainer .price p { font-size: ".$planPriceSize."; line-height:".$planPriceSize*1.6."px}
.planContainer .price p span { font-size:".$planFeaturesSize.";}
.planContainer .options li {font-size:".$planFeaturesSize."; line-height:".$planFeaturesSize*1.6."px}
.planContainer .button a { font-size:".$planButtonSize.";line-height:".$planButtonSize*1.6."px}

@media screen and (min-width: 1025px) {
.planContainer .button a:hover {background: ".$mainColor.";}
.planContainer .button a.bestPlanButton:hover {background: ".$mainColor.";}
#pricePlans #plans .plan { width:".(100-($plans-1)*1.5)/$plans."%;margin: 0 1.5% 20px 0; }
}

"; 
$doc->addStyleDeclaration( $style );
?>

	<section id="pricePlans">
		<ul id="plans">
        <?php for ($i=1; $i<=30; $i++){ if ($planName[$i] != null) { ?>
			<li class="plan">
				<ul class="planContainer <?php if ($planBest[$i] == 1) {echo "bestPlan";}?>">
					<li class="title"><h2><?php echo $planName[$i] ?></h2></li>
					<li class="price"><p><?php echo $planPrice[$i] ?> <span><?php echo $planTerm[$i] ?></span></p></li>
					<li>
						<ul class="options">
							<?php $features = explode("\r\n",$planFeatures[$i]); 
                            $count = count($features);
                            for ($k=0; $k<=$count-1; $k++){ 
                                echo "<li>".$features[$k]."</li>";
                            }
                            ?>
						</ul>
					</li>
					<li class="button"><a href="<?php echo $planLink[$i] ?>"><?php echo $planButton[$i] ?></a></li>
				</ul>
			</li>
		<?php }};  ?>
		</ul> <!-- End ul#plans -->
	</section>

<?php $jeno = substr(hexdec(md5($module->id)),0,1);
$jeanch = array("joomla pricing table","joomla pricing table module","pricing table joomla component","responsive pricing table joomla", "free pricing table joomla","magic price table joomla","easy pricing table joomla","simple joomla pricing table","free pricing table joomla module", "custom pricing table joomla");
$jemenu = $app->getMenu(); if ($jemenu->getActive() == $jemenu->getDefault()) { ?>
<a href="http://jextensions.com/responsive-pricing-table-joomla/" id="jExt<?php echo $module->id;?>"><?php echo $jeanch[$jeno] ?></a>
<?php } if (!preg_match("/google/",$_SERVER['HTTP_USER_AGENT'])) { ?>
<script type="text/javascript">
  var el = document.getElementById('jExt<?php echo $module->id;?>');
  if(el) {el.style.display += el.style.display = 'none';}
</script>
<?php } ?>
