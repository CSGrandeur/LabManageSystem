using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace PrinterManager
{
    class ConstVal
    {
        public const int timer_period = 50;//定时器周期
        public const string send_url = "http://127.0.0.1/home/printer/receive/";
        public const int http_timeout = 2000;
    }
}
