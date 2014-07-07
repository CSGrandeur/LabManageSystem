from django.utils.translation import ugettext as _
import re
from django.contrib.auth.hashers import check_password, make_password
import simplejson
from django.http import Http404, HttpResponse
import base64
#username合法性
def JudgeUsername(username):
    if username == "":
        return 'F', _("Username should not be empty.") + "\n"
    if len(username) > 20:
        return 'F', _("Username should not be longer than 20.") + "\n"
    pattern = re.compile(r'^[a-zA-z0-9]*$')
    if not pattern.match(username):
        return 'F', _("Username should contain only \'a-zA-Z0-9_\'.") + "\n"
    return 'T', ""
#password合法性
def JudgePassword(password):    
    if len(password) < 6:
        return 'F', _("Password must be at least 6 characters.") + "\n"
    if len(password) > 20:
        return 'F', _("Password should not be longer than 20.") + "\n"
    return 'T', ""

#password一致性      
def ConfirmPassword(password, password_confirm):
    if password != password_confirm:
        return 'F', _("Please verify password matches.") + "\n"
    return 'T', ""
#email合法性
def JudgeEmail(email):
    if email == "":
        return 'F', _("Please enter your email.") + "\n"
    if len(email) > 20:
        return 'F', _("Email should not be longer than 50.") + "\n"
    pattern = re.compile(r'^[\w!#$%&\'*+/=?^`{|}~-]+(?:\.[\w!#$%&\'*+/=?^`{|}~-]+)*@(?:[\w](?:[\w-]*[\w])?\.)+[\w](?:[\w-]*[\w])?')
    if not pattern.match(email):
        return 'F', _("Please enter a valid email.") + "\n"
    return 'T', ""

#字符串长度合法性
def StringLength(strText, strName, strLen):
    if len(strText) > strLen:
        return 'F', _("%(strName)s should not be longer than %(strLen)d.")%{'strName':strName, 'strLen':strLen} + "\n"
    return 'T', ""

#密码加密
def EncodePassword(raw_password):
    return make_password(raw_password, None, 'pbkdf2_sha256')
#密码验证
def CheckPassword(raw_password, password):
    return check_password(raw_password, password)
#返回Json数据
def retJson(data):
    return HttpResponse(simplejson.dumps(data, ensure_ascii=False))
#根据datatables递交的请求，返回数据表排序参数字符串
def orderPowerJudgeProbDatatableStrInBackend(orderRow, orderDir):
    orderStr = ""
    if orderRow == 2:
        orderStr = "j_ptitle"
    elif orderRow == 4:
        orderStr = "j_source"
    else:
        orderStr = "j_originprob"
    if orderDir == "desc":
        orderStr = "-" + orderStr
    return orderStr
#json格式数据base64编码的解码    
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