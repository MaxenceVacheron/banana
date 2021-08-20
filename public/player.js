var queue_glbl;
var queue_current;
var nextPlaying;
var song;

// if ('serviceWorker' in navigator) {
// 	navigator.serviceWorker.register('/sw.js')
// 		.then(reg => console.log('service worker registered'))
// 		.catch(err => console.log('service worker not registered', err));
// }


function test(hey) {
	console.log(hey);
}

function initPage() {
	var delayInMilliseconds = 100;

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


	// divs.forEach(el => el.innerHTML = humanReadable(el.innerHTML));

	divs.forEach(el => el.addEventListener('click', event => {
		console.log(event.target.getAttribute("data-el"));
		if (event.target.getAttribute('selected') === '0') {
			event.target.className += (' selectedFilter');
			event.target.setAttribute('selected', '1');
		} else {
			event.target.classList.remove("selectedFilter");
			event.target.setAttribute('selected', '0');
		}
	}));

	const currSongMoodDiv = document.querySelectorAll('.currSongMoodUnq');

	currSongMoodDiv.forEach(el => el.addEventListener('click', event => {
		console.log(event.target.getAttribute("data-el"));
		if (event.target.getAttribute('selected') === '0') {
			event.target.className += (' selectedCurrSongMood');
			event.target.setAttribute('selected', '1');
		} else {
			event.target.classList.remove("selectedCurrSongMood");
			event.target.setAttribute('selected', '0');
		}
	}));

	console.log('Form submit will be intercepted.');

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
			console.log('old name was' + newName);
			newName = newName.replace('CHANGEME', artistTypeSelect);
			artistNameInput.setAttribute('name', newName);
		});
		// Should be triggered on form submit
		console.log('hi form is submited');
		document.getElementById('infoCreateForm').submit();

	});

	// const playButton = document.getElementById('playPauseButton');

	// playButton.addEventListener('click', event => {
	// 	toggleClass(playButton, 'paused');
	// })

}

function humanReadable(string) {
	string = decodeURI(string);
	string = string.replace('%26', '&');
	string = string.replace('%20', ' ');
	string = string.replace('+', ' ');

	return string;
}

function openCity(evt, cityName) {
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
	document.getElementById(cityName).style.display = "flex";
	evt.currentTarget.className += " active";
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

function buildQueueQuery() {
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
			ieleemt = element.replace(/\s/g, '+');
			element = element.replace(/[&]/g, '%26');
			yearQueue += '&year%5B%5D=';
			yearQueue += element;
		} else {
			alert('Tag not recognized!');
		}

	});

	queueQuery = 'player/queue?' + moodQueue + artistQueue + albumQueue + yearQueue;
	console.log(queueQuery);
	getQueueAndDo(queueQuery, playQueue);

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

function playQueue(jsonQueue) {
	jsonQueue = JSON.parse(jsonQueue);
	queue_glbl = jsonQueue;
	console.log(jsonQueue);


	queueCont = document.getElementById('queueContainerContent');

	html = '';

	jsonQueue.forEach((obj, index) => {
		// {# Object.entries(obj).forEach(([key, value]) => {
		// 	console.log(`${key} ${value}`);
		// }); #})

		// html += '<div data-q="' + index + '" playing="0" class="queue_song"><div class="queue_song_covert" data-q="' + index + '">&loz;  </div><div class="queue_song_artist" data-q="' + index + '">' + obj['artists'] + '</div><div class="queue_song_title" data-q="' + index + '">' + obj['title'] + '</div></div>'
		html += '<div onclick="playSong(' + index + ')" data-q="' + index + '" playing="0" class="queue_song"><div class="queue_song_covert" >&loz;  </div><div class="queue_song_text_info"><div class="queue_song_artist" >' + obj['artists']['main'] + '</div><div class="queue_song_title">' + obj['title'] + '</div></div><div class="handle" >☰</div></div>'

	});

	queueCont.innerHTML = html;


	// var q_el = document.querySelectorAll('[data-q]');



	// q_el.forEach(el => el.addEventListener('click', event => {
	// 	q_id = event.target.getAttribute('q_id');
	// 	// console.log(event.target.getAttribute('q_id'));
	// 	console.log(event.target.dataset.q);

	// 		if (event.target.getAttribute('playing') === '0' ) {
	// 			event.target.className += (' playingSong');
	// 			event.target.setAttribute('playing','1');
	// 		} else {
	// 			event.target.classList.remove("playingSong");
	// 			event.target.setAttribute('playing','0');
	// 		}
	// }));

	new Sortable(queueContainerContent, {
		handle: '.handle',
		animation: 150,
		ghostClass: 'sortable-ghost'
	});


	// startOverQueue();
	playSong(0);


}

