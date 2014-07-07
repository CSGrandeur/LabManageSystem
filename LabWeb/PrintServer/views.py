#from django.shortcuts import render
from django.shortcuts import render, render_to_response
from django.template.response import TemplateResponse
from django.http import Http404, HttpResponse
import simplejson
from django.db.models import Q
from pyfuncs import funcs
import datetime

from PrintServer.models import PaperArrange, PaperUse
# Create your views here.
def receive(request):
    if 'info' in request.GET:
        info = funcs.Base64JsonDecode(request.GET['info'])
        if 'wront_type' not in info and 'onlyname' in info:
            CheckingIn.objects.create(
                onlyname = info['onlyname'],
                cpuload = info['cpuload'],
                memload = info['memload'],
                mousebutton0 = info['mousebutton0'],
                mousebutton1 = info['mousebutton1'],
                mousemove = info['mousemove'],
                keybutton = info['keybutton'],
                upload = info['upload'],
                download = info['download'],
                appprocessnum = info['appprocessnum'],
                processnum = info['processnum'],
                )
            return TemplateResponse(request, 'CheckingIn/smt/receive.html', {'response': 'ok!!!'})
    return TemplateResponse(request, 'CheckingIn/smt/receive.html', {'response': 'not ok'})
         