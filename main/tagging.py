import time
import glob
import mutagen
from mutagen.easyid3 import EasyID3


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
blank_tag = ''
new_mood_tag = 'BLANK'
# SCANNING SONG

# automatagged_songs/*.mp3
for file in glob.glob('/home/maxence/dev/banana/mix19-test/automatagged_songs/suite/*.mp3'):
    scanned_songs.append(file)

# TAGGING SCANNED SONG

for song in scanned_songs:
    audiofile = EasyID3(song)
    print(color.BOLD + color.GREEN + 'Song is: ' +
          color.END + color.GREEN + song + color.END)
    print(color.BOLD + color.GREEN + 'Mood are: ' + color.END)
    try:
        print(audiofile['mood'])
    except KeyError:
        print(color.BOLD + color.RED +
              "Audiofile does not have a mood tag ! Creating a blank one" + color.END)
        audiofile['mood'] = u"blank"
    # print(audiofile.items()) #PRINTS EVERY ID3 TAG AVAILABLE
    print(color.BOLD + color.GREEN + 'What mood should be applied ?' + color.END)
    print('[S]low, [M]edium, [F]ast \nPress [O]ther to see more options')

    mood_choice = input()
    while mood_choice not in ['s', 'm', 'f', 'o']:
        print('Wrong')
        mood_choice = input()
    if mood_choice == 's':
        chosen_mood = 'slow'
    elif mood_choice == 'm':
        chosen_mood = 'medium'
    elif mood_choice == 'f':
        chosen_mood = 'fast'
    elif mood_choice == 'o':
        print(
            'This feature is still being developped, press [B] to write a BLANK mood tag')
        other_choice = input()
        while other_choice not in ['b']:
            print('Wrong')
            other_choice = input()
        if other_choice == 'b':
            print('Deleting tag')
            audiofile['mood'] = u""
            audiofile.save()
            print('This is deletetag:')
            # print(dir(delete_tag)
            print(audiofile['mood'] + ['THIS IS NEWMOODTAG'])
            print('This was deletetag:')
            audiofile.save()
            continue
    new_mood_tag = audiofile['mood']
    new_mood_tag.append(' ' + chosen_mood)
    audiofile['mood'] = new_mood_tag
    audiofile.save()
    print(audiofile['mood'] + ['THIS IS NEWMOODTAG'])
    audiofile.save()
