#from django.shortcuts import render
from django.shortcuts import render, render_to_response
from django.template.response import TemplateResponse
from django.http import Http404, HttpResponse
import simplejson
from django.db.models import Q
from pyfuncs import funcs
import datetime
import hashlib
from PrintServer.models import PrintArrange, PrintRecord, PrintCount
# Create your views here.
def receive(request):
    if 'info' in request.GET:
        info = funcs.Base64JsonDecode(request.GET['info'])
        if 'wront_type' not in info and 'uid' in info:
            info['infohash'] = hashlib.md5(request.GET['info'].encode(encoding='utf-8')).hexdigest()
#           尚未完成，需要验证PrintCount并更新。
            PrintRecord.objects.create(
                uid = info['uid'],
                papernum = info['papernum'],
                jobname = info['jobname'],
                identifier = info['identifier'],
                submittime = datetime.datetime.strptime(info['submittime'], "%Y/%m/%d %H:%M:%S"),
                infohash = info['infohash']
                )
            return HttpResponse("1")
    return HttpResponse("What The Fuck!")
         