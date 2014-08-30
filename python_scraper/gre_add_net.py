from bs4 import BeautifulSoup
import urllib
import urllib2
import string
import os
from gre_word_func import send_word,add_word

def get_count(filehandle):
    soup = BeautifulSoup(filehandle)
    result = soup.find_all("div", class_="pagination")
    soup = BeautifulSoup(str(result[0]))
    result = soup.find_all("li")
    soup = BeautifulSoup(str(result[-2]))
    tag = soup.li
    try:
        count = int(tag.string)
        return count
    except:
        return 1

count = 0      
for alphabet in string.ascii_uppercase:
      url = 'http://www.mnemonicdictionary.com/wordlist/GREwordlist/startingwith/' + alphabet
      response = urllib2.urlopen(url)
      page_source = response.read()
      tot_count = get_count(page_source)
      for num in range(1,tot_count+1):
          url_final = url + '?page=' + str(num)
          print url_final
          response = urllib2.urlopen(url_final)
          page_source = response.read()
          count = count + add_word(page_source)
print count      