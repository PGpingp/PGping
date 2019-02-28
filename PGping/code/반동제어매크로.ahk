version = 1.1

;SoundBeep, 6000, 300
IniRead, UseCode, %A_Windir%\PUBG-RecoilControl.ini, PUBG-RecoilControl, Code, Code ;사용 코드 로드

Gui, Add, Text, x12 y40 w70 h20 +Center, 빠른조준 :
Gui, Add, Text, x12 y70 w70 h20 +Center, 광클 :
Gui, Add, Text, x12 y100 w70 h20 +Center, 반동제어 :
Gui, Add, Text, x92 y40 w30 h20 vFastgui +Center, Off
Gui, Add, Text, x92 y70 w30 h20 vClickgui +Center, On
Gui, Add, Text, x92 y100 w30 h20 vRecoilgui +Center, On
Gui, Add, Text, x12 y130 w70 h20 +Center, 반동제어 값 :
Gui, Add, Text, x92 y130 w30 h20 vRecoilCvgui +Center, 5
Gui, Add, Text, x12 y190 w110 h20 +Center, Made By PG
Gui, Add, Text, x2 y10 w130 h20 +Center, PUBG-RecoilControl
Gui, Add, Text, x2 y10 w150 h20 vT, PUBG-RecoilControl
Gui, Add, Text, x12 y160 w70 h20 +Center, 작동상태 :
Gui, Add, Text, x92 y160 w30 h20 vOnOffgui, On

Gui, +ToolWindow 
Gui +LastFound -caption +AlwaysOnTop
WinSet, TransColor, F0F0F0

GuiControl, +cFF0000, Fastgui
GuiControl, +C00ff00, Clickgui
GuiControl, +C00ff00, Recoilgui
GuiControl, +C00ff00, OnOffgui

Gui, Show, x1780 y300 h188 w136, PUBG-RCM

Gui,2:Add, Text, w150 vT, 코드를 입력하세요.
Gui,2:Add, Edit, w250 vMyCode, %UseCode%
Gui,2:Add, Button, gBtn default, 코드확인


traytip, PUBG-RecoilControl-Macro 시작섬에서 핫키를 눌러주세요.
Menu, tray, NoStandard
Menu, tray, Tip, PUBG-RecoilControl %version%
Menu, tray, Add, PUBG-RecoilControl %version%, return
Menu, tray, Add
Menu, tray, Add, Help, info
Menu, tray, Add, Exit, exit


ConnectedToInternet(flag=0x40) { 
Return DllCall("Wininet.dll\InternetGetConnectedState", "Str", flag,"Int",0) 
}



If ConnectedToInternet() ;인터넷 연결상태 확인
 goto, load
else 
 Msgbox,인터넷 연결이 이상합니다. 프로그램을 종료합니다.
 exitapp 
Return


load: ;필수 변수 로드
Urldownloadtofile, https://pgpingp.github.io/PGping/code.php, code.php ;
Fileread,A,code.php
Fileread,CodeList,code.php
Filedelete, code.php
Urldownloadtofile, https://pgpingp.github.io/PGping/server.php, server.php ;
Fileread,OnOffw,server.php
Urldownloadtofile, https://pgpingp.github.io/PGping/version.php, version.php ;
Fileread,VersionRead,version.php
Filedelete, version.php
Filedelete, server.php


