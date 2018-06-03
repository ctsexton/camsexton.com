function ContactForm () {
	var prevOption = null;
	var optionState = 0;

	// reveals explanation text on page
	function revealHTML (buttonId, elementId, htmlString) {
		$(buttonId).on("click", function() {
			if (optionState === 0) {
				// open first text box
				console.log("clicked " + buttonId);
				$(elementId).addClass("opensecret");
				$(elementId).html(htmlString);
				$(buttonId).addClass("highlightButton");
				prevOption = buttonId;
				optionState = 1;
			} else if (optionState === 1 && prevOption !== buttonId) {
				// switch between explanation texts
				$(elementId).html(htmlString);
				$(prevOption).removeClass("highlightButton");
				$(buttonId).addClass("highlightButton");
				prevOption = buttonId;
			} else {
				// close all texts
				$(elementId).removeClass("opensecret");
				$(prevOption).removeClass("highlightButton");
				$(buttonId).removeClass("highlightButton");
				optionState = 0;
			}
		});
	}

	var Text = function (button, entry) {
		this.button = button;
		this.entry = entry;
	};

	var options = [

		new Text('#web', `
			Include these to speed up the process:<br>
				<ul>
				<li> - photos (link to a folder of quality images)</li>
				<li> - text/bio information</li>
				<li> - your product... where can I see/hear/buy it?</li>
				<li> - summary of pages to include</li>
				<li> - links to other websites you love</li>
			</ul>
			`
		),
		new Text('#audio', `
			Available for:<br>
			<ul>
				<li> - recording/mixing live shows</li>
				<li> - studio recordings</li>
				<li> - designing & programming software instruments</li>
			</ul>
			`
		),
		new Text('#gig', `
			I play these instruments:<br>
			<ul>
				<li> - drums</li>
				<li> - controllers (grids, touchpads, etc.)</li>
			</ul>
			`
		),
		new Text('#other', `
			I also do things like:<br>
			<ul>
				<li> - teaching (drums, programming)</li>
				<li> - writing and arranging music</li>
			</ul>
			`
		)
	];

	options.map(function(obj) {
		revealHTML(obj.button, '#option', obj.entry);
	});
}
myForm = new ContactForm();
