var queue_glbl;
var queue_current;
var nextPlaying;

if('serviceWorker' in navigator){
	navigator.serviceWorker.register('/sw.js')
	  .then(reg => console.log('service worker registered'))
	  .catch(err => console.log('service worker not registered', err));
  }


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
	const playerCoverArt = document.getElementById('coverArt');

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

	playerCoverArt.addEventListener('dblclick', function (e) {
		openInfo('currentSong');
	});
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

	playSong(0);

}

function playSong(Q_ID) {


	console.log('Q CURRENT IS');
	console.log(queue_current);

	if (queue_current != undefined) {

		queue_current_upped = queue_current + 1;
		console.log('queue_current_upped');
		console.log(queue_current_upped);
		// document.querySelectorAll('#queueContainerContent > div:nth-child('+ queue_current_upped + ')')[0].classList.remove('playingSong');
		document.querySelectorAll('.playingSong')[0].classList.remove('playingSong');
	}
	// alert(Q_ID);

	song = queue_glbl[Q_ID];
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
	playerCurrentArtist.innerHTML = song.artists.main;

	var currentlyPlaying = document.querySelectorAll('[data-q="' + Q_ID + '"]')[0];
	console.log('currentlyPlaying :');
	console.log(currentlyPlaying);

	var nextPlaying = currentlyPlaying.nextSibling;
	console.log('nextPlaying :');
	console.log(nextPlaying);

	currentlyPlaying.className += (' playingSong');

	queue_current = Q_ID;

	playAudio();
}

function nextSong() {
	// currentQ_Id = document.querySelectorAll('.playingSong')[0].getAttribute('data-q');
	// console.log(currentQ_Id);


	var currentlyPlaying = document.querySelectorAll('.playingSong')[0];

	nextPlayingDataQID = currentlyPlaying.nextSibling.getAttribute('data-q');

	// alert(nextPlayingDataQID);
	playSong(nextPlayingDataQID);
}

function playAudio() {
	// console.log('Play button pressed');
	audioPlayer = document.getElementById('audioPlayer');
	audioPlayer.play();

	playPauseButton = document.getElementById('playPauseButton');
	playPauseButton.setAttribute("onClick", "javascript: pauseAudio();");
	playPauseButton.innerHTML = "Pause";

}

function pauseAudio() {
	console.log('Pause button pressed');
	audioPlayer = document.getElementById('audioPlayer');
	audioPlayer.pause();

	playPauseButton = document.getElementById('playPauseButton');
	playPauseButton.innerHTML = "Play";
	playPauseButton.setAttribute("onClick", "javascript: playAudio();");

}

function openInfo(songID) {
	// url = 'http://' + location.hostname + '/AAA/sendcreatedata.html';
	// html = '';
	// html += '<div class="modalExtBackground modal" onclick="closeInfo()"></div><iframe class="iframemodal modal" height="100" id="infoEditFrame" src="/AAA/sendcreatedata.html"></iframe>';
	// document.body.innerHTML += html;
	document.getElementById('editInfoContainer').style.display = 'block';
	document.getElementById('modalExtBackground').style.display = 'block';
}

function closeInfo() {
	document.getElementById('editInfoContainer').style.display = 'none';
	document.getElementById('modalExtBackground').style.display = 'none';
	// alert('Info PopupClosed');

}

function hideElementsByClass(className) {
	var elements = document.getElementsByClassName(className);
	while (elements.length > 0) {
		elements[0].parentNode.removeChild(elements[0]);
	}
}