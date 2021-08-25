var queue_glbl;
var queue_current;
var nextPlaying;
var song;

// if ('serviceWorker' in navigator) {
// 	navigator.serviceWorker.register('/sw.js')
// 		.then(reg => console.log('service worker registered'))
// 		.catch(err => console.log('service worker not registered', err));
// }

function initPage() {
	var delayInMilliseconds = 50;

	setTimeout(function () {
		document.getElementById('playlistBuilder').classList.remove('hiddenWhileLoad');
		document.getElementById('queueContainer').classList.remove('hiddenWhileLoad');
		constructor();
	}, delayInMilliseconds);
}

function constructor() {
	const player = document.getElementById('player');
	const playerCurrentTitle = document.getElementById('currentTitle');
	const playerCurrentArtist = document.getElementById('currentArtist');
	const divs = document.querySelectorAll('.builderFilter');

	divs.forEach(el => el.addEventListener('click', event => {
		if (event.target.getAttribute('selected') === '2') {
			// event.target.className += (' selectedFilter');
			// event.target.classList.remove("doubleSelectedFilter");
			// event.target.setAttribute('selected', '1');
			event.target.classList.remove("selectedFilter");
			event.target.classList.remove("doubleSelectedFilter");
			event.target.setAttribute('selected', '0');
			buildQueueQuery(informPlaylistSize);
		} else if (event.target.getAttribute('selected') === '0') {
			event.target.className += (' selectedFilter');
			event.target.className += (' doubleSelectedFilter');
			event.target.setAttribute('selected', '2');
			buildQueueQuery(informPlaylistSize);
		}
		else {
			event.target.classList.remove("selectedFilter");
			event.target.classList.remove("doubleSelectedFilter");
			event.target.setAttribute('selected', '0');
			buildQueueQuery(informPlaylistSize);
		}



	}));

	const currSongMoodDiv = document.querySelectorAll('.currSongMoodUnq');

	currSongMoodDiv.forEach(el => el.addEventListener('click', event => {
		if (event.target.getAttribute('selected') === '0') {
			event.target.className += (' selectedCurrSongMood');
			event.target.setAttribute('selected', '1');
		} else {
			event.target.classList.remove("selectedCurrSongMood");
			event.target.setAttribute('selected', '0');
		}
	}));

	const playerCoverArt = document.getElementById('coverArt');
	playerCoverArt.addEventListener('dblclick', function (e) {
		openInfo();
		getInfo();
	});

	const SubmitInfoForm = document.getElementById('infoCreateForm');
	SubmitInfoForm.addEventListener("submit", function (e) {
		e.preventDefault(); // before the code
		/* do what you want with the form */
		artists = document.getElementsByClassName('artistInput');
		artists = Array.from(artists);
		artists.forEach(element => {
			var artistNameInput = element.querySelector("input");
			var artistTypeSelect = element.querySelector("select").value;
			var newName = '';
			newName = artistNameInput.getAttribute('name');
			newName = newName.replace('CHANGEME', artistTypeSelect);
			artistNameInput.setAttribute('name', newName);
		});
		// Should be triggered on form submit
		document.getElementById('infoCreateForm').submit();

	});

	setColorPalette();

	document.getElementById("moodFilterMainMenu").click();
	document.getElementById("music").click();

	document.addEventListener("keyup", function (event) {
		if (event.defaultPrevented) {
			return; // Do nothing if the event was already processed
		}

		switch (event.key) {
			// case "ArrowDown":
			// 	break;
			// case "ArrowUp":
			// 	break;
			// case "Left": previousSong(); // IE/Edge specific value
			// case "ArrowLeft": //Modern Browser
			// 	previousSong();
			// 	break;
			// case "Right": // IE/Edge specific value
			// 	nextSong();
			// 	break;
			// case "ArrowRight":
			// 	nextSong();
			// 	break;
			case "k":
				document.getElementById("playPauseButton").click();
				break;
			case "l":
				nextSong();
				break;
			case "j":
				previousSong();
				break;

			default:
				return; // Quit when this doesn't handle the key event.
		}

		// Cancel the default action to avoid it being handled twice
		event.preventDefault();
	}, true);

	$("<iframe name='infoCreateIframe' id='infoCreateIframe' />").appendTo(document.getElementById('infoCreateForm'));
	$("form").attr("target", "infoCreateIframe");

	// $('.builderToggleContainer').on('swipedown',hideShowPlaylistBuilder() );
	// $('.queueToggleContainer').on('swipeup',hideShowQueueContainer() );

}

