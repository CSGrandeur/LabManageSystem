from django.db import models

# Create your models here.

class UserInfo(models.Model):
    uid = models.CharField(max_length=20)#学号
    name = models.CharField(max_length=50)#姓名
    sex = models.CharField(max_length=2)#性别
    supervisorid = models.CharField(max_length=20)#导师ID（系统内ID）
    teacherid = models.CharField(max_length=20)#指导老师ID（系统内ID）
    
class UserDetail(models.Model):
    phone = models.CharField(max_length=20)#电话
    email = models.CharField(max_length=50)#邮箱
    degree = models.CharField(max_length=20)#攻读学位/类别（可表示老师）
    grade = models.CharField(max_length=20)#年级
    birthday = models.DateField(auto_now=False, auto_now_add=True)#出生年月日
    idcard = models.CharField(max_length=30)#身份证号
    nation = models.CharField(max_length=20)#民族
    political = models.CharField(max_length=20)#政治面貌
    institute = models.CharField(max_length=20)#所在学院
    major = models.CharField(max_length=20)#专业名称
    supervisor = models.CharField(max_length=50)#导师
    teacher = models.CharField(max_length=50)#指导老师
   
