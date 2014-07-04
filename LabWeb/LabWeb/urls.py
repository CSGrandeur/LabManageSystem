from django.conf.urls import patterns, include, url
from django.conf import settings
from django.contrib import admin

from views import hello, current_datetime, hours_ahead
from CheckingIn import views
admin.autodiscover()

urlpatterns = patterns('',
    # Examples:
    # url(r'^$', 'CheckingInServer.views.home', name='home'),
    # url(r'^blog/', include('blog.urls')),
    (r'^static/(?P<path>.*)$', 'django.views.static.serve',
        {'document_root': settings.STATIC_PATH}),
    url(r'^admin/', include(admin.site.urls)),
#    (r'^hello/$', hello),
    (r'^time/$', current_datetime),
    (r'^time/plus/(\d{1,2})/$', hours_ahead),
#    (r'^meta/$', views.display_meta),
    (r'^receive/$', views.receive),
    (r'^display_charts_ajax/$', views.display_charts_ajax),
    (r'^display_charts/(.{1,30})/$', views.display_charts),
)
