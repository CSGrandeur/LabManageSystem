E:
cd E:/workspace/LabManageSystem/PrinterManager/PrinterManager/bin/Debug
%SystemRoot%/Microsoft.NET/Framework/v4.0.30319/installutil.exe PrinterManager.exe
sc config PrinterManager start= auto
Net Start PrinterManager