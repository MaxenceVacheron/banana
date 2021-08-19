var MoodsAndArtistTypes = getMoodsAndArtistTypes();
allArtistsTypes = MoodsAndArtistTypes['artistTypes'];

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

			t_array.forEach(currArt => {
				console.log(artTypeLoop);
				console.log(currArt);

				html = '<br><div class="artistInput"><input type="text" id="' + currArt + '" name="artists[' + artTypeLoop + '][]" value="' + currArt + '" readonly="readonly">'
				html += '<select type="text" id="' + artTypeLoop + currArt + '" name="artistType" value="' + artTypeLoop + '">';

				tempArtDatalist = '<datalist id=allArtistTypes>';
				allArtistsTypes.forEach(element => {
					if (element != artTypeLoop) {
						tempArtDatalist += '<option disabled>' + element + '</option>';

					} else {
						tempArtDatalist += '<option selected>' + artTypeLoop + '</option>';

					}
				})
				tempArtDatalist += '</datalist>';
				html += tempArtDatalist;

				html += '</select></div>';
				artisDiv.innerHTML += (html);
				document.getElementById(artTypeLoop + currArt).selectedIndex = index;

			})


		} catch (error) {
			console.log('ERROR CAUGHT:');
			console.log('element not found is');
			//console.error(error);
			console.log(artTypeLoop);

			// expected output: ReferenceError: nonExistentFunction is not defined
			// Note - error messages will vary depending on browser
		}

	})
	// EDIT ALL MOOD SONG IF NECESSARY
	// allMoods.forEach((mood, index) => {
	// 	// console.log('Mood found:');
	// 	//console.log(mood);
	// 	html = '';
	// 	html += '<li><input type="checkbox" id="' + mood + '" name="mood[]" value="' + mood + '" class="moodSelector"><label for="' + mood + '">' + mood + '</label></li>';
	// 	document.getElementById('moodul').innerHTML += html;
	// })
	// songMoods = info[0]['moods'];
	// songMoods.forEach((songMood, index) => {
	// 	document.getElementById(songMood).checked = true;
	// })
	artisDiv.innerHTML += '<span onclick="addArtistField()">+</span>';

}

function addArtistField() {
	tempArtDatalist = '<datalist id=allArtistTypes>';
	allArtistsTypes.forEach(element => {
		tempArtDatalist += '<option>' + element + '</option>';
	})
	tempArtDatalist += '</datalist>';
	html = '<div class="artistInput"><input type="text" name="artists[CHANGEME][]" value="">'
	html += '<select type="text" name="artistType" value=""></div>';
	html += tempArtDatalist;
	html += '</select><span onclick="remArtistField(this)">  REMOVE</span>';
	artisDiv.innerHTML += (html);


}

function remArtistField(song) {
	var elem = song.parentElement;
	elem.remove();
}