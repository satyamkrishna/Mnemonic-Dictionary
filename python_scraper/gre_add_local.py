from bs4 import BeautifulSoup
import urllib
import urllib2
import string
import os
from gre_word_func import send_word,add_word
                                             
count = 0
os.chdir("mnemonicdictionary")
for files in os.listdir("."):
    if files.endswith(".txt"):
        file_name =  str(files)
        f = open(file_name, 'r+')
        print  file_name
        filehandle = f.read()
        count = count + add_word(filehandle)
        f.close()
print count