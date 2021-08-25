var MoodsAndArtistTypes = getMoodsAndArtistTypes();
allArtistsTypes = MoodsAndArtistTypes['artistTypes'];
tempArtDatalist = '<datalist id=allArtistTypes>';
allArtistsTypes.forEach(element => {
	tempArtDatalist += '<option>' + element + '</option>';
});
tempArtDatalist += '</datalist>';


allArtists = MoodsAndArtistTypes['artists'];

AllArtDatalist = '<datalist id=allArtistsEver>';
allArtists.forEach(element => {
	AllArtDatalist += '<option>' + element + '</option>';
});
AllArtDatalist += '</datalist>';




allMoods = MoodsAndArtistTypes['moods'];

function editInfoConstructor() {

}



function getMoodsAndArtistTypes() {
	theUrl = 'http://' + location.hostname + '/info/relations';
	var xmlHttp = new XMLHttpRequest();
	xmlHttp.open("GET", theUrl, false); // false for synchronous request
	xmlHttp.send(null);
	return JSON.parse(xmlHttp.responseText);
}

function callAPI(songID) {
	theUrl = 'http://' + location.hostname + '/info/get?song=' + songID;
	var xmlHttp = new XMLHttpRequest();
	xmlHttp.open("GET", theUrl, false); // false for synchronous request
	xmlHttp.send(null);
	return JSON.parse(xmlHttp.responseText);
}

function getInfo(typeAndId) {


	info = (callAPI(song.id));
	document.getElementById('songID').value = info[0]['id'];
	document.getElementById('songName').value = info[0]['title'];
	document.getElementById('songYear').value = info[0]['year'];

	mainArtists = Array.from(info[0]['artists']['main']);

	allArtistsTypes = MoodsAndArtistTypes['artistTypes'];
	artisDiv = document.getElementById('artistInputContainer');
	artisDiv.innerHTML = '';

	allArtistsTypes.forEach((artTypeLoop, index) => {
		// allArtistsTypes.forEach(artTypeLoop => {
		// document.getElementById('songName').value = info[0]['title'];
		try {
			t_array = Array.from(info[0]['artists'][artTypeLoop]);

			allArtistInputs = '';
			
		// 	<div class="form__group field">
		// 	<input type="text" id="newMood" class="form__field" placeholder="Music" name="mood" value="Music" required>
		// 	<label for="newMood" class="form__label">Mood</label>
		// </div>

			t_array.forEach(currArt => {
				html = '<br><div class="artistInput form__group field"><input type="text" id="' + currArt + '"class="form__field" name="artists[' + artTypeLoop + '][]" value="' + currArt + '" readonly="readonly" list="allArtistsEver">'
				html += '<select type="text" id="' + artTypeLoop + currArt + '" name="artistType" value="' + artTypeLoop + '">';

				thisArtDatalist = '<datalist id=thisallArtistTypes>';
				allArtistsTypes.forEach(element => {
					if (element != artTypeLoop) {
						thisArtDatalist += '<option disabled>' + element + '</option>';
					} else {
						thisArtDatalist += '<option selected>' + artTypeLoop + '</option>';
					}
				})
				thisArtDatalist += '</datalist>';
				html += thisArtDatalist;

				html += '</select><span onclick="removeExistingArtist(this)"; style="color : white;">REMOVE</span></div>';
				artisDiv.innerHTML += (html);
				document.getElementById(artTypeLoop + currArt).selectedIndex = index;

			})


		} catch (error) {
			//console.error(error);

			// expected output: ReferenceError: nonExistentFunction is not defined
			// Note - error messages will vary depending on browser
		}

	})
	// EDIT ALL MOOD SONG IF NECESSARY
	// allMoods.forEach((mood, index) => {
	// 	html = '';
	// 	html += '<li><input type="checkbox" id="' + mood + '" name="mood[]" value="' + mood + '" class="moodSelector"><label for="' + mood + '">' + mood + '</label></li>';
	// 	document.getElementById('moodul').innerHTML += html;
	// })
	// songMoods = info[0]['moods'];
	// songMoods.forEach((songMood, index) => {
	// 	document.getElementById(songMood).checked = true;
	// })
	artisDiv.innerHTML += '<br><span onclick="addArtistField()" style="color:white">Add Field</span>';

}

function addArtistField() {
	html = '<div class="artistInput form__group field"><input type="text" name="artists[CHANGEME][]" class="form__field" value="" list="allArtistsEver">'
	html += AllArtDatalist;
	html += '<select type="text" name="artistType" value=""></div>';
	html += tempArtDatalist; // AT TOP OF FILE
	html += '</select><span onclick="remArtistField(this)" style="color:white"> REMOVE</span>';
	artisDiv.innerHTML += (html);
}

function remArtistField(song) {
	var elem = song.parentElement;
	elem.remove();
}

function removeExistingArtist(song) {
	var element = song.parentElement;
	var artistNameInput = element.querySelector("input");
	var newName = '';
	newName = artistNameInput.getAttribute('name');
	newName = newName.replace('artists', 'removeArtist');
	artistNameInput.setAttribute('name', newName);

	song.setAttribute('onclick', 'cancelRemoveExistingArtist(this)');
	element.style.opacity = 0.3;
}

function cancelRemoveExistingArtist(song) {
	var element = song.parentElement;

	var artistNameInput = element.querySelector("input");
	var newName = '';
	newName = artistNameInput.getAttribute('name');

	newName = newName.replace('removeArtist', 'artists');
	artistNameInput.setAttribute('name', newName);
	song.setAttribute('onclick', 'removeExistingArtist(this)');
	element.style.opacity = 1;

}