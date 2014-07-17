using System;
using System.Collections.Generic;
using System.Linq;
using System.Security.Cryptography;
using System.Text;
using System.Threading.Tasks;

namespace PrinterManager
{
    class Encrypt
    {
        public Encrypt() { }
        public static string Base64Encode(string data)
        {
            byte[] bytes = Encoding.Default.GetBytes(data);
            return Convert.ToBase64String(bytes);
        }
        public string Base64Decode(string data)
        {
            byte[] outputb = Convert.FromBase64String(data);
            return Encoding.Default.GetString(outputb);
        }
        private static readonly string publickey = "<RSAKeyValue><Modulus>pntnbdNaJ8iaGdgTV53hmEpDzsp6kP5gQKLnhgk0wwK2ThVkRp2ZMbCobEwJX4t8ZbhRVvs3aATW6shu41Lw38+f/Xxb2L6AbhsP0lVbf9nuyhzLNpUAqivpN7u58/P1y+EvfIuJKrB2L2oztl4XXNGdIGLiXaUBcnAWRLnkFSs=</Modulus><Exponent>AQAB</Exponent></RSAKeyValue>";
        private static readonly string privatekey = "<RSAKeyValue><Modulus>pntnbdNaJ8iaGdgTV53hmEpDzsp6kP5gQKLnhgk0wwK2ThVkRp2ZMbCobEwJX4t8ZbhRVvs3aATW6shu41Lw38+f/Xxb2L6AbhsP0lVbf9nuyhzLNpUAqivpN7u58/P1y+EvfIuJKrB2L2oztl4XXNGdIGLiXaUBcnAWRLnkFSs=</Modulus><Exponent>AQAB</Exponent><P>wJx417rPsEpid61y54yXMi0lcFh0k6wXb3tMkxWOtm0EZ4O6gSDyBgw0/zKxxBCcSOhdWW08hMiUDqCYvvmcww==</P><Q>3UWLd7LhKFiHDwI9d1RLeNAXeWZ4k44HF1uLqY1bAuTsr7LyvdOUWfx5fUnkc+L8hY7jSNfqE7WKqFbRVQc/eQ==</Q><DP>oDTF8rIos7p7Qo4bh+sRi6Ovg02f0YCPkaOd4q1IogX1ZuBTjbpIdK1Mm4OgBrPGOoJDuvE4KD3poG0F/7sBHw==</DP><DQ>F4JTDhWoTHQTbWnMhAgluKFLTS+w8eRuJnIohYwqNkWCTCyUE80N/v2PHtuh9RoRwFLtHQkrqopoP/hxZzpM6Q==</DQ><InverseQ>nVEvpuH9Pr4veWz4lc8LMlZ/oFHR7OX8k3hgBVa+80j8801ooNdcxJlsG/DWAoS+hl1r83soQQLnzmncc2C3mw==</InverseQ><D>TL6IYE1UuxAzUYSU7gfezfg2J+aY96v7rPArsFMgGmFurrIXxqGx1AEusrWegIfpcW61OFaYJQBOHm8FBw/d71+Yxnva0VOaeRp48k8QGNNiEIgeut667vbKcHFCqrl7fUkrxEv2HYTh5dQvXceXJy2YUPwWvSCsjXTB72MXStE=</D></RSAKeyValue>";
        /// <summary>
        /// 加密
        /// </summary>
        /// <param name="data"></param>
        /// <returns></returns>
        public string RsaEncrypt(string data)
        {
            return RsaEncrypt(data, Encoding.UTF8);
        }

        /// <summary>
        /// 加密
        /// </summary>
        /// <param name="data"></param>
        /// <param name="encode"></param>
        /// <returns></returns>
        public string RsaEncrypt(string data, Encoding encode)
        {
            byte[] dataByteArray = encode.GetBytes(data);
            RSACryptoServiceProvider provider = new RSACryptoServiceProvider();
            provider.FromXmlString(publickey);
            byte[] encrypt = provider.Encrypt(dataByteArray, false);
            return Convert.ToBase64String(encrypt);
        }

        /// <summary>
        /// 解密
        /// </summary>
        /// <param name="data"></param>
        /// <returns></returns>
        public string RsaDecrypt(string data)
        {
            return RsaDecrypt(data, Encoding.UTF8);
        }

        /// <summary>
        /// 解密
        /// </summary>
        /// <param name="data"></param>
        /// <param name="encode"></param>
        /// <returns></returns>
        public string RsaDecrypt(string data, Encoding encode)
        {
            byte[] dataByteArray = Convert.FromBase64String(data);
            RSACryptoServiceProvider provider = new RSACryptoServiceProvider();
            provider.FromXmlString(privatekey);
            byte[] decrypt = provider.Decrypt(dataByteArray, false);
            return encode.GetString(decrypt);
        }
        public void GenerateKey()
        {
            RSACryptoServiceProvider provider = new RSACryptoServiceProvider();
            string publickey = provider.ToXmlString(false);
            string privatekey = provider.ToXmlString(true);

            using (System.IO.StreamWriter sw = new System.IO.StreamWriter(".\\xxx.txt", true))
            {
                sw.WriteLine("publickey:\t" + publickey + "\n" + "privatekey:\t" + privatekey + "\n\n");
            }
        }
        public string MakeMD5(string data)
        {
            using (MD5 md5Hash = MD5.Create())
            {
                return GetMd5Hash(md5Hash, data);
            }
        }
        private string GetMd5Hash(MD5 md5Hash, string input)
        {

            // Convert the input string to a byte array and compute the hash.
            byte[] data = md5Hash.ComputeHash(Encoding.UTF8.GetBytes(input));

            // Create a new Stringbuilder to collect the bytes
            // and create a string.
            StringBuilder sBuilder = new StringBuilder();

            // Loop through each byte of the hashed data 
            // and format each one as a hexadecimal string.
            for (int i = 0; i < data.Length; i++)
            {
                sBuilder.Append(data[i].ToString("x2"));
            }

            // Return the hexadecimal string.
            return sBuilder.ToString();
        }

    }
}
