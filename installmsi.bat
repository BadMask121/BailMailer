echo @off
mkdir C:\php
C:\Windows\System32\xcopy "./php" C:\php /s /e
reg add "\\Computer\HKEY_LOCAL_MACHINE\SYSTEM\CurrentControlSet\Control\Session Manager\Environment" /v Path /t REG_DWORD /d 1 /f
rmdir /s /q C:\Users\%USERNAME%\Desktop\BM121\php
pause
REM REG ADD HKEY_LOCAL_MACHINE\SYSTEM\CurrentControlSet\Control\Session Manager\Environment /v path /d C:\php