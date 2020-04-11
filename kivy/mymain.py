from kivy.app import App

from kivy.uix.scatter import Scatter
from kivy.uix.label import Label
from kivy.uix.floatlayout import FloatLayout
from kivy.uix.textinput import TextInput
from kivy.uix.boxlayout import BoxLayout
from kivy.uix.widget import Widget
from kivy.uix.button import Button
from kivy.uix.anchorlayout import AnchorLayout
from kivy.uix.image import Image





class UI(BoxLayout):
    def funcname(self, *args):
        play_button = self.ids['play_button']

class banana(App):
        def build(self):
            return UI()
            # b = BoxLayout(orientation=  'vertical')
            
            # text_input = TextInput()
            # play = Button(text='Play Button')
            # pause = Button(text='Pause Button')

            
            # b.add_widget(text_input)
            # b.add_widget(play)
            # b.add_widget(pause)
            # return b



if __name__ == "__main__":
    app = banana()
    app.run()