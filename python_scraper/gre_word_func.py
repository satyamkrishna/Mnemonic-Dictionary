from bs4 import BeautifulSoup
import urllib
import urllib2
import string
import os

def send_word(word,definition_short,mnemonics,def_arr,def_dict):
    base_url = 'http://127.0.0.1/utopia-gre/web_app/python_scraper/'
    url = base_url + 'add_word.php'
    values = {'word' : word , 'definition_short':definition_short,'mnemonics':mnemonics}
    data = urllib.urlencode(values)
    req = urllib2.Request(url, data)
    response = urllib2.urlopen(req)
    the_page = response.read()    
    id = the_page
    url = base_url + 'add_def.php'
    def_arr_size = len(def_arr)
    for index in range(0,def_arr_size):
        values = {'id':id,'def':def_arr[index],'syn':'//'.join(def_dict[index]['syn']),'sent':'//'.join(def_dict[index]['sent'])}
        data = urllib.urlencode(values)
        req = urllib2.Request(url, data)
        response = urllib2.urlopen(req)
        the_page = response.read()    
    print word    
    
    
def add_word(filehandle):
    
    soup = BeautifulSoup(filehandle)
    result = soup.find_all("div", class_="input-append")
    result = result[0]
    result = result.find_parent('form')
    tot = 0
    while True:
        result = result.find_next_sibling('div')
        word = result
        if word['class'] != [u'row-fluid']:
            break
        else:
            search_word = word.find('h2').string            
            search_short_defn = word.find('p').text[19:]
            search_def = word.find('div').text
            
            #mnemonics parser
            mnemonics = ''
            token_sep = '///'
            icons = word.find_all("i", class_='icon-lightbulb')
            size = 4
            mnemonics_len = len(icons) 
            if size > mnemonics_len:
                size = mnemonics_len
            for index in range(0,size):
                icon_div = icons[index].find_parent('div')
                mnemonics_str = ''
                try:
                    mnemonics_str = str(icon_div.text).strip()
                except:
                    mnemonics_str = 'NONE'
                mnemonics = mnemonics + mnemonics_str + token_sep
            
            search_def_arr = str(search_def).split('\n')
            
            definition_str  =''
            synonym_str = ''
            sentence_str = ''
            
            search_def_arr = [x.strip() for x in search_def_arr]
            value = 0
            
            def_arr_in = -1
            def_arr = []
            def_dict = []
            for data in search_def_arr:
                if len(data)>0 and data !=',':
                    if 'Definition' in data:
                        def_arr_in = def_arr_in + 1
                        test = {'syn':[],'sent':[]}
                        def_dict.append(test)
                        value=1
                    elif 'Synonyms' in data:
                        value=2
                    elif 'Example' in data and 'Sentence' in data:
                        value=3
                    else:
                        if value == 1:
                            def_arr.append(data) 
                        elif value == 2:
                            dict = def_dict[def_arr_in]
                            syn_arr = dict['syn']
                            syn_arr.append(data) 
                            dict['syn'] = syn_arr
                        elif value == 3:
                            dict = def_dict[def_arr_in]
                            sent_arr = dict['sent']
                            sent_arr.append(data) 
                            dict['sent'] = sent_arr
                            
            #send_word(search_word,search_short_defn,mnemonics,def_arr,def_dict)
            tot = tot +1
    return tot
