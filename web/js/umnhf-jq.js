jQuery(document).ready(function($) {
	var searchForm = $('#umnhf-h-search'),
		searchButton = $('#umnhf-m-search');
	searchButton.toggle(function(){
		searchForm.addClass('mobile');
		searchButton.addClass('mobile').html('<span class="umnhf-m-cancel">&#x2715;</span> Cancel');
	}, function(){
		searchForm.removeClass('mobile');
		searchButton.removeClass('mobile').html('Search');
	});
});