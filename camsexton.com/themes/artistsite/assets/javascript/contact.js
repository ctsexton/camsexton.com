var contactInfo = document.getElementById("contact-info");

function revealHTML (id, htmlString) {
	document.getElementById(id).addEventListener("click",
		function() {
			window.contactInfo.setAttribute("class", "contact-info__visible");
			window.contactInfo.innerHTML = htmlString;
		});
}

var webOption = `
		Include these to speed up the process:<br>
			<ul>
			<li> - photos (link to a folder of quality images)</li>
			<li> - text/bio information</li>
			<li> - your product... where can I see/hear/buy it?</li>
			<li> - summary of pages to include</li>
			<li> - links to other websites you love</li>
		</ul>`;
var audioOption = `
	Available for:<br>
	<ul>
		<li> - recording/mixing live shows</li>
		<li> - studio recordings</li>
		<li> - designing & programming software instruments</li>
	</ul>
	`;
var gigOption = `
	I play these instruments:<br>
	<ul>
		<li> - drums</li>
		<li> - controllers (grids, touchpads, etc.)</li>
	</ul>
	`;
var otherOption = `
	I also do things like:<br>
	<ul>
		<li> - teaching (drums, programming)</li>
		<li> - writing and arranging music</li>
	</ul>
`;

window.revealHTML("web", window.webOption);
window.revealHTML("audio", window.audioOption);
window.revealHTML("gig", window.gigOption);
window.revealHTML("other", window.otherOption);
