console.log('ho');

var docWidth = document.documentElement.offsetWidth;

[].forEach.call(
  document.querySelectorAll('*'),
  function(el) {
    if (el.offsetWidth > docWidth) {
      console.log(el);
    }
  }
);


window.addEventListener("load", function () {
	document.getElementById('theForm').addEventListener("submit", function (e) {
		e.preventDefault(); // before the code
		/* do what you want with the form */

		artists = document.getElementsByClassName('artistsInput');
		artists = Array.from(artists);

		artists.forEach(element => {
			// if (element.dataset.el.startsWith("mood-")) {
			// }
			var artistNameInput = element.querySelector("input");
			var artistTypeSelect = element.querySelector("select").value;

			var newName = '';
			newName = artistNameInput.getAttribute('name');
			newName = newName.replace('CHANGEME', artistTypeSelect);
			newName += '[]';

			artistNameInput.setAttribute('name', newName);

			console.log(element);
			console.log(newName);

		});
		// Should be triggered on form submit
		console.log('hi');
		document.getElementById('theForm').submit();

	})
});

function initPage() {
	console.log('Whassup? Import dem songs!!');
}

function addArtistField(song) {
	// console.log(song.parentElement);

	// Get the element
	var elem = song.parentElement;

	// Create a copy of it
	var clone = elem.cloneNode(true);

	clone.innerHTML += '<button onclick="remArtistField(this)" type="button" "="">-</button>';

	elem.after(clone);

}

function remArtistField(song) {
	var elem = song.parentElement;
	elem.remove();
}