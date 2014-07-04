using System;
using System.Collections.Generic;
using System.Linq;
using System.Runtime.InteropServices;
using System.Text;
using System.Threading.Tasks;

namespace CheckingInClient
{
    class MemoryInfo
    {
        [DllImport("kernel32")]
        public static extern void GlobalMemoryStatus(ref MEMORY_INFO meminfo);
        public double GetMemoryUsage()
        {
            MEMORY_INFO memInfo = new MEMORY_INFO();
            GlobalMemoryStatus(ref memInfo);
            return (double)memInfo.dwMemoryLoad;
        }
        [StructLayout(LayoutKind.Sequential)]
        public struct MEMORY_INFO
        {

            public uint dwLength;         // sizeof(MEMORYSTATUS) 
            public uint dwMemoryLoad;     // percent of memory in use 
            public uint dwTotalPhys;      // bytes of physical memory 
            public uint dwAvailPhys;      // free physical memory bytes 
            public uint dwTotalPageFile; // bytes of paging file 
            public uint dwAvailPageFile; // free bytes of paging file 
            public uint dwTotalVirtual;   // user bytes of address space 
            public uint dwAvailVirtual;   // free user bytes 

        } 
    }
}