IfInString,OnOffw, ON ; 서버상태 확인
{
 Filedelete, server.php
 goto, versioncheck
}
IfInString,OnOffw,OFF
{
 Filedelete, server.php
 msgbox, 서버와의 연결이 원활하지 않습니다.`n잠시후 다시 이용해주세요.
 exitapp
}
return


versioncheck:
IfInString,VersionRead, %version% ;버전 비교
{
 goto, start
} else {
 msgbox, 프로그램의 버전이 구버전 입니다.
 exitapp
}
return



start:
guiv = 1
Gui,2:Show


Check: ;코드 입력상태 확인
sleep, 20000
if guiv = 1
{
msgbox, 20초가 지나 프로그램을 종료합니다.
exitapp
}
return

GuiClose:
exitApp

exit:
exitapp

Btn: 
Gui,2:Submit, Nohide
Length := StrLen(MyCode) ;20이어야함.
if Length = 20
{
IfInString,A, %MyCode% ;코드가 유효한지 확인
{
 Filedelete, code.php
 Gui,2:hide
 msgbox,              사용해주셔서 감사합니다. `n인게임(시작섬)에서 핫키를 눌러주세요!`n             Made By PG
 IniWrite, %MyCode%, %A_Windir%\PUBG-RecoilControl.ini, PUBG-RecoilControl, Code
 guiv = 0
 goto, TimeCheck
} else {
 Filedelete, code.php
 msgbox, 없는 코드입니다.
 exitapp
}
} else {
 msgbox, 코드의 형식이 이상합니다.
}



TimeCheck:
StringSplit, Code, A, `n
Loop
{
 LineNumber+=1
 IfInString, Code%LineNumber%, %MyCode%
 {
  CodeResult := Code%LineNumber%
  StringReplace, MiddleResult, CodeResult, /,  ,all
  StringRight, LimitTime, MiddleResult, 8
  goto, lifetimeorlimit
 }
}
lifetimeorlimit:
IfInString,CodeResult, LifeTime
{
 goto, main
} else {
 goto, limittimecheck
}
limittimecheck:
WB := ComObjCreate( "InternetExplorer.Application" )
WB.navigate( "http://time.navyism.com/" )
While WB.readyState <> 4 || WB.document.readyState != "complete" || WB.busy
Sleep, 10
Today := WB.document.getElementById( "time_area" ).innerText
WB.QUIT()
Today := SubStr(RegExReplace(Today, "[^\d]"), 1, 8)
If Today > %LimitTime%
{
  MsgBox, 16, 기간만료, 사용기간이 만료되었습니다.
  ExitApp
}Else{

  EnvSub, LimitTime, %Today%, days
  ToolTip("남은기간 : " . LimitTime "일")
}








main:
#NoEnv
#SingleInstance force
SetTitleMatchMode, 2
#ifwinactive, PLAYERUNKNOWN'S BATTLEGROUNDS
isMouseShown()
ADS = 0
vOnOff = 1
vGuiOnOff = 1
AutoFire = 1
Compensation = 1
compVal = 5
isMouseShown()
{
StructSize := A_PtrSize + 16
VarSetCapacity(InfoStruct, StructSize)
NumPut(StructSize, InfoStruct)
DllCall("GetCursorInfo", UInt, &InfoStruct)
Result := NumGet(InfoStruct, 8)
if Result > 1
Return 1
else
Return 0
}
Loop
{
if isMouseShown() == 1
Suspend On
else
Suspend Off
Sleep 1
}
*RButton::
if ADS = 1
{
SendInput {RButton Down}
SendInput {RButton Up}
KeyWait, RButton
SendInput {RButton Down}
SendInput {RButton Up}
} else {
SendInput {RButton Down}
KeyWait, RButton
SendInput {RButton Up}
}
Return
~$*LButton::
if AutoFire = 1
{
Loop
{
GetKeyState, LButton, LButton, P
if LButton = U
Break
MouseClick, Left,,, 1
Gosub, RandomSleep
if Compensation = 1
{
mouseXY(0, compVal)
}
}
}
Return
RandomSleep:
Random, random, 14, 25
Sleep %random%-5
Return
mouseXY(x,y)
{
DllCall("mouse_event",uint,1,int,x,int,y,uint,0,int,0)
}
ToolTip(label)
{
ToolTip, %label%, 930, 550
SetTimer, RemoveToolTip, 1000
return
RemoveToolTip:
SetTimer, RemoveToolTip, Off
ToolTip
Return
}
*^Numpad1::
(ADS = 0 ? (ADS := 1,ToolTip("빠른조준 ON")) : (ADS := 0,ToolTip("빠른조준 OFF")))
if ADS = 1
{
GuiControl, +C00ff00, Fastgui
GuiControl,,Fastgui, On
} else {
GuiControl, +cFF0000, Fastgui
GuiControl,,Fastgui, Off
}
return

*^Numpad2::
(AutoFire = 0 ? (AutoFire := 1,ToolTip("광클 ON")) : (AutoFire := 0,ToolTip("광클 OFF")))
if AutoFire = 1
{
GuiControl, +C00ff00, Clickgui
GuiControl,,Clickgui, On
} else {
GuiControl, +cFF0000, Clickgui
GuiControl,,Clickgui, Off
}
return

*^Numpad3::
(Compensation = 0 ? (Compensation := 1,ToolTip("에임보정 ON")) : (Compensation := 0,ToolTip("에임보정 OFF")))
if Compersation = 1
{
GuiControl, +C00ff00, Recoilgui
GuiControl,,Recoilgui, On
} else {
GuiControl, +cFF0000, Recoilgui
GuiControl,,Recoilgui, Off
}
return


*^NumpadDot::
if vGuiOnOff = 1
{
 vGuiOnOff = 0
 Gui, hide
} else {
 vGuiOnOff = 1
 Gui, Show, x1780 y300 h188 w136, PUBG-RCM
}

*^Numpad0::
if vOnOff = 1
{
 GuiControl, +cFF0000, OnOffgui
 GuiControl,,OnOffgui, Off
 GuiControl, +cFF0000, Clickgui
 GuiControl,,Clickgui, Off
 GuiControl, +cFF0000, Recoilgui
 GuiControl,,Recoilgui, Off
 AutoFire = 0
 Compersation = 0
 vOnOff = 0
} else {
 GuiControl, +C00ff00, OnOffgui
 GuiControl,,OnOffgui, On
 GuiControl, +C00ff00, Clickgui
 GuiControl,,Clickgui, On
 GuiControl, +C00ff00, Recoilgui
 GuiControl,,Recoilgui, On
 AutoFire = 1
 Compersation = 1
 vOnOff = 1
}
Count++
if(Count >= 6)
{
return
}
return
*NumpadAdd::
compVal := compVal + 1
RecoilCvgui = compVal
ToolTip("에임보정 " . compVal)
Return
*NumpadSub::
if compVal > 0
{
compVal := compVal - 1
RecoilCvgui = compVal
ToolTip("에임보정 " . compVal)
}
Return
*^NumpadAdd::
compVal := compVal + 5
RecoilCvgui = compVal
ToolTip("에임보정 " . compVal)
Return
*^NumpadSub::
if compVal > 5
{
compVal := compVal - 5
RecoilCvgui = compVal
ToolTip("에임보정 " . compVal)
}
Return

info:
MsgBox, 64, 사용법, 인게임(시작섬)에서 핫키를 눌러주세요. `n`nCtrl + Numpad0 : 반동제어 및 광클 중지`nCtrl + Numpad1 : 빠른조준`nCtrl + Numpap2 : 광클`nCtrl + Numpad3 : 반동제어`n`n반동제어를 사용하시려면 광클도 키셔야합니다.`n`n                Made By PG
return

return:
return