function getMoodsAndArtistTypes() {
	theUrl = 'http://' + location.hostname + '/info/relations';
	var xmlHttp = new XMLHttpRequest();
	xmlHttp.open("GET", theUrl, false); // false for synchronous request
	xmlHttp.send(null);
	return JSON.parse(xmlHttp.responseText);
}

function humanReadable(string) {
	string = decodeURI(string);
	string = string.replace('%26', '&');
	string = string.replace('%20', ' ');
	string = string.replace('+', ' ');

	return string;
}

function openCity(cityName) {
	var i,
		tabcontent,
		tablinks;
	tabcontent = document.getElementsByClassName("tabcontent");
	for (i = 0; i < tabcontent.length; i++) {
		tabcontent[i].style.display = "none";
	}
	tablinks = document.getElementsByClassName("tablinks");
	for (i = 0; i < tablinks.length; i++) {
		tablinks[i].className = tablinks[i].className.replace(" active", "");
	}
	document.getElementById(cityName + 'Tab').style.display = "flex";
	document.getElementById(cityName + 'Menu').className += " active";
}

function hideShowPlaylistBuilder() {
	playlistBuilder = document.getElementsByClassName('playlistBuilder')[0];
	if (playlistBuilder.getAttribute('selected') == '1') {
		playlistBuilder.className += (' playlistBuilderHidden');
		playlistBuilder.setAttribute('selected', '0');
	} else {
		playlistBuilder.classList.remove('playlistBuilderHidden');
		playlistBuilder.setAttribute('selected', '1');
	}

}

function hideShowQueueContainer() {
	queueContainer = document.getElementsByClassName('queueContainer')[0];
	if (queueContainer.getAttribute('selected') == '1') {
		queueContainer.className += (' queueContainerHidden');
		queueContainer.setAttribute('selected', '0');
	} else {
		queueContainer.classList.remove('queueContainerHidden');
		queueContainer.setAttribute('selected', '1');
	}

}

// based on Todd Motto functions
// https://toddmotto.com/labs/reusable-js/

// hasClass
function hasClass(elem, className) {
	return new RegExp(' ' + className + ' ').test(' ' + elem.className + ' ');
}
// addClass
function addClass(elem, className) {
	if (!hasClass(elem, className)) {
		elem.className += ' ' + className;
	}
}
// removeClass
function removeClass(elem, className) {
	var newClass = ' ' + elem.className.replace(/[\t\r\n]/g, ' ') + ' ';
	if (hasClass(elem, className)) {
		while (newClass.indexOf(' ' + className + ' ') >= 0) {
			newClass = newClass.replace(' ' + className + ' ', ' ');
		}
		elem.className = newClass.replace(/^\s+|\s+$/g, '');
	}
}
// toggleClass
function toggleClass(elem, className) {
	var newClass = ' ' + elem.className.replace(/[\t\r\n]/g, " ") + ' ';
	if (hasClass(elem, className)) {
		while (newClass.indexOf(" " + className + " ") >= 0) {
			newClass = newClass.replace(" " + className + " ", " ");
		}
		elem.className = newClass.replace(/^\s+|\s+$/g, '');
	} else {
		elem.className += ' ' + className;
	}
}

var theToggle = document.getElementsByClassName('toggle');

theToggle.onclick = function () {
	toggleClass(this, 'on');

	playlistBuilder = document.getElementsByClassName('playlistBuilder')[0];
	if (playlistBuilder.getAttribute('selected') == '0') {
		playlistBuilder.classList.remove('playlistBuilderHidden');
		playlistBuilder.setAttribute('selected', '1');
	} else {
		playlistBuilder.className += (' playlistBuilderHidden');
		playlistBuilder.setAttribute('selected', '0');
	}

	return false;
}


