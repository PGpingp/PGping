#SingleInstance force  ;로딩창을 재실행 할때의 확인창 무시
pix := ATan(1)*4  ;파이(3.14)
piy := ATan(1)*4  ;파이(3.14)
Gui +LastFound -caption +AlwaysOnTop
WinSet, TransColor, F0F0F0
Gui, Font, s6
Loop, 25
Gui, Add, Text, x-10 y-10 cRed, ●  ;안보이는곳에 ●를 추가합니다.
Gui, Font, s15 bold
Gui, Add, Text, x150 y185, Loading...
Gui, Show, w400 h400
Loop
  Loop, 25
  {
    xPo := 190+sin(pix-=0.2)*60  ;x축으로 a+six(pi)*r를 연산합니다. a는 시작 좌표, r은 반지름 값이에요.
    yPo := 190+cos(piy-=0.2)*60  ;y축으로 a+cos(pi)*r를 연산합니다. a는 시작 좌표, r은 반지름 값이에요.
    Guicontrol, Move, Static%A_Index%, x%xPo% y%yPo%
    sleep, 15
  }
Return