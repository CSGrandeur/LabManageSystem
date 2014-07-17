from django.conf.urls import patterns, include, url

#from django.contrib import admin
#admin.autodiscover()
from PrintServer import views
urlpatterns = patterns('',

    #PrintServer
    #获取远程计算机数据
    (r'^receive/$', views.receive),

)
