using System;
using System.Collections;
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

            //Dictionary<int, int> tmp_pagenum = new Dictionary<int, int>();
            Dictionary<int, bool> sended = new Dictionary<int, bool>();
            bool newsend = true;

            foreach (PrintQueue pq in myPrintQueues)
            {
                pq.Refresh();
                //排除非打印机的打印任务，暂时没找到更好的识别真实打印机的方法
                if (pq.Name == "发送至 OneNote 2013" ||
                    pq.Name == "Microsoft XPS Document Writer" ||
                    pq.Name == "Foxit Reader PDF Printer" ||
                    pq.Name == "Fax"
                    )
                    continue;
                var Jobs = pq.GetPrintJobInfoCollection();
                foreach (PrintSystemJobInfo Job in Jobs)
                {
                    if (Job.JobIdentifier > omaxidentifier)
                    {
                        Job.Pause();
                        if(Job.JobIdentifier > nmaxidentifier)
                            nmaxidentifier = Job.JobIdentifier;
                        //tmp_pagenum.Add(Job.JobIdentifier, Job.NumberOfPages);//添加临时页码
                        sended.Add(Job.JobIdentifier, false);//添加是否已发标记
                    }
                }
                mut.WaitOne();
                maxidentifier = nmaxidentifier;
                mut.ReleaseMutex();
            }
            if (nmaxidentifier <= omaxidentifier) return;//如果没有新任务则返回
                       
            //Thread.Sleep(10000);//等待插入打印队列的初始化，以免得到0页的结果。

            while(newsend == true)
            {
                newsend = false;
                foreach (PrintQueue pq in myPrintQueues)
                {
                    pq.Refresh();
                    //排除非打印机的打印任务，暂时没找到更好的识别真实打印机的方法
                    if (pq.Name == "发送至 OneNote 2013" ||
                        pq.Name == "Microsoft XPS Document Writer" ||
                        pq.Name == "Foxit Reader PDF Printer" ||
                        pq.Name == "Fax"
                        )
                        continue;
                    var Jobs = pq.GetPrintJobInfoCollection();
                    foreach (PrintSystemJobInfo Job in Jobs)
                    {
                        //using (System.IO.StreamWriter sw = new System.IO.StreamWriter(ConstVal.logsite, true))
                        //{
                        //    sw.WriteLine(tmp_pagenum[Job.JobIdentifier] + "\t" + Job.NumberOfPages + "\t" + Job.JobSize + "\t" + Job.JobStatus);
                        //}
                        if (Job.JobIdentifier > omaxidentifier && Job.JobIdentifier <= nmaxidentifier)
                        {
                            if (sended[Job.JobIdentifier] == true) continue;
                            newsend = true;
                            //if (tmp_pagenum[Job.JobIdentifier] < Job.NumberOfPages)
                            if(!Job.IsSpooling)//后台处理完成
                            {
                                sended[Job.JobIdentifier] = true;

                                its.submitter = Job.Submitter;
                                its.pagenum = Job.NumberOfPages;
                                its.jobname = Job.Name;
                                its.identifier = Job.JobIdentifier;
                                its.jobtime = Job.TimeJobSubmitted + "";

                                sendstr = its.ToHttpGetStr();
                                string retstr = HttpSend.HttpGet(ConstVal.send_url, "info=" + Encrypt.Base64Encode(sendstr));
                                if (retstr != "0")
                                    Job.Resume();
                                else
                                    Job.Cancel();
                                using (System.IO.StreamWriter sw = new System.IO.StreamWriter(ConstVal.logsite, true))
                                {
                                    sw.WriteLine(DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss ") + "\r\n" + "info=" + Encrypt.Base64Encode(sendstr) + "\r\n" + sendstr + "\r\n" + "response:" + "\r\n" + retstr + "\r\n\r\n");
                                }
                            }
                        }
                    }
                }
                Thread.Sleep(2000);//每5秒确认一次任务的页码是否还在增加
            }
        

            //Thread thread = new Thread(new ThreadStart(st.SendInfo));
            //thread.Start();
        }

    }
}
