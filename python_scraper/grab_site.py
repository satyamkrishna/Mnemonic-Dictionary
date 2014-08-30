from bs4 import BeautifulSoup
import urllib2
import string

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
print ''
for alphabet in string.ascii_uppercase:
      url = 'http://www.mnemonicdictionary.com/wordlist/GREwordlist/startingwith/' + alphabet
      response = urllib2.urlopen(url)
      page_source = response.read()
      tot_count = get_count(page_source)
      for num in range(1,tot_count+1):
          url_final = url + '?page=' + str(num)
          file_name = 'mnemonicdictionary/' + alphabet + '_' + str(num) + '.txt'
          print file_name
          f = open(file_name, 'w')
          response = urllib2.urlopen(url_final)
          page_source = response.read()
          f.write(page_source)  
          f.close()

  