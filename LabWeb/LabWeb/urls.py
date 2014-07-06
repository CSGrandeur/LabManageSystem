from django.conf.urls import patterns, include, url

#from django.contrib import admin
#admin.autodiscover()
urlpatterns = patterns('',

    #CheckingIn
    #主页
    (r'^CheckingIn/', include('CheckingIn.urls')),

)
