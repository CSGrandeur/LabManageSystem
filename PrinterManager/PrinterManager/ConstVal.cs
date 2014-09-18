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
        public const string send_url = "http://192.168.2.12/home/printer/receive/";
        public const int http_timeout = 2000;
        //public const string logsite = "D:/workspace/LabManageSystem/PrinterManager/PrinterManager/bin/Debug/PrinterManager.log";
        public const string logsite = "C:/Program Files/LabPrinterManage/PrinterManager.log";
    }
}
