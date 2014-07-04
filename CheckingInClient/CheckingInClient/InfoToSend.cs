using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace CheckingInClient
{
    class InfoToSend
    {
        public InfoToSend(){}
        public string onlyname;//唯一标识
        public double cpuload;//CPU利用率
        public double memload;//内存利用率
        public int[] mousebutton = new int[2];//鼠标左右键点击次数
        public int mousemove;//鼠标累积移动曼哈顿距离
        public int keybutton;//键盘敲击次数
        public double upload;//上行流量
        public double download;//下行流量
        public int processnum;//进程数
        public int appprocessnum;//应用进程数
        
        public string ToHttpGetStr()
        {
            string res = "{";
            res += "\"onlyname\":\"" + onlyname + "\",";
            res += "\"cpuload\":\"" + cpuload.ToString("0.0") + "\",";
            res += "\"memload\":\"" + memload.ToString("0.0") + "\",";
            res += "\"mousebutton0\":\"" + mousebutton[0] + "\",";
            res += "\"mousebutton1\":\"" + mousebutton[1] + "\",";
            res += "\"mousemove\":\"" + mousemove + "\",";
            res += "\"keybutton\":\"" + keybutton + "\",";
            res += "\"upload\":\"" + upload.ToString("0.0") + "\",";
            res += "\"download\":\"" + download.ToString("0.0") + "\",";
            res += "\"appprocessnum\":\"" + appprocessnum + "\",";
            res += "\"processnum\":\"" + processnum + "\"";//最后一行不要逗号安全些
            res += "}";
            return res;
        }
    }
}
