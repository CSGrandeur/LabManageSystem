#from django.shortcuts import render
from django.shortcuts import render, render_to_response
from django.template.response import TemplateResponse
from django.http import Http404, HttpResponse
import simplejson
from django.db.models import Q
from pyfuncs import funcs
import datetime
import hashlib
from PrintServer.models import PrintArrange, PrintRecord, PrintCount, PrintAddition
# Create your views here.














def receive(request):
    if 'info' in request.GET:
        info = funcs.Base64JsonDecode(request.GET['info'])
        if 'wront_type' not in info and 'uid' in info:
            info['infohash'] = hashlib.md5(request.GET['info'].encode(encoding='utf-8')).hexdigest()
            try:#如果这个打印条目已经处理过，则不再处理
                PrintRecord.objects.get(infohash = info['infohash'])
                return HttpResponse("1")
            except:
                try:
                    arrange = PrintArrange.objects.get(uid = info['uid'])
                    paperlimit = arrage.paperlimit
                except:
                    paperlimit = 2#数据库没读到相应条目，则按默认值设置纸张数
                
                #计算本月额外配给纸张数（允许多次配给，求和）
                addition = PrintAddition.objects.filter(
                                                        uid=info['uid'], 
                                                        month = datetime.date.today().replace(day = 1),
                                                        available = "Y"
                                                        )
                additionnum = 0
                for add in addition:
                    additionnum = additionnum + add.addnum
                paperlimit = paperlimit + additionnum
                #计算本月已使用总纸张数
                papercount = PrintCount.objects.get_or_create(
                                                              uid = info['uid'], 
                                                              month = datetime.date.today().replace(day = 1),
                                                              defaults={'papersum': 0}
                                                              )
                alreadyused = papercount[0].papersum
                if alreadyused >= paperlimit:
                    return HttpResponse("0")
                PrintRecord.objects.create(
                    uid = info['uid'],
                    papernum = info['papernum'],
                    jobname = info['jobname'],
                    identifier = info['identifier'],
                    submittime = datetime.datetime.strptime(info['submittime'], "%Y/%m/%d %H:%M:%S"),
                    infohash = info['infohash']
                    )
                try:
                    nowused = int(info['papernum'])
                except:
                    nowused = 0
                papercount[0].papersum = papercount[0].papersum + nowused
                papercount[0].save()
                return HttpResponse("1")
        return HttpResponse("1")
    return HttpResponse("1")
         