function buildQueueQuery(callback) {
	moodQueue = '';
	artistQueue = '';
	albumQueue = '';
	yearQueue = '';

	filters = document.getElementsByClassName('selectedFilter');

	filters = Array.from(filters);

	filters.forEach(element => {
		if (element.dataset.el.startsWith("mood-")) {
			element = element.dataset.el.substring(5);
			element = element.replace(/\s/g, '+');
			element = element.replace(/[&]/g, '%26');
			moodQueue += '&mood%5B%5D=';
			moodQueue += element;
		} else if (element.dataset.el.startsWith("artist-")) {
			element = element.dataset.el.substring(7);
			element = element.replace(/\s/g, '+');
			element = element.replace(/[&]/g, '%26');
			artistQueue += '&artist%5B%5D=';
			artistQueue += element;
		} else if (element.dataset.el.startsWith("album-")) {
			element = element.dataset.el.substring(6);
			element = element.replace(/\s/g, '+');
			element = element.replace(/[&]/g, '%26');
			albumQueue += '&album%5B%5D=';
			albumQueue += element;
		} else if (element.dataset.el.startsWith("year-")) {
			element = element.dataset.el.substring(5);
			element = element.replace(/\s/g, '+');
			element = element.replace(/[&]/g, '%26');
			yearQueue += '&year%5B%5D=';
			yearQueue += element;
		} else {
			alert('Tag not recognized!');
		}

	});

	hardFilters = '';
	hardMoodQueue = '';
	hardArtistQueue = '';
	hardAlbumQueue = '';
	hardYearQueue = '';

	hardFilters = document.getElementsByClassName('doubleSelectedFilter');

	hardFilters = Array.from(hardFilters);

	hardFilters.forEach(element => {
		if (element.dataset.el.startsWith("mood-")) {
			element = element.dataset.el.substring(5);
			element = element.replace(/\s/g, '+');
			element = element.replace(/[&]/g, '%26');
			hardMoodQueue += '&hardMood%5B%5D=';
			hardMoodQueue += element;
		} else if (element.dataset.el.startsWith("artist-")) {
			element = element.dataset.el.substring(7);
			element = element.replace(/\s/g, '+');
			element = element.replace(/[&]/g, '%26');
			hardArtistQueue += '&hardArtist%5B%5D=';
			hardArtistQueue += element;
		} else if (element.dataset.el.startsWith("album-")) {
			element = element.dataset.el.substring(6);
			element = element.replace(/\s/g, '+');
			element = element.replace(/[&]/g, '%26');
			hardAlbumQueue += '&hardAlbum%5B%5D=';
			hardAlbumQueue += element;
		} else if (element.dataset.el.startsWith("year-")) {
			element = element.dataset.el.substring(5);
			element = element.replace(/\s/g, '+');
			element = element.replace(/[&]/g, '%26');
			hardYearQueue += '&hardYear%5B%5D=';
			hardYearQueue += element;
		} else {
			alert('Tag not recognized!');
		}
	});

	queueQuery = 'player/queue?' + moodQueue + artistQueue + albumQueue + yearQueue + hardMoodQueue + hardArtistQueue + hardAlbumQueue + hardYearQueue;
	console.log(queueQuery);
	getQueueAndDo(queueQuery, callback);
	// getQueueAndDo(queueQuery, playQueue);

}

function getQueueAndDo(theUrl, callback) {

	var xmlHttp = new XMLHttpRequest();
	xmlHttp.onreadystatechange = function () {
		if (xmlHttp.readyState == 4 && xmlHttp.status == 200)
			callback(xmlHttp.responseText);
	}
	xmlHttp.open("GET", theUrl, true); // true for asynchronous 
	xmlHttp.send(null);
}

function informPlaylistSize(array) {

	array = JSON.parse(array);
	size = Object.keys(array).length;
	document.getElementById('playlistSize').innerHTML = array.length;
}

function playQueue(jsonQueue) {
	jsonQueue = JSON.parse(jsonQueue);
	queue_glbl = jsonQueue;
	console.log(jsonQueue);


	queueCont = document.getElementById('queueContainerContent');

	html = '';

	jsonQueue.forEach((obj, index) => {
		html += '<div onclick="playSong(' + index + ')" data-q="' + index + '" playing="0" class="queue_song"><div class="queue_song_covert" >&loz;  </div><div class="queue_song_text_info"><div class="queue_song_artist" >' + obj['artists']['main'] + '</div><div class="queue_song_title">' + obj['title'] + '</div></div><div class="handle" >☰</div></div>'

	});

	queueCont.innerHTML = html;

	new Sortable(queueContainerContent, {
		handle: '.handle',
		animation: 150,
		ghostClass: 'sortable-ghost'
	});


	// startOverQueue();
	playSong(0);


}

