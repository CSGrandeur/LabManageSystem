using System;
using System.Collections.Generic;
using System.Linq;
using System.Printing;
using System.Text;
using System.Threading.Tasks;

namespace PrinterManager
{
    class SendThread
    {
        public SendThread() { }
        public List<PrintSystemJobInfo> joblist = new List<PrintSystemJobInfo>();
        public void SendInfo()
        {
            InfoToSend its = new InfoToSend();
            string sendstr = "";
            //using (System.IO.StreamWriter sw = new System.IO.StreamWriter("D:/PrinterManagerLog.txt", true))
            //{
            //    sw.WriteLine(joblist.Count + "\t\r\n");
            //}
            if (joblist.Count > 0)
            {
                for (int i = 0; i < joblist.Count; i++)
                {
                    its.submitter = joblist[i].Submitter;
                    its.pagenum = joblist[i].NumberOfPages;
                    its.jobname = joblist[i].JobName;
                    its.identifier = joblist[i].JobIdentifier;
                    its.jobtime = joblist[i].TimeJobSubmitted + "";
                    sendstr = its.ToHttpGetStr();
                }
            }
        }
    }
}
