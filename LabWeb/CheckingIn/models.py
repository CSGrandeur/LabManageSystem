from django.db import models

# Create your models here.

class CheckingIn(models.Model):
    onlyname = models.CharField(max_length=255)
    cpuload = models.FloatField()
    memload = models.FloatField()
    mousebutton0 = models.IntegerField()
    mousebutton1 = models.IntegerField()
    mousemove = models.IntegerField()
    keybutton = models.IntegerField()
    upload = models.FloatField()
    download = models.FloatField()
    appprocessnum = models.IntegerField()
    processnum = models.IntegerField()
    receivetime = models.DateTimeField(auto_now=False, auto_now_add=True)
    def __unicode__(self):
        return self.onlyname
    class Meta:
        ordering = ['receivetime']
   
class Name2Onlyname(models.Model):
    stuid = models.CharField(max_length=20)
    name = models.CharField(max_length=50)
    onlyname = models.CharField(max_length=100)
    