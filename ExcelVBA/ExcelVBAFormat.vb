
Private Sub Worksheet_Activate()
    Debug.Print "Worksheet_Activate()"
End Sub

Private Sub Worksheet_BeforeDelete()
    Debug.Print "Worksheet_BeforeDelete()"
End Sub

Private Sub Worksheet_BeforeDoubleClick(Byval Target As Range, Cancel As Boolean)
    Cancel = True
    UserForm1.Label1 = Target.Value
    UserForm1.Label4 = Target.Value
    Load UserForm1
    UserForm1.Show
End Sub

Private Sub Worksheet_Calculate()
    Debug.Print "Worksheet_Calculate()"
End Sub

Private Sub Worksheet_Change(Byval Target As Range)
    Debug.Print "Worksheet_Change(Byval Target As Range)"
    Debug.Print Target.Address
    If TypeName(Target.Value) <> "Variant()" Then
        If Cells(Target.Row, 3) = "" Then
            Worksheets(2).Cells(Target.Row, 7) = ""
            Dim i As Integer
            For i = 0 To 9
                Worksheets(1).Cells(Target.Row, i + 1).Clear
            Next i
        End If
    End If
    dbCheck Target
End Sub

Private Sub Worksheet_Deactivate()
    Debug.Print "Worksheet_Deactivate()"
End Sub

Private Sub Worksheet_SelectionChange(Byval Target As Range)
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
    dbCheck Target
End Sub

Public Function dbCheck(Byval Target As Range)
    Dim t As String
    Dim tx As Range
    Dim ii As Integer
    Dim wd As Boolean
    Dim i As Integer
    Dim arr As Validation
    wd = False

    If Not IsError(Target.Value) And TypeName(Target.Value) <> "Variant()" Then
        Debug.Print TypeName(Target.Value)
        For i = 1 To Worksheets(1).Cells(Rows.Count, 1).End(xlUp).Row
            Rem Debug.Print Worksheets(1).Cells(i, 2)
            If Worksheets(1).Cells(i, 2) = Target.Value Then
                wd = True
            End If
        Next i
        If wd = False Then
            F660 Target
        End If
    End If
End Function

Public Function F660(Byval tag As Range)
    'データの読み取り
    'Worksheets(1)に書き込み
    On Error Goto errorABC
        Dim adoconnect As New ADODB.Connection
        Dim adoRecord As New ADODB.Recordset
        Dim connectionString As String
        connectionString = "DRIVER=SQLite3 ODBC Driver;Database=d:\excel\F660A_Total.db"

        If tag.Column = 3 Then
            If tag.Value <> "" Then

                Dim sSQL As String
                sSQL = "Select * from F660A where ""So-net Sn""=" & Chr(39) & tag.Value & Chr(39) & "limit 1"
                adoconnect.Open connectionString
                adoRecord.CursorLocation = adUseClient
                adoRecord.Open sSQL, adoconnect
                Do While Not adoRecord.EOF
                    Dim i As Integer
                    Dim x1 As Integer
                    x1 = Worksheets(1).Cells(Rows.Count, 1).End(xlUp).Row + 1
                    For i = 0 To adoRecord.Fields.Count - 1
                        'Worksheets(1).Cells(x1, i + 1) = Trim(adoRecord(i))
                        Worksheets(1).Cells(tag.Row, i + 1) = Trim(adoRecord(i))
                        Rem Debug.Print adoRecord(i)
                        Rem Debug.Print Worksheets(1).Name
                        Rem Debug.Print Cells(Worksheets(1).Rows.count, 1).End(xlUp).Row
                    Next i
                    adoRecord.MoveNext
                Loop
                adoRecord.Close
                adoconnect.Close
                Set adoRecord = Nothing
                Set adoconnect = Nothing
            End If
        End If

 errorABC:
        Debug.Print "ErrorABC"
End Function

Private Sub Worksheet_TableUpdate(Byval Target As TableObject)

End Sub



