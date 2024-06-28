Private Sub Worksheet_BeforeDoubleClick(Byval Target As Range, Cancel As Boolean)
    Debug.Print "Worksheet_BeforeDoubleClick"
    Dim startRow As Integer
    Dim numCount As Integer
    If Target.Column = 4 Then
        startRow = 0
        numCount = 0
        Application.EnableEvents = False
        If Target.Value <> Cells(Target.Row - 1, Target.Column).Value Then
            Do
                startRow = startRow + 1
                If IsEmpty(Cells(Target.Row + startRow, 15)) Then
                    Cells(Target.Row + startRow, 4) = Target.Value
                    numCount = numCount + 1
                End If
            Loop While numCount < 11

            Cells(Target.Row + startRow + 1, 4) = Target.Value + 1
            If Target.Value > 1 Then
                Sheet8.Cells(1, 1) = Target.Value - 1
                Sheet8.PsyBcLbl1.Value = Sheet8.Range("B5")
                Sheet8.PsyBcLbl2.Value = Sheet8.Range("B6")
                Sheet8.PsyBcLbl3.Value = Sheet8.Range("B7")
                Sheet8.PsyBcLbl4.Value = Sheet8.Range("B8")
                Sheet8.PsyBcLbl5.Value = Sheet8.Range("B9")
                Sheet8.PsyBcLbl6.Value = Sheet8.Range("B10")
                Sheet8.PsyBcLbl7.Value = Sheet8.Range("B11")
                Sheet8.PsyBcLbl8.Value = Sheet8.Range("B12")
                Sheet8.PsyBcLbl9.Value = Sheet8.Range("B13")
                Sheet8.PsyBcLbl10.Value = Sheet8.Range("B14")
                Sheet8.PsyBcLbl11.Value = Sheet8.Range("B15")
                Sheet8.PsyBcLbl12.Value = Sheet8.Range("B16")

                Dim result As VbMsgBoxResult
                result = MsgBox("打印大箱票(集合箱ラベル印刷)", vbOKCancel, "ラベル印刷")

                If result = vbOK Then
                    'Application.ActivePrinter = "Brother HL-L3230CDW series   上青木"
                    'Sheet8.PrintOut copies:=2, ActivePrinter:="Brother HL-L3230CDW series   上青木"
                    'Sheet8.PrintOut copies:=2, ActivePrinter:="Microsoft Print To PDF", Preview:=False
                    'Sheet8.PrintOut copies:=2, ActivePrinter:="ZDesigner ZT610-300dpi ZPL (NPC-2101-456 上)"
                    'Sheet8.PrintOut , , copies:=2, ActivePrinter:="ZDesigner ZT610-300dpi ZPL (NPC-2101-456 上)"
                    'Sheet8.PrintOut , , copies:=2, ActivePrinter:="\\192.168.1.13\ZDesigner ZT610-300dpi ZPL"
                End If
            End If
            Cells(Cells(Rows.Count, 5).End(xlUp).Row + 1, 5).Activate
            ThisWorkbook.Save
            Sheet3.Activate
        End If
        Application.EnableEvents = True
    End If
End Sub

