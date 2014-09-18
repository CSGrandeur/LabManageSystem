using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace PrinterManager
{
    class InfoToSend
    {
        public InfoToSend() { }
        public string submitter;//任务提交用户名
        public int pagenum;//页码数
        public string jobname;//任务名
        public int identifier;//打印编号
        public string jobtime;//任务提交时间

        public string ToHttpGetStr()
        {
            jobname = Encrypt.Base64Encode(jobname);
            string res = "{";
            res += "\"uid\":\"" + submitter + "\",";
            res += "\"papernum\":\"" + pagenum + "\",";
            res += "\"jobname\":\"" + jobname + "\",";
            res += "\"identifier\":\"" + identifier + "\",";
            res += "\"submittime\":\"" + jobtime + "\"";//最后一行不要逗号安全些
            res += "}";

            return res;
        }
    }
}
