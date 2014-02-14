(function () {
	var UMN_UTIL = {},
		mobileSearch = false;
	UMN_UTIL.hasClass = function (ele,cls) {
		return ele.className.match(new RegExp('(\\s|^)'+cls+'(\\s|$)'));
	};

	UMN_UTIL.addClass = function (ele,cls) {
		if (!UMN_UTIL.hasClass(ele,cls)) ele.className += " "+cls;
	};
	UMN_UTIL.removeClass = function (ele,cls) {
		if (UMN_UTIL.hasClass(ele,cls)) {
			var reg = new RegExp('(\\s|^)'+cls+'(\\s|$)');
			ele.className=ele.className.replace(reg,' ');
		}
	};
	/**
	 * Check every 100ms (.1s) for header's existance
	 * This will allow users to put JS in header or footer without needing
	 * bloated onload or $.ready code.
	 *
	 * @return int interval id
	 */
	var headerCheck = setInterval(function () {
		var umnhf = document.getElementById('umnhf-h'),
			searchForm = document.getElementById('umnhf-h-search'),
			searchButton = document.getElementById('umnhf-m-search');
		if (umnhf && searchButton) {
			clearInterval(headerCheck);
			//searchButton.setAttribute("href", "#");
			searchButton.onclick = function (event) {
				if (!mobileSearch) {
					UMN_UTIL.addClass(searchForm, 'mobile');
					UMN_UTIL.addClass(searchButton, 'mobile');
					searchButton.innerHTML = '<span class="umnhf-m-cancel">&#x2715;</span> Cancel';
					mobileSearch = true;
				} else {
					UMN_UTIL.removeClass(searchForm, 'mobile');
					UMN_UTIL.removeClass(searchButton, 'mobile');
					searchButton.innerHTML = 'Search';
					mobileSearch = false;
				}
				event.preventDefault();
				event.returnValue = false;
				return false;
			};
		}
	}, 100);

}());