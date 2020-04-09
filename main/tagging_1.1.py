import glob
import csv
import mutagen
from mutagen.easyid3 import EasyID3
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
existing_moods_nested = []

# LIST OF EXISTING TAGS

with open('tags.csv', 'r') as csv_file_read_mode:
    csv_reader = csv.reader(csv_file_read_mode)
    for line in csv_reader:
        existing_moods_nested.append(line)
        # TRANSFORM NESTED LIST IN FLATTENED LIST
        existing_moods = [
            item for sublist in existing_moods_nested for item in sublist]
    print(color.BOLD + color.GREEN + 'Existing Moods are :' + color.END)
    print(existing_moods)

# SCANNING SONG

# automatagged_songs/*.mp3
for file in glob.glob('/home/maxence/dev/banana/mix19-test/automatagged_songs/suite/*.mp3'):
    scanned_songs.append(file)

# TAGGING SCANNED SONG

for song in scanned_songs:
    audiofile = EasyID3(song)
    audiofile_mp3 = MP3(song)

    print(color.BOLD + color.GREEN + 'Song is: ' +
          color.END + color.RED + color.BOLD + song + color.END)

    lenght = audiofile_mp3.info.length
    print(lenght)

    print(color.BOLD + color.GREEN + 'Moods are: ' + color.END)
    try:
        print(audiofile['mood'])
    except KeyError:
        print(color.BOLD + color.RED +
              "Audiofile does not have a mood tag ! Creating a blank one" + color.END)
        audiofile['mood'] = u"mood"
    print(color.BOLD + color.GREEN + 'What mood should be added ?' + color.END)
    print('Type in the mood you want to tag')

    mood_choice = input()

    while mood_choice not in existing_moods:
        attempted_mood = mood_choice

        print(color.BOLD + color.GREEN +
              'You entered : ' + attempted_mood + color.END)
        print(color.BOLD + color.GREEN +
              'This tag does not seems to exist. Create it ?' + color.END)
        print(color.BOLD + color.GREEN +
              'Type YES to create it or NO to go to next file' + color.END)
        print(color.BOLD + color.GREEN +
              'To see a list of existing tag, type MOODS' + color.END)

        new_mood_choice = input()
        while new_mood_choice not in ['YES', 'NO', 'MOODS']:
            print(color.BOLD + color.GREEN + 'Invalid input' + color.END)
            new_mood_choice = input(
                color.BOLD + color.GREEN + 'Type YES, NO or MOODS \n' + color.END)

        if new_mood_choice == 'YES':
            new_mood_tag = audiofile['mood']

            new_mood_tag.append(attempted_mood + '')
            # new_mood_tag.append(attempted_mood + ' ')

            audiofile['mood'] = new_mood_tag
            audiofile.save()
            print(audiofile['mood'] + ['THIS IS NEWMOODTAG'])

            with open('tags.csv', 'a') as csv_file_write_mode:
                csv_writer = csv.writer(csv_file_write_mode)
                csv_writer.writerow([attempted_mood])
            mood_choice = 'mood'
            continue
        if new_mood_choice == 'NO':
            print('Canceling')
            print('No tag were written for the following song:' + song)
            mood_choice = 'mood'
            continue
        if new_mood_choice == 'MOODS':
            print('Existing moods are the following :')
            print(existing_moods)

    if mood_choice != 'mood':
        new_mood_tag = audiofile['mood']

        new_mood_tag.append(mood_choice + '')

        # new_mood_tag.append(attempted_mood + ' ')
        audiofile['mood'] = new_mood_tag
        audiofile.save()
        print(audiofile['mood'] + ['THIS IS NEWMOODTAG'])
        continue
    else:
        continue
