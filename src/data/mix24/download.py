from __future__ import unicode_literals
import youtube_dl


ydl_opts = {
    'writethumbnail': True,
    'format': 'bestaudio/best',
    #'username': 'vacheronmaxence@gmail.com',
    # 'password': 'xxxxxxxaxenc&&1311hpvistaundeux34',
    'download_archive': 'ARCHIVE',
    'postprocessors': [
            {'key': 'FFmpegExtractAudio',
            'preferredcodec': 'mp3',
            'preferredquality': '321'},
            {'key': 'EmbedThumbnail',},],
}
with youtube_dl.YoutubeDL(ydl_opts) as ydl:
    ydl.download(['https://www.youtube.com/playlist?list=PLVEeE44Zhu32Dkbwg_u7kFvO68dIvqKS0'])
