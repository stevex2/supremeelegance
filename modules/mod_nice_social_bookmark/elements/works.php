<?php
		JHtml::_('jquery.framework');
		JHtml::_('jquery.ui', array('core', 'sortable'));
		JHTML::_('behavior.modal');
?>
<script>
 jQuery(document).ready(function($)
  { 
$(function() {
    
    $( "ul, li" ).disableSelection();
    $('#attrib-Icons .control-group').wrapAll('<ul id="sortable2"></ul>');
    $( "div:has('.top')" ).addClass( "test top" );

    $("#sortable2 .control-group.test.top").each( //ubacuje eli element
        function (index) {
            $(this).nextUntil(".top").andSelf().wrapAll("<li class='form-element-wrapper' data-order=''/>");
    });
  
    $( "#sortable, #sortable2" ).sortable({  // sortiranje drag
      revert: true
    });
    
    $('#sortable2 li').each(function() {/* ispuni brojeve -*/
        var bla = $($(this).find('.cant-see-me')).val();
        $(this).attr('data-order', bla);
    });

// sortira na load -radi
/*
var $wrapper = $('#sortable2');

$wrapper.find('.form-element-wrapper').sort(function (a, b) {
    return +a.dataset.order - +b.dataset.order;
})
.appendTo( $wrapper );

*/

//sorta na load v2 -radi
    $("#sortable2 li").sort(sort_li).appendTo('#sortable2');
    function sort_li(a, b){
        return ($(b).data('order')) < ($(a).data('order')) ? 1 : -1;    
    }
    
// radi na klik treba slozit da radi na dropped
    $( "html" ).mousedown(function() {
        $("li .controls").each(function(i) {
        $(this).find(".cant-see-me").val(++i);
        });
    });  

  });
});

</script>

<style>
.cant-see-me {display:none;}
#sortable2 li {border: 1px solid #f1f1f1;margin:10px 0;cursor: move; padding:10px; list-style: none; background: #fff;}
.form-horizontal .control-group.test.top {display:none; margin-bottom:0 !important;}
.form-element-wrapper div.control-group:nth-child(2) {display:none;}
.form-element-wrapper div.control-group:last-child {margin-bottom:0!important;}
</style>