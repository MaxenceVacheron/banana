var MoodsAndArtistTypes = getMoodsAndArtistTypes();
	allArtistsTypes = MoodsAndArtistTypes['artistTypes'];
	tempArtDatalist = '<datalist id=allArtistTypes>';
	allArtistsTypes.forEach(element => {
		tempArtDatalist += '<option>' + element + '</option>';
	})
	tempArtDatalist += '</datalist>';
	
window.addEventListener("load", function () {
		document.getElementById('infoCreateForm').addEventListener("submit", function (e) {
			e.preventDefault(); // before the code
			/* do what you want with the form */
			console.log('hey');
			artists = document.getElementsByClassName('artistInput');
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
			console.log('hi form is submited');
			document.getElementById('infoCreateForm').submit();

		})
	});


	function getMoodsAndArtistTypes() {
		theUrl = 'http://127.0.0.1:80/info/relations';
		var xmlHttp = new XMLHttpRequest();
		xmlHttp.open("GET", theUrl, false); // false for synchronous request
		xmlHttp.send(null);
		return JSON.parse(xmlHttp.responseText);
	}

	function callAPI(songID) {
		theUrl = 'http://127.0.0.1:80/info/get?song=' + songID;
		var xmlHttp = new XMLHttpRequest();
		xmlHttp.open("GET", theUrl, false); // false for synchronous request
		xmlHttp.send(null);
		return JSON.parse(xmlHttp.responseText);
	}

	function getInfo(typeAndId) {

		// var target = document.getElementById('addrowbutton')
		var songID = document.getElementById("inputsongid").value;

		info = (callAPI(songID));
		document.getElementById('songID').value = info[0]['id'];
		document.getElementById('songName').value = info[0]['title'];

		mainArtists = Array.from(info[0]['artists']['main']);

		allArtistsTypes = MoodsAndArtistTypes['artistTypes'];
		allMoods = MoodsAndArtistTypes['moods'];

		allArtistsTypes.forEach(element => {
			// document.getElementById('songName').value = info[0]['title'];
			try {
				t_array = Array.from(info[0]['artists'][element]);

				t_array.forEach(element2 => {
					console.log(element);
					console.log(element2);

					artisDiv = document.getElementById('artistInput');

					html = '<br><input type="text" id="'+ element2 +'" name="artists[' + element + '][] value="'+ element2 +'">'
					html += '<select type="text" name="artistType" value="' + element + '">';
					html += tempArtDatalist;
					console.log(html);
					// document.body.innerHTML += (html);
					artisDiv.innerHTML += (html);
					// document.getElementById('Drakeprod').setAttribute('value', 'Drakeprod');


				})
			} catch (error) {
				console.log('ERROR CAUGHT:');
				console.log('element not found is');
				console.log(element);
				console.error(error);
				// expected output: ReferenceError: nonExistentFunction is not defined
				// Note - error messages will vary depending on browser
			}



		})

	}
	function addArtistField(song) {
		// console.log(song.parentElement);

		// console.log(song);
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
