from django.conf.urls import patterns, include, url

#from django.contrib import admin
#admin.autodiscover()
from CheckingIn import views
urlpatterns = patterns('',

    #CheckingIn
    #主页
#    (r'^/$', views.CheckingIn),
    #获取演示数据
    (r'^display_charts_ajax/$', views.display_charts_ajax),
    #显示对应学号学生数据
    (r'^display_charts/(.{1,30})/$', views.display_charts),
    #获取远程计算机数据
    (r'^receive/$', views.receive),

)
