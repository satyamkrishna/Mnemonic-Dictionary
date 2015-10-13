from django.shortcuts import render
from django.http import HttpResponse
from search.models import Word
import json
import logging

def allWords(request):
    return HttpResponse('Just to check that this is working')

def word(request, word_id):

    word = Word.objects.filter(pk = word_id)[0]

    data = {}

    data['name'] = word.name


    return HttpResponse(json.dumps(data),content_type='application/json')
