using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Diagnostics;
using System.Linq;
using System.Printing;
using System.ServiceProcess;
using System.Text;
using System.Threading;
using System.Threading.Tasks;
using System.Timers;

namespace PrinterManager
{
    public partial class PrinterManager : ServiceBase
    {
        public PrinterManager()
        {
            InitializeComponent();
        }

        public System.Timers.Timer timer = new System.Timers.Timer();
        public static int maxidentifier;
        private static Mutex mut = new Mutex();
        protected override void OnStart(string[] args)
        {
            maxidentifier = -1;
            timer.Elapsed += new ElapsedEventHandler(GetPrintInfo);
            timer.Interval = ConstVal.timer_period;
            timer.Enabled = true;
        }
        private static void GetPrintInfo(object source, ElapsedEventArgs e)
        {
            GetAllPrinterQueues();
        }
        protected override void OnStop()
        {
        }
        public static void GetAllPrinterQueues()
        {
            //SendThread st = new SendThread();
            PrintServer myPrintServer = new PrintServer(); // Get all the printers installed on this PC
            // List the print server's queues
            PrintQueueCollection myPrintQueues = myPrintServer.GetPrintQueues();
            mut.WaitOne();
            int nmaxidentifier = maxidentifier;
            int omaxidentifier = maxidentifier;
            mut.ReleaseMutex();
            InfoToSend its = new InfoToSend();
            List<PrintSystemJobInfo> joblist = new List<PrintSystemJobInfo>();
            string sendstr = "";
            foreach (PrintQueue pq in myPrintQueues)
            {
                pq.Refresh();
                //排除非打印机的打印任务，暂时没找到更好的识别真实打印机的方法
                //if (pq.Name == "发送至 OneNote 2013" ||
                //    pq.Name == "Microsoft XPS Document Writer" ||
                //    pq.Name == "Foxit Reader PDF Printer" ||
                //    pq.Name == "Fax"
                //    )
                //    continue;
                var Jobs = pq.GetPrintJobInfoCollection();
                foreach (PrintSystemJobInfo Job in Jobs)
                {
                    if(Job.JobIdentifier > maxidentifier)
                    {
                        Job.Pause();
                        if(Job.JobIdentifier > nmaxidentifier)
                            nmaxidentifier = Job.JobIdentifier;
                    }
                }
                mut.WaitOne();
                maxidentifier = nmaxidentifier;
                mut.ReleaseMutex();
            }

            Thread.Sleep(2000);//太快的话读不到正确页码

            foreach (PrintQueue pq in myPrintQueues)
            {
                pq.Refresh();
                //排除非打印机的打印任务，暂时没找到更好的识别真实打印机的方法
                //if (pq.Name == "发送至 OneNote 2013" ||
                //    pq.Name == "Microsoft XPS Document Writer" ||
                //    pq.Name == "Foxit Reader PDF Printer" ||
                //    pq.Name == "Fax"
                //    )
                //    continue;
                var Jobs = pq.GetPrintJobInfoCollection();
                foreach (PrintSystemJobInfo Job in Jobs)
                {
                    if (Job.JobIdentifier > omaxidentifier && Job.JobIdentifier <= nmaxidentifier)
                    {
                        joblist.Add(Job);
                    }
                }
            }
            for (int i = 0; i < joblist.Count; i++)
            {
                its.submitter = joblist[i].Submitter;
                its.pagenum = joblist[i].NumberOfPages;
                its.jobname = joblist[i].Name;
                its.identifier = joblist[i].JobIdentifier;
                its.jobtime = joblist[i].TimeJobSubmitted + "";
                sendstr = its.ToHttpGetStr();

                string retstr = HttpSend.HttpGet(ConstVal.send_url, "info=" + Encrypt.Base64Encode(sendstr));
                if (retstr != "0")
                    joblist[i].Resume();
                else
                    joblist[i].Cancel();
                using (System.IO.StreamWriter sw = new System.IO.StreamWriter("D:/PrinterManagerLog.txt", true))
                {
                    sw.WriteLine("info=" + Encrypt.Base64Encode(sendstr) + "\r\n" + sendstr + "\r\n" + "response:" + "\r\n" + retstr + "\r\n");
                }
            }
            //Thread thread = new Thread(new ThreadStart(st.SendInfo));
            //thread.Start();
        }

    }
}
