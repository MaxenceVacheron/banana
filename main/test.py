import glob
import pprint
import mutagen
from mutagen.mp3 import MP3
from mutagen.id3 import ID3NoHeaderError
from mutagen.id3 import ID3, TIT2, TALB, TPE1, TPE2, COMM, TCOM, TCON, TDRC, TMOO


scanned_songs = []
startbold = "\033[1m"
endbold = "\033[0;0m"

# SCANNING SONG

for file in glob.glob("/home/maxence/dev/banana/mix19-test/automatagged_songs/*.mp3"): #automatagged_songs/*.mp3
    scanned_songs.append(file)
    print(scanned_songs)
print("SCAN OK")

#TAGGING SCANNED SONG

for song in scanned_songs:
    try:
        audiofile = ID3(song) #MAYBE convert song into string doc : audiofile = ID3("example.mp3")
    except ID3NoHeaderError:
        print("Adding ID3 header")
        audiofile = ID3()
    # audiofile["TIT2"] = TIT2(encoding=3, text='title2')
    # audiofile["TALB"] = TALB(encoding=3, text=u'mutagen Album Name')
    # audiofile["TPE2"] = TPE2(encoding=3, text=u'mutagen Band')
    # audiofile["COMM"] = COMM(encoding=3, lang=u'eng', desc='desc', text=u'mutagen comment')
    # audiofile["TPE1"] = TPE1(encoding=3, text=u'mutagen Artist3')
    # audiofile["TCOM"] = TCOM(encoding=3, text=u'mutagen Composer')
    audiofile["TMOO"] = TMOO(encoding=3, text=u'testbis')
    print(audiofile["TMOO"])
    print(audiofile.size)
    print('This is a test')
    audiofile.save(song)
print('Songs tagged')
