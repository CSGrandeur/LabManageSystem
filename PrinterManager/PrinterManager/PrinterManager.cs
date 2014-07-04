using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Diagnostics;
using System.Linq;
using System.Printing;
using System.ServiceProcess;
using System.Text;
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

        public Timer timer = new Timer();
        protected override void OnStart(string[] args)
        {
            timer.Elapsed += new ElapsedEventHandler(GetPrintInfo);
            timer.Interval = 1 * 1000;
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
            //Dictionary<string, int> TempDict = new Dictionary<string, int>();

            PrintServer myPrintServer = new PrintServer(); // Get all the printers installed on this PC

            // List the print server's queues
            PrintQueueCollection myPrintQueues = myPrintServer.GetPrintQueues();
            foreach (PrintQueue pq in myPrintQueues)
            {
                pq.Refresh();
                if (pq.Name == "发送至 OneNote 2013" ||
                    pq.Name == "Microsoft XPS Document Writer" ||
                    pq.Name == "Foxit Reader PDF Printer" ||
                    pq.Name == "Fax"
                    )
                    continue;
                using (System.IO.StreamWriter sw = new System.IO.StreamWriter("D:/PrinterManagerLog.txt", true))
                {
                    sw.WriteLine(pq.Name);
                }

                var Jobs = pq.GetPrintJobInfoCollection();
                int PGcount = 0;
                string PrintMsg = "";
                foreach (PrintSystemJobInfo Job in Jobs)
                {
                    PGcount += Job.NumberOfPages;
                    PrintMsg += "------------------------\r\nSubmitter = " + Job.Submitter + "\t\r\n" +
                        "Identifier = " + Job.JobIdentifier + "\t\r\n" +
                        "JobName = " + Job.JobName + "\t\r\n" +
                        "status = " + Job.JobStatus + "\t\r\n" +
                        "Pages = " + Job.NumberOfPages + "\t\r\n" +
                        "TimeJobSubmitted = " + Job.TimeJobSubmitted + "\t\r\n" +
                        "Name = " + Job.Name + "\t\r\n";

                    if (!Job.IsPaused)
                        Job.Pause();
                    

                }

                using (System.IO.StreamWriter sw = new System.IO.StreamWriter("D:/PrinterManagerLog.txt", true))
                {
                    sw.WriteLine(PrintMsg + "\t\r\n");
                }
            }
        }
    }
}
