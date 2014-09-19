using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace PrinterManager
{
    class ConstVal
    {
        public const int timer_period = 100;//定时器周期
        public const int http_timeout = 2000;//http反馈等待
        //public const string send_url = "http://192.168.2.12/home/printer/receive/";//内网IP
        public const string logsite = "C:/Program Files/LabPrinterManage/PrinterManager.log";
        public const string send_url = "http://202.197.66.195/home/printer/receive/";//外网IP
        //public const string send_url = "http://127.0.0.1/home/printer/receive/";//DebugIP
        //public const string logsite = "D:/workspace/LabManageSystem/PrinterManager/PrinterManager/bin/Debug/PrinterManager.log";

    }
}
