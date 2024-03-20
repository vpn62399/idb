' VBA 文字コードを

i = Asc("a")
Debug.Print(i) '97

Debug.Print Asc("0")  '48
Debug.Print Asc("9")  '57

Debug.Print Asc("A")  '65
Debug.Print Asc("Z")  '90

Debug.Print Asc("a")  '97
Debug.Print Asc("z")  '122

chr(39)  '
chr(34)  "
Chr(37)    ' Returns %.
Chr(32)    半角スペース


=AND(VALUE(B9)>VALUE("2015/01/01"),VALUE(B9)<VALUE("2022/12/31"))
=LEN(C9)=4	="F660A-"&$C$9&"-G"	="F660A-"&$C$9&"-A"
=LEN(F9)=8	=AND(LEN(G9)=16,SEARCH("5A544",G9))
=LEN(H9)=12
=LEN(I9)=12
=AND(LEN(J9)=12,SEARCH("NFZT60",J9))
=SEARCH("NFZT", @C:C)			

ZXHN F660A


カーソル移動、日付入力のマクロ
Private Sub Worksheet_SelectionChange(ByVal Target As Range)
    Debug.Print "Worksheet_SelectionChange(Byval Target As Range)"
    Dim returnLine As Integer
    Dim sline As Integer
    Dim eline As Integer

    sline = 3
    eline = 4

    '日付の入力
    If Cells(Target.Row, 3) <> "" And Cells(Target.Row, 7) = "" Then
        Cells(Target.Row, 7) = Date
    End If

    'カーソルの移動
    If Target.Column = eline Then
        Cells(Target.Row + 1, sline).Activate
    End If

End Sub