D:
cd D:/workspace/LabManageSystem/PrinterManager/PrinterManager/bin/Release
%SystemRoot%/Microsoft.NET/Framework/v4.0.30319/installutil.exe PrinterManager.exe
sc config PrinterManager start= auto
Net Start PrinterManager