function playSong(Q_ID) {


	// Condition met when first song is played on the page
	if ((document.querySelectorAll('.playingSong') === undefined || document.querySelectorAll('.playingSong').length == 0)) {
		// startOverQueue();
		Q_ID = document.querySelectorAll('#queueContainerContent')[0].firstChild.getAttribute('data-q');
		// return; // document.querySelectorAll('#queueContainerContent > div:nth-child('+ queue_current_upped + ')')[0].classList.remove('playingSong');
	} else {
		document.querySelectorAll('.playingSong')[0].classList.remove('playingSong');
		// 
	}
	song = queue_glbl[Q_ID];

	audioPlayer = document.getElementById('audioPlayer');
	audioPlayer.setAttribute("src", song.path);



	jsmediatags.read("http://" + location.hostname + "/" + song.path, {
		onSuccess: function (tag) {
			var tags = tag.tags;

			var image = tags.picture;
			if (image) {
				var base64String = "";
				for (var i = 0; i < image.data.length; i++) {
					base64String += String.fromCharCode(image.data[i]);
				}
				var base64 = "data:image/jpeg;base64," +
					// window.btoa(base64String);
					btoa(base64String);
				document.getElementById('coverArt').setAttribute('src', base64);

				setTimeout(function () {
					// setColorPalette();
				}, 50);

			} else {
				document.getElementById('coverArt').setAttribute('src', '/favicon.ico');
			}
		}
	});

	playerCurrentTitle.innerHTML = song.title;

	document.title = song.artists.main + ' - ' + song.title;

	if (song.artists.featuring) {
		if (song.artists.featuring.length == 1) {
			playerCurrentTitle.innerHTML += ' feat. ' + song.artists.featuring;
		} else {
			playerCurrentTitle.innerHTML += ' feat. ' + song.artists.featuring[0];
			for (let i = 1; i < song.artists.featuring.length; i++) {
				playerCurrentTitle.innerHTML += ' & ' + song.artists.featuring[i];
			}
		}
	}

	if (song.artists.prod) {
		playerCurrentTitle.innerHTML += ' (Prod. ' + song.artists.prod + ')';
	}
	// playerCurrentArtist.innerHTML = song.artists.main;
	// if (song.artists.main) {
	if (song.artists.main.length == 1) {
		playerCurrentArtist.innerHTML = song.artists.main;
	} else {
		playerCurrentArtist.innerHTML = song.artists.main[0];
		for (let i = 1; i < song.artists.main.length; i++) {
			playerCurrentArtist.innerHTML += ' & ' + song.artists.main[i];
		}
	}

	var currentlyPlaying = document.querySelectorAll('[data-q="' + Q_ID + '"]')[0];
	currentlyPlaying.className += (' playingSong');

	queue_current = Q_ID;

	currentSongMoodsArray = song.moods;

	allcurrSongMoodUnq = Array.from(document.getElementsByClassName('currSongMoodUnq'));
	allcurrSongMoodUnq.forEach(el => {
		el.classList.remove("selectedCurrSongMood");
		el.setAttribute('selected', '0');
	})
	currentSongMoodsArray.forEach(el => {
		target = document.getElementById('currSong-' + el);
		target.className += (' selectedCurrSongMood');
		target.setAttribute('selected', '1');

	})




	playAudio();
	console.log(song);


	audioPlayer.addEventListener('ended', (event) => {
		nextSong();
	});

}