function startOverQueue() {
	// if (document.querySelectorAll('.playingSong') != null) {
	// 	document.querySelectorAll('.playingSong')[0].classList.remove('playingSong');

	// }

	firstElDataQ_ID = document.querySelectorAll('#queueContainerContent')[0].firstChild.getAttribute('data-q');
	song = queue_glbl[firstElDataQ_ID];
	// alert(song);

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
			} else {
				document.getElementById('coverArt').style.display = "none";
			}
		}
	});

	playerCurrentTitle.innerHTML = song.title;
	document.title = song.artists.main + ' - ' + song.title;
	playerCurrentArtist.innerHTML = song.artists.main;

	var currentlyPlaying = document.querySelectorAll('[data-q="' + firstElDataQ_ID + '"]')[0];
	// console.log('currentlyPlaying :');
	// console.log(currentlyPlaying);

	var nextPlaying = currentlyPlaying.nextSibling;
	// console.log('nextPlaying :');
	// console.log(nextPlaying);

	currentlyPlaying.className += (' playingSong');

	queue_current = firstElDataQ_ID;

	currentSongMoodsArray = song.moods;
	// alert(currentSongMoodsArray);
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

	// info = callAPI(song.id);

	playAudio();
	console.log(song);

	setTimeout(function () {
		setColorPaletteHere = null;
		setColorPalette();

	}, 50);
}




function playSong(Q_ID) {

	console.log('Q CURRENT IS');
	console.log(queue_current);

	console.log(document.querySelectorAll('.playingSong'));
	if ((document.querySelectorAll('.playingSong') === undefined || document.querySelectorAll('.playingSong').length == 0)) {
		startOverQueue();
		return; // document.querySelectorAll('#queueContainerContent > div:nth-child('+ queue_current_upped + ')')[0].classList.remove('playingSong');
	}
	document.querySelectorAll('.playingSong')[0].classList.remove('playingSong');

	// alert(Q_ID);

	song = queue_glbl[Q_ID];
	// alert(song);

	audioPlayer = document.getElementById('audioPlayer');
	audioPlayer.setAttribute("src", song.path);


	audioPlayer.addEventListener('ended', (event) => {
		nextSong();
	});

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
					setColorPaletteHere = null;
					setColorPalette();
				}, 50);

			} else {
				document.getElementById('coverArt').style.display = "none";
			}
		}
	});

	playerCurrentTitle.innerHTML = song.title;
	document.title = song.artists.main + ' - ' + song.title;

	playerCurrentArtist.innerHTML = song.artists.main;

	var currentlyPlaying = document.querySelectorAll('[data-q="' + Q_ID + '"]')[0];
	console.log('currentlyPlaying :');
	console.log(currentlyPlaying);

	var nextPlaying = currentlyPlaying.nextSibling;
	console.log('nextPlaying :');
	console.log(nextPlaying);


	currentlyPlaying.className += (' playingSong');

	queue_current = Q_ID;

	currentSongMoodsArray = song.moods;
	// alert(currentSongMoodsArray);
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


	setColorPalette();


}

