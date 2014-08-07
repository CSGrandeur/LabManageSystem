using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Diagnostics;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Timers;
using System.Windows.Forms;
using System.Management;
using System.Threading;

namespace CheckingInClient
{
    public partial class CheckingInSystem : Form
    {
        HttpSend httpsend = new HttpSend();//数据发送模块
        private static Mutex mousemut = new Mutex();//访问共享资源互斥锁,鼠标参数
        private static Mutex keymut = new Mutex();//访问共享资源互斥锁,键盘参数
        Encrypt encrypt = new Encrypt();//加密类

        //public PerformanceCounter CPUinfo = new PerformanceCounter("Processor", "% Processor Time", "_Total");//CPU信息类
        PerformanceCounter[] counters = new PerformanceCounter[System.Environment.ProcessorCount];
        public System.Timers.Timer wholetimer = new System.Timers.Timer();//Timer
        MemoryInfo meminfo = new MemoryInfo();//内存信息类
        ProcessInfo processinfo = new ProcessInfo();//进程信息类
        MouseHook mouseinfo = new MouseHook();//鼠标信息类
        KeyBoardHook keyboardinfo = new KeyBoardHook();//键盘信息类
        NetInfo netinfo = new NetInfo();//网络信息类
        InfoToSend info = new InfoToSend();//全局信息


        public int sampcnt;//单位时间采样次数，暂定1分钟
        public double cpuload;//单位时间cpu累加占用率（用于算平均值）
        public double memload;//单位时间内存累加占用率（用于算平均值）
        public int processnum;//进程个数
        public int appprocessnum;//app进程个数
        public int[] mousebutton = new int[2];//单位时间鼠标点击次数
        public int mousemove;//单位时间鼠标移动累加距离
        public bool mousestartflag;//标记鼠标统计起点，以免对鼠标累加距离造成误差
        public int[] mousesite = new int[2];//鼠标“上一次”坐标，表示X和Y
        public int keybutton;//单位时间键盘敲击次数
        double lastupload, nowupload;//上次查询累积上传流量，当前累积上传流量
        double lastdownload, nowdownload;//上次查询累积下载流量，当前累积下载流量
        public bool netstartflag;//标记网络统计起点，以免对网络统计造成误差

        protected override void SetVisibleCore(bool value)
        {
            base.SetVisibleCore(false);
        }
        public CheckingInSystem()
        {
            InitializeComponent();

            //初始化定时器和系统相关变量
            InitEnvironment();

            InitVars();
            InitParameters();

        }
        ~CheckingInSystem()
        {

        }
        //初始化系统环境，做一些修复工作，以免软件运行错误
        public void InitEnvironment()
        {
            //执行LODCTR /R，修复Windows性能监视问题，以免CPU信息读取出错崩溃
            Process p = new Process();
            p.StartInfo.FileName = "cmd.exe";
            p.StartInfo.Arguments = "/c" + "LODCTR /R";//设定参数，要输入到命令程序的字符，其中"/c"表示执行完命令后马上退出
            p.StartInfo.UseShellExecute = false;//不使用系统外壳程序启动  
            p.StartInfo.RedirectStandardInput = false;//不重定向输入  
            p.StartInfo.RedirectStandardOutput = false;//不重定向输出，默认的显示在dos控制台
            p.StartInfo.CreateNoWindow = true;//不创建窗口
            try
            {
                p.Start();
            }
            catch
            {

            }
            finally
            {
                if (p != null)
                { p.Close(); }
            }  
        }
        //初始化全部变量
        public void InitVars()
        {
            sampcnt = 0;
            cpuload = 0;
            memload = 0;
            processnum = 0;
            appprocessnum = 0;
            mousebutton[0] = 0;
            mousebutton[1] = 0;
            mousestartflag = false;//为false时不计算鼠标累加距离，第一次采样之后改为true
            mousemove = 0;
            keybutton = 0;
            lastupload = 0;
            nowupload = 0;
            lastdownload = 0;
            nowdownload = 0;
            netstartflag = false;
            info.onlyname = GetOnlyName();//全局信息类的计算机唯一标识在这里拿到，后面不必重复赋值
        }
        //初始化全部变量
        public void InitParameters()
        {
            //初始化Timer
            wholetimer.Elapsed += new ElapsedEventHandler(GetSystemInformations);
            wholetimer.Interval = ConstVal.timer_period;
            wholetimer.Enabled = true;
            GC.KeepAlive(wholetimer);//让wholetimer不被回收
            //初始化CPU信息类
            //CPUinfo.MachineName = ".";
            //CPUinfo.NextValue();

            for (int i = 0; i < counters.Length; i++)
            {
                counters[i] = new PerformanceCounter("Processor", "% Processor Time", i.ToString());
                counters[i].NextValue();
            }
            //初始化鼠标信息类
            mouseinfo.OnMouseActivity += new MouseEventHandler(mouse_OnMouseActivity);
            mouseinfo.Start();
            //初始化键盘信息类
            keyboardinfo.KeyDownEvent += new KeyEventHandler(keyboard_OnKeyActivity);
            keyboardinfo.Start();
        }