function nextSong() {
	//Saving changes locally
	song.moods = [];
	allcurrSongMoodUnq = Array.from(document.getElementsByClassName('currSongMoodUnq'));
	allcurrSongMoodUnq.forEach(elm => {
		// elm.style.backgroundColor = 'var(--accentColor)';
		// elm.style.color = 'var(--accentColorFontInversed)';
		// el.classList.remove("selectedCurrSongMood");
		if (elm.getAttribute('selected') == '1') {
			song.moods.push(elm.dataset.el.substring(5));
		}
	})


	var currentlyPlaying = document.querySelectorAll('.playingSong')[0];

	if (currentlyPlaying.nextSibling != null) {
		playSong(currentlyPlaying.nextSibling.getAttribute('data-q'));
	} else {
		document.querySelectorAll('.playingSong')[0].classList.remove('playingSong');
		// startOverQueue();
		playSong();
	}
}

function previousSong() {
	song.moods = [];
	allcurrSongMoodUnq = Array.from(document.getElementsByClassName('currSongMoodUnq'));
	allcurrSongMoodUnq.forEach(elm => {
		// el.classList.remove("selectedCurrSongMood");
		if (elm.getAttribute('selected') == '1') {
			song.moods.push(elm.dataset.el.substring(5));
		}
	})

	var currentlyPlaying = document.querySelectorAll('.playingSong')[0];

	if (currentlyPlaying.previousSibling != null) {
		playSong(currentlyPlaying.previousSibling.getAttribute('data-q'));
	} else {
		document.querySelectorAll('.playingSong')[0].classList.remove('playingSong');
		playSong();
	}
}

function playAudio() {
	audioPlayer = document.getElementById('audioPlayer');
	audioPlayer.play();

	playPauseButton = document.getElementById('playPauseButton');
	playPauseButton.setAttribute("onClick", "javascript : pauseAudio();");

	addClass(document.getElementById('playPauseButton'), 'playing');
}

function pauseAudio() {
	// removeClass(document.getElementById('playPauseButton'), 'playing');

	audioPlayer = document.getElementById('audioPlayer');
	audioPlayer.pause();

	playPauseButton = document.getElementById('playPauseButton');
	// playPauseButton.innerHTML = "Play";
	playPauseButton.setAttribute("onClick", "javascript: playAudio();");
	removeClass(document.getElementById('playPauseButton'), 'playing');

}

function openInfo() {

	document.getElementById('editInfoContainer').style.display = 'block';
	document.getElementById('modalExtBackground').style.display = 'block';
}

function closeInfo() {
	document.getElementById('editInfoContainer').style.display = 'none';
	document.getElementById('modalExtBackground').style.display = 'none';
	// alert('Info PopupClosed');

}

function getRandomInt(max) {
	return Math.floor(Math.random() * max);
}

function updateMood(currSongMoodUpdatedAppended) {

	// alert(song.id);
	previousSeletecState = currSongMoodUpdatedAppended.getAttribute('selected');


	if (previousSeletecState == '0') {
		// alert(currSongMoodUpdated.getAttribute("data-el"));
		currSongMoodUpdated = currSongMoodUpdatedAppended.dataset.el.substring(5);
		currSongMoodUpdatedClean = currSongMoodUpdated.replace(/\s/g, '+');
		currSongMoodUpdatedClean = currSongMoodUpdated.replace(/[&]/g, '%26');
		request = '/info/link/mood?';
		request += 'id=' + song.id + '&mood=' + currSongMoodUpdated;

		const xhttp = new XMLHttpRequest();
		xhttp.onload = function () {
			console.log(this.responseText);
		}

		xhttp.open("GET", request);
		xhttp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

		xhttp.send();

		indexOfClrArray = getRandomInt(12);
		currSongMoodUpdatedAppended.style.backgroundColor = rgbCol[indexOfClrArray % rgbCol.length];
		currSongMoodUpdatedAppended.style.border = '1px solid' + getContrastColor(rgbCol[indexOfClrArray % rgbCol.length]);
		currSongMoodUpdatedAppended.style.color = getContrastColor(rgbCol[indexOfClrArray % rgbCol.length]);

	} else {
		currSongMoodUpdatedAppended.style.backgroundColor = 'var(--accentColor)';
		currSongMoodUpdatedAppended.style.color = 'var(--accentColorFontInversed)';
		currSongMoodUpdatedAppended.style.border = '';

		currSongMoodUpdated = currSongMoodUpdatedAppended.dataset.el.substring(5);
		currSongMoodUpdatedClean = currSongMoodUpdated.replace(/\s/g, '+');
		currSongMoodUpdatedClean = currSongMoodUpdated.replace(/[&]/g, '%26');
		request = '/info/unlink/mood?';
		request += 'id=' + song.id + '&mood=' + currSongMoodUpdated;

		const xhttp = new XMLHttpRequest();
		xhttp.onload = function () {
			//   document.getElementById("demo").innerHTML =
			//   this.responseText;
			console.log(this.responseText);
		}

		xhttp.open("GET", request);
		xhttp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

		xhttp.send();
	}
}

