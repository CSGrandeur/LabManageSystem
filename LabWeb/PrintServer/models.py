from django.db import models

# Create your models here.

class PaperArrange(models.Model):
    uid = models.CharField(max_length=20)
    paperlimit = models.IntegerField()
    
class PaperUse(models.Model):
    uid = models.CharField(max_length=20)
    papernum = models.IntegerField()
    identifier = models.IntegerField()
    submittime = models.DateTimeField(auto_now=False, auto_now_add=True)
    updatetime = models.DateTimeField(auto_now=False, auto_now_add=True)
    class Meta:
        ordering = ['updatetime']
