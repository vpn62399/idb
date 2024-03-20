from kivy.app import App
from kivy.uix.button import Button
from kivy.uix.boxlayout import BoxLayout
from kivy.uix.label import Label
from kivy.uix.textinput import TextInput
from kivy.storage.jsonstore import JsonStore

from datetime import datetime
import sqlite3
import os

print(__file__)
print("kkk", __file__)
print(os.path.dirname(__file__))
print(os.path.abspath(__file__))
exit()


class MyStorageApp(App):

    conn = sqlite3.connect("./data.db")
    cur = conn.cursor()

    mydata = JsonStore("./mydata.json")

    countnum = 0
    now = "now"

    def gettime(self):
        return str(datetime.now())

    def getData(self):
        self.entry = self.mydata.get("data")

        print(self.entry)

    # layout
    def build(self):

        layout = BoxLayout(padding=100, orientation="vertical")
        btn1 = Button(text="PUSH")
        btn1.bind(on_press=self.buttonClicked)

        self.lbl1 = Label(text="count is " + str(self.countnum))
        self.lbl2 = Label(text=self.now)

        layout.add_widget(btn1)
        layout.add_widget(self.lbl1)
        layout.add_widget(self.lbl2)

        return layout

    # button click function
    # "bind" need "instance" arg (this case is "btn" arg)
    # http://stackoverflow.com/questions/23127203/bind-function-to-kivy-button
    def buttonClicked(self, btn):
        self.countnum += 1
        self.lbl1.text = "count is " + str(self.countnum)

        self.now = self.gettime()

        self.lbl2.text = self.now
        type(self)

        try:
            self.cur.execute("""CREATE TABLE times(time text, count int);""")
        except:
            pass

        self.cur.execute(
            """INSERT INTO times VALUES(:time, :count)""",
            {"time": self.now, "count": self.countnum},
        )
        self.conn.commit()

        self.cur.execute("select * from times")
        for row in self.cur:
            print(row[0], row[1])
            self.mydata.put("data", mytime=row[0], mycount=row[1])

        self.getData()

        print("done")


# run app
if __name__ == "__main__":
    MyStorageApp().run()
