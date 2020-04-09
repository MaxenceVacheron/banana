
from kivy.app import App
from kivy.uix.boxlayout import BoxLayout
from kivy.clock import Clock
import os, subprocess

class MyLayout(BoxLayout):
    pass

class Audio_Player(App):    
   
    def getAlsaVolume(self, *largs):
        volume_string = subprocess.check_output(['amixer', '-c', '1', 'get', 'Digital'])[172:177]
        self.volume = self.parseInt(volume_string)
        self.root.ids.volume_slider.value = self.volume

    def sliderCallback(self, value):
        os.system('amixer --quiet -c 1 set Digital {0}%'.format(value))
        print(value)

    def buttonCallback(self):
        os.system('killall mplayer')
        self.process = subprocess.Popen('mplayer -nolirc -ao alsa:device=hw=1,0 "{0}"'.format('/home/pi/Music/08 - Strawberry Fields Forever (2009 Digital Remaster).m4a'), shell=True, stdout=subprocess.PIPE, stdin=subprocess.PIPE)
        print('button')
        self.getAlsaVolume()

    def parseInt(self, string):
        return int(''.join([x for x in string if x.isdigit()]))

    def build(self):
        self.root = MyLayout()
        Clock.schedule_interval(self.getAlsaVolume, 1)
        return self.root

if __name__ == '__main__':
    Audio_Player().run()