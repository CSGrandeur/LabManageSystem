﻿using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace CheckingInClient
{
    class ConstVal
    {
        public const int timer_period = 1000;//定时器周期
        public const int send_period = 60;//每过send_period个定时器周期发送一次数据
        public const string send_url = "http://192.168.2.12/home/checkingin/receive/";
        public const int http_timeout = 2000;
    }
}
