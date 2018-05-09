var globvarA = 0;
document.getElementById("cts-menuButton").addEventListener("click", 
	function() {
		console.log("click!");
		console.log(window.globvarA);
		if (window.globvarA == 1) {
			document.getElementById("cts-navbar__main-list").setAttribute("class", "cts-navbar__main-list--closeSubMenu");	
			setTimeout(function() {

				document.getElementById("cts-navbar__main-list").setAttribute("class", "cts-navbar__main-list--up");
				document.getElementById("cts-menuButton").innerHTML = "menu";	
			}, 10);
			window.globvarA = 0;
			window.globvarB = 0;
		} else {
		document.getElementById("cts-navbar__main-list").setAttribute("class", "cts-navbar__main-list--down");	
		document.getElementById("cts-menuButton").innerHTML = "close";	
			window.globvarA = 1;
		}
	}
);

var globvarB = 0;
document.getElementById("dropdown-button").addEventListener("click", 
	function() {
		console.log("click?");
		console.log(window.globvarB);
		if (window.globvarB == 1) {
			document.getElementById("cts-navbar__main-list").setAttribute("class", "cts-navbar__main-list--closeSubMenu");	
			window.globvarB = 0;
		} else {
			document.getElementById("cts-navbar__main-list").setAttribute("class", "cts-navbar__main-list--closeSubMenu");	
			setTimeout(function() {
			document.getElementById("cts-navbar__main-list").setAttribute("class", "cts-navbar__main-list--openFully");	
			}, 10);
			window.globvarB = 1;
		}
	}
);
