#from django.shortcuts import render
from django.shortcuts import render, render_to_response
from django.template.response import TemplateResponse
from django.http import Http404, HttpResponse
import simplejson
from django.db.models import Q
from pyfuncs import funcs
import base64
import datetime

from CheckingIn.models import CheckingIn, Name2Onlyname
# Create your views here.
def receive(request):
    if 'info' in request.GET:
        info = Base64JsonDecode(request.GET['info'])
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
         
def display_charts(request, stuid):
    stuid = stuid.strip()
    if len(stuid) < 5:
        raise Http404()
    try:
        student = Name2Onlyname.objects.get(stuid=stuid)
    except Name2Onlyname.DoesNotExist:
        raise Http404()
    else:
        return TemplateResponse(request, 'CheckingIn/smt/display_charts.html', {'stuid': student.stuid,
                                                          'name': student.name,
                                                          'onlyname': student.onlyname
                                                })

def display_charts_ajax(request):
    if 'onlyname' in request.GET:
        data = []
        if request.GET['type'] == 'all':
            dtend = datetime.datetime.now()
            dtstart = dtend - datetime.timedelta(minutes=80)
            rows = CheckingIn.objects.filter(onlyname = request.GET['onlyname'],
                                              receivetime__gte = dtstart)
        else:
            rows = CheckingIn.objects.filter(onlyname = request.GET['onlyname']).reverse()[:1]
        for row in rows:
            data.append({"cpuload":row.cpuload,
                        "memload":row.memload,
                        "mousebutton0":row.mousebutton0,
                        "mousebutton1":row.mousebutton1,
                        "mousemove":row.mousemove,
                        "keybutton":row.keybutton,
                        "upload":row.upload,
                        "download":row.download,
                        "appprocessnum":row.appprocessnum,
                        "processnum":row.processnum,
                        "receivetime":str(row.receivetime)})
        return HttpResponse(simplejson.dumps(data, ensure_ascii=False))
    else:
        raise Http404()
    
    
    
    
    
    
def Base64JsonDecode(reqget):
    try:
        getinfo = base64.b64decode(reqget)
    except :
        return {"wrong_type": True}
    else:
        try:
            info = simplejson.loads(getinfo)
        except :
            return {"wrong_type": True}
        else:
            return info