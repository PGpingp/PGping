Urldownloadtofile, https://pgpingp.github.io/PGping/code.php, code.php ;
Fileread,CodeList,code.php
Filedelete, code.php

1=A
2=B 
3=C 
4=D 
5=A
6=B 
7=C 
8=D 
9=E
10=F
11=G
12=H
13=I
14=J
15=K
16=L
18=N
19=O
20=P
21=Q
22=R
23=S
24=T
25=U
26=V
27=W
28=X
29=Y
30=Z
31=1
32=2
33=3
34=4
35=5
36=6
37=7
38=8
39=9
40=10
FormatTime, currentDate,, yyyyMMdd

Gui, Add, Edit, x2 y20 w230 h20 vRCode +Center, Code
Gui, Add, Button, x242 y10 w90 h40 gBtn, 생성
Gui, Add, Text, x92 y0 w40 h20 +Center, Code
Gui, Add, Edit, x2 y90 w340 h20 vResultCode +Center, Code
Gui, Add, Button, x242 y60 w90 h30 gReload, 초기화
Gui, Add, Edit, x2 y50 w110 h20 vDate +Center, %currentDate%


Gui, Show, x741 y319 h115 w349, PUBG-RCCG
Return

GuiClose:
ExitApp

Reload:
reload
return

Btn:
Gui, Submit, Nohide
loop,20
{ 
lnum+=1
random,n,1,40
code%lnum% = % %n%
}
RRCode = %code1%%code4%%code12%%code5%%code6%%code3%%code8%%code14%%code10%%code2%%code11%%code13%%code7%%code20%%code15%%code18%%code16%%code17%%code9%%code19%
GuiControl,,RCode, %RRcode%
Length := StrLen(RRCode) ;20이어야함.
if Length = 20
{
IfInString,CodeList, %RRCode% ;코드가 유효한지 확인
{
 ;코드 리스트에 있으면 리로드
 reload
} else {
 ;코드 체크후 코드리스트에 없으면 통과
 GuiControl,,ResultCode, %RRcode%|%Date%/
 FileAppend,
(
%RRcode%|%Date%/`n
),%A_ScriptDir%\Code.txt
}
return
}
reload
