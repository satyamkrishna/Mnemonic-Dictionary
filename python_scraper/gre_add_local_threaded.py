from bs4 import BeautifulSoup
import urllib
import urllib2
import string
import os
import thread

from gre_word_func import send_word,add_word

NO_THREADS = 32
def threaded_func(file_arr):
    
    for file_name in file_arr:
        f = open(file_name, 'r+')
        print  file_name
        filehandle = f.read()
        add_word(filehandle)
        f.close()

file_arr = []                                      
os.chdir("mnemonicdictionary")
for files in os.listdir("."):
    if files.endswith(".txt"):
        file_name =  str(files)
        file_arr.append(file_name)

for i in range(0,NO_THREADS):
    res_arr = []
    for num in range(i,len(file_arr),NO_THREADS):
        res_arr.append(file_arr[num])
    thread.start_new_thread( threaded_func,(res_arr,))

while 1:
    pass