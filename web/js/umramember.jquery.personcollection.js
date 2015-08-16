jQuery(document).ready(function() {
	var $personCollectionHolder = $('#members-list-group');
	var $addPersonBtn = $('#person-add');

	$personCollectionHolder.on('click', '.btn-person-del', function (e) {
		e.preventDefault();

		$(this).parents('.list-group-item').remove();
	});

	// count the current member field groups we have (e.g. 2), use that as the new
	// index when inserting a new item (e.g. 2)
	$personCollectionHolder.data('index', $personCollectionHolder.children('.list-group-item').length);

	$addPersonBtn.on('click', function (e) {
		// prevent the link from creating a "#" on the URL
		e.preventDefault();

		// add a new member
		var prototype = $('#tpl-members-group').html();

		// get the new index
		var index = $personCollectionHolder.data('index');

		// Replace '__name__' in the prototype's HTML to
		// instead be a number based on how many items we have
		var newForm = prototype.replace(/__name__/g, index).replace(/__index__/g, index).replace(/__num__/g, index+1);

		// increase the index with one for the next item
		$personCollectionHolder.data('index', index + 1);

		$personCollectionHolder.append(newForm);
	});
});