function nextSong() {
	song.moods = [];
	allcurrSongMoodUnq = Array.from(document.getElementsByClassName('currSongMoodUnq'));
	allcurrSongMoodUnq.forEach(elm => {
		// el.classList.remove("selectedCurrSongMood");
		if (elm.getAttribute('selected') == '1') {
			song.moods.push(elm.dataset.el.substring(5));
		}
	})

	// console.log('moods saved for the song are:' + song.moods);

	var currentlyPlaying = document.querySelectorAll('.playingSong')[0];

	if (currentlyPlaying.nextSibling != null) {
		playSong(currentlyPlaying.nextSibling.getAttribute('data-q'));
	} else {
		document.querySelectorAll('.playingSong')[0].classList.remove('playingSong');

		startOverQueue();
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

	// console.log('moods saved for the song are:' + song.moods);

	var currentlyPlaying = document.querySelectorAll('.playingSong')[0];

	if (currentlyPlaying.previousSibling != null) {
		playSong(currentlyPlaying.previousSibling.getAttribute('data-q'));
	} else {
		document.querySelectorAll('.playingSong')[0].classList.remove('playingSong');

		startOverQueue();
	}
}

function playAudio() {
	// console.log('Play button pressed');
	audioPlayer = document.getElementById('audioPlayer');
	audioPlayer.play();

	playPauseButton = document.getElementById('playPauseButton');
	playPauseButton.setAttribute("onClick", "javascript : pauseAudio();");
	// playPauseButton.innerHTML = "Pause";

	addClass(document.getElementById('playPauseButton'), 'playing');


}

function pauseAudio() {
	// removeClass(document.getElementById('playPauseButton'), 'playing');

	console.log('Pause button pressed');
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

function updateMood(currSongMoodUpdatedAppended) {

	// alert(song.id);
	previousSeletecState = currSongMoodUpdatedAppended.getAttribute('selected');


	if (previousSeletecState == '0') {
		// alert(currSongMoodUpdated.getAttribute("data-el"));
		currSongMoodUpdated = currSongMoodUpdatedAppended.dataset.el.substring(5);
		currSongMoodUpdatedClean = currSongMoodUpdated.replace(/\s/g, '+');
		currSongMoodUpdatedClean = currSongMoodUpdated.replace(/[&]/g, '%26');
		// console.log(currSongMoodUpdated);
		request = '/info/link/mood?';
		request += 'id=' + song.id + '&mood=' + currSongMoodUpdated;

		const xhttp = new XMLHttpRequest();
		xhttp.onload = function () {
			//   document.getElementById("demo").innerHTML =
			//   this.responseText;
			console.log(this.responseText);
			console.log(currSongMoodUpdated + ' added to song');
		}

		xhttp.open("GET", request);
		xhttp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

		xhttp.send();

	} else {
		currSongMoodUpdated = currSongMoodUpdatedAppended.dataset.el.substring(5);
		currSongMoodUpdatedClean = currSongMoodUpdated.replace(/\s/g, '+');
		currSongMoodUpdatedClean = currSongMoodUpdated.replace(/[&]/g, '%26');
		// console.log(currSongMoodUpdated);
		request = '/info/unlink/mood?';
		request += 'id=' + song.id + '&mood=' + currSongMoodUpdated;

		const xhttp = new XMLHttpRequest();
		xhttp.onload = function () {
			//   document.getElementById("demo").innerHTML =
			//   this.responseText;
			console.log(this.responseText);
			console.log(currSongMoodUpdated + ' removed from song');
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

	// Make sure image is finished loading
	if (img.complete) {
		color = colorThief.getColor(img);
	} else {
		image.addEventListener('load', function () {
			color = colorThief.getColor(img);
		});
	}

	document.body.style.backgroundColor = "rgb(" + color + ")";



	const swatches = 12;
	// const colorThief = new ColorThief();

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
		colors.reduce((palette, rgb) => {
			const color = `rgb(${rgb[0]}, ${rgb[1]}, ${rgb[2]})`;
			const swatch = document.createElement('div');
			swatch.style.setProperty('--color', color);
			swatch.setAttribute('color', color);
			palette.appendChild(swatch);
			return palette;
		}, palette)
	}

}