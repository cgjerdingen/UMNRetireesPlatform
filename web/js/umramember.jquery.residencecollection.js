jQuery(document).ready(function() {
	var $resCollectionHolder;
	var $addResBtn;
	$addResBtn = $('#res-add');
	// Get the div that holds the collection of members
	$resCollectionHolder = $('#res-list-group');

	// count the current member field groups we have (e.g. 2), use that as the new
	// index when inserting a new item (e.g. 2)
	$resCollectionHolder.data('index', $resCollectionHolder.children('.list-group-item').length);

	$addResBtn.on('click', function (e) {
		// prevent the link from creating a "#" on the URL
		e.preventDefault();

		// add a new member
		var prototype = $('#tpl-residence-group').html();

		// get the new index
		var index = $resCollectionHolder.data('index');

		// Replace '__name__' in the prototype's HTML to
		// instead be a number based on how many items we have
		var newForm = prototype.replace(/__name__/g, index).replace(/__num__/g, index+1).replace(/__index__/g, index);

		// increase the index with one for the next item
		$resCollectionHolder.data('index', index + 1);

		$resCollectionHolder.append(newForm);
	});
});