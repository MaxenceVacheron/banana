var MoodsAndArtistTypes = getMoodsAndArtistTypes();
	allArtistsTypes = MoodsAndArtistTypes['artistTypes'];
	tempArtDatalist = '<datalist id=allArtistTypes>';
	allArtistsTypes.forEach(element => {
		tempArtDatalist += '<option>' + element + '</option>';
	})
	tempArtDatalist += '</datalist>';
	allMoods = MoodsAndArtistTypes['moods'];

	
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

		// alert(allArtistsTypes);

		allArtistsTypes.forEach((artTypeLoop, index) => {
		// allArtistsTypes.forEach(artTypeLoop => {
			// document.getElementById('songName').value = info[0]['title'];
			try {	

				t_array = Array.from(info[0]['artists'][artTypeLoop]);
				console.log('index is' + index);

				t_array.forEach(currArt => {
					console.log(artTypeLoop);
					console.log(currArt);

					artisDiv = document.getElementById('artistInput');

					html = '<br><input type="text" id="'+ currArt +'" name="artists[' + artTypeLoop + '][]" value="'+ currArt +'">'
					html += '<select type="text" id="'+ artTypeLoop + currArt +'" name="artistType" value="' + artTypeLoop + '">';
					html += tempArtDatalist;
					console.log(html);
					// document.body.innerHTML += (html);
					artisDiv.innerHTML += (html);
					document.getElementById(artTypeLoop + currArt).selectedIndex = index;

					// document.getElementById('Drakeprod').setAttribute('value', 'Drakeprod');


				})
			} catch (error) {
				console.log('ERROR CAUGHT:');
				console.log('element not found is');
				console.log(artTypeLoop);

				console.error(error);
				// expected output: ReferenceError: nonExistentFunction is not defined
				// Note - error messages will vary depending on browser
			}
			
		})

		songMoods = info[0]['moods'];
		allMoods.forEach((mood,index ) => {
				console.log('Mood found:');
				console.log(mood);
				html = '';
				html +='<li><input type="checkbox" id="mood ' + index + '" name="mood[]" value="' + mood + '" class="moodSelector"><label for="mood ' + index + '">' + mood + '</label></li>';
				document.getElementById('moodul').innerHTML += html;
			} )

	}
	function addArtistField() {
html = '<br><input type="text" id="'+ currArt +'" name="artists[' + element + '][]" value="'+ currArt +'">'
					html += '<select type="text" name="artistType" value="' + element + '">';

	}

	function remArtistField(song) {
		var elem = song.parentElement;
		elem.remove();
	}
