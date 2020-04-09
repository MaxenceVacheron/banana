import time
import glob
import mutagen
from mutagen.easyid3 import EasyID3
from mutagen.id3 import ID3, TMOO
from mutagen.mp3 import MP3

class color:
   PURPLE = '\033[95m'
   CYAN = '\033[96m'
   DARKCYAN = '\033[36m'
   BLUE = '\033[94m'
   GREEN = '\033[92m'
   YELLOW = '\033[93m'
   RED = '\033[91m'
   BOLD = '\033[1m'
   UNDERLINE = '\033[4m'
   END = '\033[0m'

scanned_songs = []
playlist = []

FORMAT_DESCRIPTOR = "#EXTM3U"
RECORD_MARKER = "#EXTINF"

# print(playlist)


for file in glob.glob('/home/maxence/dev/banana/mix19-test/automatagged_songs/suite/*.mp3'):
    scanned_songs.append(file)
    #print("OK")
# magicInput = input('Type here: ')     #MULTIPLE CHOICE TO APPEND TO A LSIT
# magicList = list(magicInput)

print(color.BOLD + color.GREEN + "Whatcha listening today ?" + color.END)
playlist_choice = input("\n" )

print('YOU CHOSE : ' + playlist_choice)

playlist_name = playlist_choice + '.txt'
m3u_playlist = open(playlist_name , "a") #open(playlist_choice.m3u) ??
m3u_playlist.write('1st line \n')


for song in scanned_songs:
    audiofile = EasyID3(song) #MAYBE convert song into string doc : audiofile = ID3("example.mp3")
    audiofile_mp3 = MP3(song)
    # print(audiofile.items())

    for key, values in audiofile.items(): #key=title,artist,album...
        if key != 'mood':
            continue
        print(color.BOLD + color.GREEN + 'Found mood tag :' + color.END)
        print(key)
        print(color.BOLD + color.GREEN + 'In mood tag of' + color.END)
        print(color.BOLD + color.GREEN + song + color.END)
        print(values)
        for unique_tag in values:
            time.sleep(0.1)
            print(color.CYAN + 'This is the tag being analysed :  \n ' + color.END)
            print('start' + color.RED +color.UNDERLINE + unique_tag + color.END + 'end')
            if unique_tag == playlist_choice:
                playlist.append(song)
                m3u_playlist.write(song + '\n')
                #print(playlist)
                print( color.BOLD + color.RED + 'Tag recognized and song added to playlist \n' + color.END)
                time.sleep(0.21)
            elif unique_tag != playlist_choice:
                print('Tag skipped' + '\n')
                # continue
        continue
        # then ajouter a la playlist
m3u_playlist.close()
print('Final playlist is:')
print(playlist)

# readable_playlist = []
# print(readable_playlist)
# for file_corresponding_song in playlist:
#     corresponding_song = EasyID3(file_corresponding_song)
#     corresponding_title = corresponding_song['title']
#     corresponding_artist = corresponding_song['artist']
#     print(corresponding_artist + corresponding_title)
# #     corresponding_artist = corresponding_artist.append(corresponding_title)
# #     readable_playlist.append(corresponding_artist)
# # print(readable_playlist)


