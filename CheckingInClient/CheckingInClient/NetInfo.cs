using System;
using System.Collections.Generic;
using System.Linq;
using System.Net.NetworkInformation;
using System.Text;
using System.Threading.Tasks;

namespace CheckingInClient
{
    class NetInfo
    {
        public NetInfo(){}
        public void GetNetFlow(ref double upload, ref double download)
        {
            IPGlobalProperties computerProperties = IPGlobalProperties.GetIPGlobalProperties();
            NetworkInterface[] nics = NetworkInterface.GetAllNetworkInterfaces();
            upload = 0;
            download = 0;
            if (nics == null || nics.Length < 1)
            {
                return;
            }
            foreach (NetworkInterface adapter in nics)
            {
                IPv4InterfaceStatistics ipv4Statistics = adapter.GetIPv4Statistics();
                upload += ipv4Statistics.BytesSent / 1024.0;
                download += ipv4Statistics.BytesReceived / 1024.0;
            }  
            //得到的是当前累积流量。大概是从开机算起的吧。。。
        }
    }
}
