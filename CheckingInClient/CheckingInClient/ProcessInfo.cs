using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Runtime.InteropServices;
using System.Diagnostics;
using System.Windows.Forms;
using System.Management;

namespace CheckingInClient
{
    class ProcessInfo
    {
        public int processnum;//进程个数
        public int appprocessnum;//app进程个数
        public void GetProcessNums()
        {
            Process[] procList = Process.GetProcesses();
            processnum = procList.Length;
            appprocessnum = 0;
            foreach (Process p in procList)
            {
                if (p.MainWindowHandle != IntPtr.Zero) 
                    appprocessnum++;
            }
        }
    }
}
