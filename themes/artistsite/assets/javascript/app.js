function Menu() {
	var menuState = 0; // 0 for fully closed, 1 first stage open, 2 both sections open
	// when element buttonId is clicked, class toRemove is removed from elementId
	var removeClass = function (buttonId, elementId, toRemove) {
		$(buttonId).on('click', function() {
			$(elementId).removeClass(toRemove);
		});
	}

	// when element buttonId is clicked, class toAdd is added to elementId
	var addClass = function (buttonId, elementId, toAdd) {
		 $(buttonId).on('click', function() {
			 $(elementId).addClass(toAdd);
		 });
	}

	$('#menu-button').on('click', function() {
		if (menuState == 0) {
			$('#nav--main-list').removeClass('nav--main-list__close');
			$('#nav--main-list').addClass('nav--main-list__open');
			$('#menu-button').html("close");
			menuState = 1;
		} else {
			$('#nav--main-list').addClass('nav--main-list__close');
			$('#nav--main-list').removeClass('nav--main-list__open');
			$('#dropdown--content').addClass('dropdown--content__closed');
			$('#dropdown--content').removeClass('dropdown--content__open');
			$('#menu-button').html("menu");
			menuState = 0;
		}
	});
	$('#dropdown--button').on('click', function() {
		if (menuState == 1) {
			$('#dropdown--content').removeClass('dropdown--content__closed');
			$('#dropdown--content').addClass('dropdown--content__open');
			menuState = 2;
		} else {
			$('#dropdown--content').addClass('dropdown--content__closed');
			$('#dropdown--content').removeClass('dropdown--content__open');
			menuState = 1;
		}
	});

}

var myMenu = new Menu();
