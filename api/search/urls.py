from django.conf.urls import url

from search import views

urlpatterns = [
    url(r'^words/$', views.allWords),
    url(r'^words/(?P<word_id>[0-9]+)/$', views.word),
]
