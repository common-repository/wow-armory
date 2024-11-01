jQuery(document).ready(function() {
	jQuery('.wow_armory_options').each( function() {
		var rootDiv = this;
		var loadDiv = jQuery(rootDiv).find('.wa-load');
		var showDiv = jQuery(rootDiv).find('.wa-3DOnly');
		var modDiv = jQuery(rootDiv).find('.wa-model');
		jQuery(rootDiv).find('.wa-show3d').change(function() {
			if (jQuery(this).is(':checked')) {
				jQuery(showDiv).fadeIn('fast');
			} else {
				jQuery(showDiv).fadeOut('fast');
			}
		});
		jQuery(rootDiv).find('.wa-refresh').click(function () {
			jQuery(modDiv).fadeOut('fast');
			jQuery(loadDiv).fadeIn('fast');
			this.timer = setTimeout(function () {
				jQuery.ajax({
					url: 'functions.php',
					data: 'action=get' +
							'&cname=' + jQuery(rootDiv).find('.wa-cname').val() +
							'&realm=' + jQuery(rootDiv).find('.wa-realm').val() +
							'&realmtype=' + jQuery(rootDiv).find('.wa-realmtype').val() +
							'&hair=' + jQuery(rootDiv).find('.wa-hair').val() +
							'&haircolor=' + jQuery(rootDiv).find('.wa-haircolor').val() +
							'&face=' + jQuery(rootDiv).find('.wa-face').val() +
							'&skincolor=' + jQuery(rootDiv).find('.wa-skincolor').val() +
							'&facialhair=' + jQuery(rootDiv).find('.wa-facialhair').val() +
							'&facialcolor=' + jQuery(rootDiv).find('.wa-facialcolor').val(),
					dataType: 'json',
					type: 'post',
					cache: false,
					success: function(j) {
						if(j.ok) {
							jQuery(loadDiv).fadeOut('fast');
							jQuery(modDiv).html(j.msg).fadeIn('fast');
						}
					}
				});
			}, 200);
		});
	});
	strcount = window.location.href.indexOf("/wp-admin/");
	blogurl = window.location.href.substr(0, strcount);
	jQuery('.wa-realm').autocomplete(blogurl + "/wp-content/plugins/wow-armory/includes/getRealms.php", {minChars:2, matchSubset:1, matchContains:false, cacheLength:5, selectOnly:1, selectFirst:true});
});