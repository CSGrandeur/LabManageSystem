from django.shortcuts import render, render_to_response
from django.template.response import TemplateResponse
from django.http import Http404, HttpResponse
import simplejson
from django.db.models import Q
from pyfuncs import funcs
import base64
import datetime
import hashlib
from PrintServer.models import PrintArrange, PrintRecord, PrintCount, PrintAddition
# Create your views here.
#修改信息页
def modify_page(request):
#     if 'j_username' in request.session:#已经登录状态
#         alertTitle = _('Already logged in.')
#         alertText = _('If you want to register with another username, please log out first.')
#         return TemplateResponse(request, "whole/smt/alert.html", 
#                                 {'alertTitle': alertTitle,
#                                  'alertText': alertText})
 #   return TemplateResponse(request, 'CheckingIn/smt/receive.html', {'response': 'ok!!!'})
    return TemplateResponse(request, 'UserInfo/smt/usermodify.html', {'response': 'ok!!!'})
#修改信息处理
def modify_function(request):
    if 'j_username' in request.session:#已经登录状态
        retMsg = _('Already logged in.') + "\n"
        retMsg += _('If you want to register with another username, please log out first.') + "\n"
        validFlag = False
        return funcs.retJson({"valid": validFlag, "retMsg": retMsg})
    if 'username' in request.POST:
        username = request.POST.get('username', '').strip()
        nickname = request.POST.get('nickname', '').strip()
        password = request.POST.get('password', '').strip()
        password_confirm = request.POST.get('password_confirm', '').strip()
        school = request.POST.get('school', '').strip()
        email = request.POST.get('email', '').strip()
        gender = request.POST.get('gender', '').strip()
        motto = request.POST.get('motto', '').strip()
        sharecode = request.POST.get('sharecode', '').strip()
        retMsg = ""
        validFlag = True
        (tmpValidFlag, tmpRetMsg) = funcs.JudgeUsername(username)
        validFlag = validFlag and tmpValidFlag == 'T'
        retMsg += tmpRetMsg
        (tmpValidFlag, tmpRetMsg) = funcs.JudgePassword(password)
        validFlag = validFlag and tmpValidFlag == 'T'
        retMsg += tmpRetMsg
        (tmpValidFlag, tmpRetMsg) = funcs.ConfirmPassword(password, password_confirm)
        validFlag = validFlag and tmpValidFlag == 'T'
        retMsg += tmpRetMsg
        (tmpValidFlag, tmpRetMsg) = funcs.JudgeEmail(email)
        validFlag = validFlag and tmpValidFlag == 'T'
        retMsg += tmpRetMsg
        (tmpValidFlag, tmpRetMsg) = funcs.StringLength(school, "School", 50)
        validFlag = validFlag and tmpValidFlag == 'T'
        retMsg += tmpRetMsg
        (tmpValidFlag, tmpRetMsg) = funcs.StringLength(motto, "Motto", 140)
        validFlag = validFlag and tmpValidFlag == 'T'
        retMsg += tmpRetMsg
        (tmpValidFlag, tmpRetMsg) = funcs.StringLength(nickname, "Nickname", 50)
        validFlag = validFlag and tmpValidFlag == 'T'
        retMsg += tmpRetMsg
        if not validFlag:
            return funcs.retJson({"valid": validFlag, "gender": gender, "retMsg": retMsg})
        #secret,male,female
        if gender == '1':
            gender = 'm'
        elif gender == '2':
            gender = 'f'
        else:
            gender = 's'
        #1 share,0 don't share
        if sharecode == 'on':
            sharecode = '1'
        else:
            sharecode = '0'
            
        try:#是否存在用户
            p_user.objects.get(j_username = username)
        except p_user.DoesNotExist:#用户不存在，则保存
            p_user.objects.create(j_username = username,
                                  j_nickname = nickname,
                                  j_password = funcs.EncodePassword(password),
                                  j_school = school,
                                  j_email = email,
                                  j_gender = gender,
                                  j_motto = motto,
                                  j_sharecode = sharecode)
            request.session['j_username'] = username
            return funcs.retJson({"valid": validFlag, "retMsg": retMsg, "username": username})
        else:#用户名已存在
            retMsg += _('User "%(username)s" already exists')%{'username':username} + "\n"
            validFlag = False
            return funcs.retJson({"valid": validFlag, "retMsg": retMsg})
    else:
        raise Http404()

#看用户是否已登录
def whether_loggedin_ajax(request):
    if 'j_username' in request.session:#已经登录状态
        return funcs.retJson({"valid": True, "retMsg": "", "username": request.session['j_username']})
    else:#未登录
        return funcs.retJson({"valid": False, "retMsg": ""})                
#登录处理
def login_function(request):
    if 'username' in request.POST:
        retMsg = ""
        validFlag = True
        username = request.POST.get('username', '').strip()
        #读数据库前验证一下username合法性
        (tmpValidFlag, tmpRetMsg) = funcs.JudgeUsername(username)
        validFlag = validFlag and tmpValidFlag == 'T'
        retMsg += tmpRetMsg
        if not validFlag:#用户名不合法
            return funcs.retJson({"valid": validFlag, "retMsg": retMsg})
        if request.session.get('j_username', '') == username:#用户已登录
            validFlag = False
            retMsg += _('User "%(username)s" already logged in')%{'username':username} + "\n"
            return funcs.retJson({"valid": validFlag, "retMsg": retMsg})
        raw_password = request.POST.get('password', '').strip()
        try:#是否存在用户
            user = p_user.objects.get(j_username = username)
        except p_user.DoesNotExist:#用户不存在
            retMsg += _('User "%(username)s" doesn\'t exist')%{'username':username} + "\n"
            validFlag = False
            return funcs.retJson({"valid": validFlag, "retMsg": retMsg})
        else:#用户存在，判断密码
            password = user.j_password
            if funcs.CheckPassword(raw_password, password):
                request.session['j_username'] = username
                retMsg += _('Successfully login') + "\n"
                validFlag = True
                return funcs.retJson({"valid": validFlag, "retMsg": retMsg, "username": username})
            else:
                retMsg += _('Wrong password') + "\n"
                validFlag = False
                return funcs.retJson({"valid": validFlag, "retMsg": retMsg})
    else:
        raise Http404()
#登出处理
def logout_function(request):
    if 'j_username' in request.session:
        request.session.flush()
        retMsg = _('Successfully logged out') + "\n"
        validFlag = True
        return funcs.retJson({"valid": validFlag, "retMsg": retMsg})
    else:
        retMsg = _('User hasn\'t logged in') + "\n"
        validFlag = False
        return funcs.retJson({"valid": validFlag, "retMsg": retMsg})