        /****************************************************************************************************/
        //获取系统全部信息,timer调用
        private void GetSystemInformations(object sender, ElapsedEventArgs e)
        {

            GetCPUInformations();
            GetMemoryInformations();
            //GetMouseInformations();
            //GetKeyboardInformations();
            //GetOnlyName();

            string getinfo = "";

            sampcnt++;//采样sampcnt次发送一次
            if(sampcnt >= ConstVal.send_period)
            {
                GetProcessInformations();
                GetNetInformations();
                //CPU
                info.cpuload = cpuload / sampcnt; 
                cpuload = 0;
                //内存
                info.memload = memload / sampcnt; 
                memload = 0;
                //鼠标
                mousemut.WaitOne();//鼠标互斥锁
                info.mousebutton[0] = mousebutton[0];
                mousebutton[0] = 0;
                info.mousebutton[1] = mousebutton[1];
                mousebutton[1] = 0;
                info.mousemove = mousemove;
                mousemove = 0;
                mousemut.ReleaseMutex();//鼠标互斥锁关闭
                //键盘
                keymut.WaitOne();//键盘互斥锁
                info.keybutton = keybutton;
                keybutton = 0;
                keymut.ReleaseMutex();//键盘互斥锁关闭
                //流量
                info.upload = nowupload - lastupload;
                lastupload = nowupload;
                info.download = nowdownload - lastdownload;
                lastdownload = nowdownload;
                //进程数
                info.processnum = processnum;
                info.appprocessnum = appprocessnum;
                sampcnt = 0;

                getinfo = httpsend.HttpGet(ConstVal.send_url, "info=" + encrypt.Base64Encode(info.ToHttpGetStr()));


                using (System.IO.StreamWriter sw = new System.IO.StreamWriter("D:\\log.txt", true))
                {
                    sw.WriteLine(DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss\n") + encrypt.Base64Encode(info.ToHttpGetStr()) + "\n");
                }
            }
            //throw new NotImplementedException();
        }
        //获取CPU信息
        public void GetCPUInformations()
        {
            //float CPUload = 0;
            for (int i = 0; i < counters.Length; i++)
            {
                cpuload += counters[i].NextValue();
            }
            //info = "CPU利用率:" + CPUload.ToString("0.0") + "%\n";
        }
        //获取内存信息
        public void GetMemoryInformations()
        {
            memload += meminfo.GetMemoryUsage();
            //info += "内存利用率:" + meminfo.GetMemoryUsage() + "\n";
        }
        //获取网络信息
        public void GetNetInformations()
        {
            netinfo.GetNetFlow(ref nowupload, ref nowdownload);
            if(netstartflag == false)
            {
                netstartflag = true;
                lastupload = nowupload;
                lastdownload = nowdownload;
            }

            //info += "上传流量:" + lastupload + "KB\t" + "下载流量:" + lastdownload + "KB\n";
        }
        //获取鼠标信息
        private void mouse_OnMouseActivity(object sender, MouseEventArgs e)
        {
            mousemut.WaitOne();//互斥锁
            switch (e.Button)
            {
                case MouseButtons.Left:
                    mousebutton[0] += e.Clicks;
                    break;
                case MouseButtons.Right:
                    mousebutton[1] += e.Clicks;
                    break;
            }
            if (mousestartflag == false)
                mousestartflag = true;
            else
                mousemove += Math.Abs(mousesite[0] - e.X) + Math.Abs(mousesite[1] - e.Y);
            mousesite[0] = e.X;
            mousesite[1] = e.Y;
            mousemut.ReleaseMutex();//释放互斥锁
            //throw new NotImplementedException();
        }
        //获取键盘信息
        private void keyboard_OnKeyActivity(object sender, KeyEventArgs e)
        {
            keymut.WaitOne();//互斥锁
            keybutton++;
            keymut.ReleaseMutex();
            //throw new NotImplementedException();
        }
        public void GetMouseInformations()
        {
            //info += "鼠标左键:" + mousebutton[0] + "\t鼠标右键:" + mousebutton[1] + "\t鼠标累积移动:" + mousemove + "\n";
        }
        //获取键盘信息
        public void GetKeyboardInformations()
        {
            //info += "键盘敲击次数:" + keybutton + "\n";
        }
        //获取进程信息
        public void GetProcessInformations()
        {
            processinfo.GetProcessNums();
            processnum = processinfo.processnum;
            appprocessnum = processinfo.appprocessnum;
            //info += "进程个数:" + Process.GetProcesses().Length + "\n";
        }
        //获取计算机唯一标识
        public string GetOnlyName()
        {
            string mac = "";
            ManagementClass mc;
            mc = new ManagementClass("Win32_NetworkAdapterConfiguration");
            ManagementObjectCollection moc = mc.GetInstances();
            foreach (ManagementObject mo in moc)
            {
                if (mo["MacAddress"] != null)
                {
                    mac = (mo["MacAddress"].ToString()).Trim() + "$";
                    break;
                }
            }
            ManagementClass mc2 = new ManagementClass("Win32_BaseBoard");
            ManagementObjectCollection moc2 = mc2.GetInstances();
            foreach (ManagementObject mo2 in moc2)
            {
                if (mo2.Properties["SerialNumber"] != null)
                {
                    mac += mo2.Properties["SerialNumber"].Value.ToString().Trim();
                    break;
                }
            }
            //info += mac + "\n";
            //info += GetMD5Hash(mac) + "\n";
            return GetMD5Hash(mac);
        }
        //字符串转MD5加密
        public static string GetMD5Hash(string input)
        {
            System.Security.Cryptography.MD5CryptoServiceProvider md5 = new System.Security.Cryptography.MD5CryptoServiceProvider();
            byte[] bs = System.Text.Encoding.UTF8.GetBytes(input);
            bs = md5.ComputeHash(bs);
            System.Text.StringBuilder s = new System.Text.StringBuilder();
            foreach (byte b in bs)
            {
                s.Append(b.ToString("x2").ToUpper());
            }
            return s.ToString();
        }
    }
}
