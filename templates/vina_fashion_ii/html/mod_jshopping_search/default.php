<script type = "text/javascript">
function isEmptyValue(value){
    var pattern = /\S/;
    return ret = (pattern.test(value)) ? (true) : (false);
}
</script>
<?php 
	$image = JURI::base().'templates/vina_fashion_ii/images/search.png' ; 
	if($search == '') $placeholder = "placeholder='Search...'";
	else $placeholder = '';
?>
<form name = "searchForm" method = "post" action="<?php print SEFLink("index.php?option=com_jshopping&controller=search&task=result", 1);?>" onsubmit = "return isEmptyValue(jQuery('#jshop_search').val())">
<input type="hidden" name="setsearchdata" value="1">
<input type = "hidden" name = "category_id" value = "<?php print $category_id?>" />
<input type = "hidden" name = "search_type" value = "<?php print $search_type;?>" />
<div class="vina_search">
	<input type = "text" class = "inputbox" style = "width: 110px" name = "search" id = "jshop_search" <?php echo $placeholder; ?>  value = "<?php print $search?>" />
	<input class = "button" style="vertical-align: middle;" type = "image" value = "<?php print _JSHOP_GO?>" src="<?php print $image ?>" />
</div>
<?php if ($adv_search) {?>
<br /><a href = "<?php print $adv_search_link?>"><?php print _JSHOP_ADVANCED_SEARCH?></a>
<?php } ?>
</form>