function setColorPalette() {
	console.log('Getting color palette...');
	const colorThief = new ColorThief();
	const img = document.getElementById('coverArt');

	const swatches = 12;

	const palette = document.querySelector('.palette');
	const image = document.querySelector('#coverArt');
	const input = document.querySelector('[type="file"]');

	image.onchange = e => {
		image.src = URL.createObjectURL(input.files[0])
	}

	image.onload = () => {
		URL.revokeObjectURL(image.src);
		const colors = colorThief.getPalette(image, swatches);
		while (palette.firstChild) palette.removeChild(palette.firstChild);

		forThisColorsShouldFontBeWhat = [];
		colors.forEach((clr, index) => {
			r = clr[0];
			g = clr[1];
			b = clr[2];
			forThisColorsShouldFontBeWhat.push(getContrastColor(r, g, b, '1'));

		})



		colors.reduce((palette, rgb) => {
			const color = `rgb(${rgb[0]}, ${rgb[1]}, ${rgb[2]})`;
			const swatch = document.createElement('div');
			swatch.style.setProperty('--color', color);
			swatch.setAttribute('color', color);
			palette.appendChild(swatch);
			return palette;
		}, palette)


		rgbCol = [];
		colorDiv = document.querySelectorAll('.palette > div');
		colorDiv = Array.from(colorDiv);
		colorDiv.forEach(el => {
			rgbCol.push(el.getAttribute('color'));

		});
		allcurrSongMoodUnq = Array.from(document.getElementsByClassName('currSongMoodUnq'));
		allcurrSongMoodUnq.forEach(elm => {
			elm.style.backgroundColor = 'var(--accentColor)';
			elm.style.color = 'var(--accentColorFontInversed)';
			elm.style.border = '';

		})

		allcurrSongMoodUnqSelected = Array.from(document.getElementsByClassName('selectedCurrSongMood'));
		allcurrSongMoodUnqSelected.forEach(elm => {
			indexOfClrArray = getRandomInt(12);
			color = rgbCol[indexOfClrArray % rgbCol.length];
			rgbColorArray = color.split("(")[1].split(")")[0].split(",");
			elm.style.backgroundColor = color;
			elm.style.border = '2px solid ' + getContrastColor(rgbColorArray, 1);
			elm.style.color = getContrastColor(rgbCol[indexOfClrArray % rgbCol.length]);
		})

		// currSongMoodUpdatedAppended.style.backgroundColor = rgbCol[getRandomInt(10) % rgbCol.length];

		let root = document.documentElement;



		color = colorThief.getColor(img);

		colorFontColor = getContrastColor(color[0], color[1], color[2], '1');
		inversedOfColorFontColor = returnBlackForWhiteAndWhiteForblack(colorFontColor);
		root.style.setProperty('--accentColor', 'rgb(' + color + ')');
		root.style.setProperty('--accentColorFont', colorFontColor);
		root.style.setProperty('--accentColorFontInversed', inversedOfColorFontColor);

	}
}
function getRGB(str) {
	var match = str.match(/rgba?\((\d{1,3}), ?(\d{1,3}), ?(\d{1,3})\)?(?:, ?(\d(?:\.\d?))\))?/);
	return match ? {
		red: match[1],
		green: match[2],
		blue: match[3]
	} : {};
}

function getContrastColor(R, G, B, A) {
	const brightness = R * 0.299 + G * 0.587 + B * 0.114 + (1 - A) * 255;

	return brightness > 106 ? "#000000" : "#FFFFFF";
}

function returnBlackForWhiteAndWhiteForblack(whiteorblack) {
	if (whiteorblack == '#000000') {
		// return "#949494"; //white
		return "#000000"; //white
	} else {
		// return "#949494"; //bLACK
		return "#FFFFFF"; //bLACK
	}
}