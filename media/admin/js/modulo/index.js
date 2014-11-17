jQuery(document).ready(function(){	
    jQuery("#permissao-dialog").dialog({autoOpen: false}); //pop up dialog window on pageopen.
	jQuery(".permissao").click(function() {
		jQuery("#permissao-dialog").dialog('close');
		jQuery("body").css("cursor", "progress");
		jQuery.get(this.href, function(data) {
			jQuery("#permissao-dialog").empty().html(data);
			jQuery("#permissao-dialog").dialog('open');
			jQuery("body").css("cursor", "auto");
		});
		return false;
	});
});
