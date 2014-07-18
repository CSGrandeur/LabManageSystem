from django.conf.urls import patterns, include, url

#from django.contrib import admin
#admin.autodiscover()
from UserInfo import views
urlpatterns = patterns('',

    #PrintServer
    #获取远程计算机数据
    (r'^modify/$', views.modify_page),
    (r'^modify_function/$', views.modify_function),
    (r'^whether_loggedin_ajax/$', views.whether_loggedin_ajax),
    (r'^login_function/$', views.login_function),
    (r'^logout_function/$', views.logout_function),

)
