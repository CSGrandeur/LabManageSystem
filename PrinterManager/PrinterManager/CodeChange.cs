using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Text.RegularExpressions;
using System.Threading.Tasks;

namespace PrinterManager
{
    class CodeChange
    {
        /// <summary>
        /// GB2312转换成UTF8
        /// </summary>
        /// <param name="text"></param>
        /// <returns></returns>
        public static string gb2312_utf8(string text)
        {
            //声明字符集   
            System.Text.Encoding utf8, gb2312;
            //gb2312   
            gb2312 = System.Text.Encoding.GetEncoding("gb2312");
            //utf8   
            utf8 = System.Text.Encoding.GetEncoding("utf-8");
            byte[] gb;
            gb = gb2312.GetBytes(text);
            gb = System.Text.Encoding.Convert(gb2312, utf8, gb);
            //返回转换后的字符   
            return utf8.GetString(gb);
        }

        /// <summary>
        /// UTF8转换成GB2312
        /// </summary>
        /// <param name="text"></param>
        /// <returns></returns>
        public static string utf8_gb2312(string text)
        {
            //声明字符集   
            System.Text.Encoding utf8, gb2312;
            //utf8   
            utf8 = System.Text.Encoding.GetEncoding("utf-8");
            //gb2312   
            gb2312 = System.Text.Encoding.GetEncoding("gb2312");
            byte[] utf;
            utf = utf8.GetBytes(text);
            utf = System.Text.Encoding.Convert(utf8, gb2312, utf);
            //返回转换后的字符   
            return gb2312.GetString(utf);
        }

        /// <summary>  
        /// 字符串转为UniCode码字符串  
        /// </summary>  
        /// <param name="s"></param>  
        /// <returns></returns>  
        public static string StringToUnicode(string s)
        {
            char[] charbuffers = s.ToCharArray();
            byte[] buffer;
            StringBuilder sb = new StringBuilder();
            for (int i = 0; i < charbuffers.Length; i++)
            {
                buffer = System.Text.Encoding.Unicode.GetBytes(charbuffers[i].ToString());
                sb.Append(String.Format("//u{0:X2}{1:X2}", buffer[1], buffer[0]));
            }
            return sb.ToString();
        }  
    }
}
