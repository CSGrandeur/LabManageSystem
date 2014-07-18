from django.db import models

# Create your models here.

class PrintArrange(models.Model):
    uid = models.CharField(max_length=20)
    paperlimit = models.IntegerField()
    
class PrintRecord(models.Model):
    uid = models.CharField(max_length=20)
    papernum = models.IntegerField()
    jobname = models.CharField(max_length=255)
    identifier = models.IntegerField()
    submittime = models.DateTimeField(auto_now=False, auto_now_add=False)
    updatetime = models.DateTimeField(auto_now=False, auto_now_add=True)
    infohash = models.CharField(max_length=50)
    class Meta:
        ordering = ['submittime']
class PrintCount(models.Model):
    uid = models.CharField(max_length=20)
    papersum = models.IntegerField()
    month = models.DateField(auto_now=False, auto_now_add=False)
    
class PrintAddition(models.Model):
    uid = models.CharField(max_length=20)
    addnum = models.IntegerField()
    month = models.DateField(auto_now=False, auto_now_add=False)
    available = models.CharField(max_length=2)
    