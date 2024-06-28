from pystrich.qrcode import QRCodeEncoder
from pystrich.code128 import Code128Encoder
from pystrich.ean13 import EAN13Encoder
from pyzbar.pyzbar import decode
from PIL import Image

encoder = QRCodeEncoder("600300563001")
encoder.save("01.png")

encoder = EAN13Encoder("600300563001")
encoder.save("02.png")

encoder = Code128Encoder("600300563001-00001", options={"show_label": False})
encoder.save("03.png")

print(decode(Image.open('01.png'))[0])
print(decode(Image.open('02.png'))[0].data.decode())
print(decode(Image.open('03.png'))[0].data.decode())

import win32print

def get_printer_list():
    """
    Windows環境で利用可能なプリンタの一覧を取得する関数。

    この関数はwin32printモジュールを使用して、システムにインストールされている
    プリンタの一覧を取得します。

    Returns:
        list: 利用可能なプリンタの名前のリスト。
    """
    # インストールされているプリンタの一覧を取得します。
    printers = win32print.EnumPrinters(win32print.PRINTER_ENUM_LOCAL, None, 1)
    
    # 取得したプリンタの情報からプリンタ名のみを抽出してリスト化
    printer_names = [printer[2] for printer in printers]

    # プリンタ名のリストを返す。
    return printer_names


if __name__ == "__main__":

    # 利用可能なプリンタの一覧を取得
    printer_list = get_printer_list()

    # 取得したプリンタの名前を1行ずつ表示
    print("プリンタ一覧")
    for printer in printer_list:
        print(printer)