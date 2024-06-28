import sys
import os
from tkinter import *
from tkinter import ttk


#===============
#蛻晄悄繝代Λ繝｡繝ｼ繧ｿ
#===============
xrange = [0, 10]

window_size = "500x200"


#=======================================
# path繝懊ち繝ｳ繧偵け繝ｪ繝�け縺輔ｌ縺溘→縺阪�蠢懃ｭ�
# var縺ｫentry繧ｦ繧｣繧ｸ繧ｧ繝�ヨ縺ｫ邨舌�縺､縺代ｉ繧後◆StringVar繧呈ｸ｡縺�
#=======================================
def path_button_click(var):
    path = filedialog.askopenfilename(filetypes = file_type, initialdir = ini_dir)
    var.set(path)


def main():
# Root繧ｦ繧｣繝ｳ繝峨え菴懈�
    root = Tk()
    root.title('Arrhenius plot')
#    root.resizable(False, False)
    root.geometry(window_size)
# Root繧ｦ繧｣繝ｳ繝峨え縺ｮ譛蟆上し繧､繧ｺ
    root.minsize(200, 200)

# entry繧ｦ繧｣繧ｸ繧ｧ繝�ヨ縺ｮ螟画焚
    path = StringVar()
    x0 = DoubleVar(value = xrange[0])
    x1 = DoubleVar(value = xrange[1])

# Menu
    menu_bar = Menu(root)
    menu_file = Menu(menu_bar, tearoff = 0)
    menu_file.add_command(label='Open', accelerator='Ctrl+O',
                    command = lambda: path_button_click(path))
    menu_file.add_command(label='exit', accelerator='Alt+E',
                    command = lambda: exit())
    menu_bar.add_cascade(label = 'File', menu = menu_file)
    root.config(menu = menu_bar)
    root.grid()

# Root frame
    root_frame = ttk.Frame(root, padding=10)
    root_frame.pack(side = 'top')

# Path frame
    path_frame = ttk.Frame(root_frame)
    path_label = ttk.Label(path_frame, text = 'Path:', padding = (5,2))
    path_label.pack(side = 'left')
    path_entry = ttk.Entry(
        path_frame,
        textvariable = path,
        width = 50
        )
    path_entry.pack(side = 'left', expand = True)

    path_button = ttk.Button(path_frame, text = 'path', 
                    command = lambda: path_button_click(path))
    path_button.pack(side = 'left')
    path_frame.pack(side = 'top', anchor = 'w')

# Range frame
    range_frame = ttk.Frame(root_frame)
    range_label = ttk.Label(range_frame, text = 'x range:', padding = (5,2))
    range_label.grid(row = 1, column = 0, sticky = 'w')
    x0_entry = ttk.Entry(
        range_frame,
        textvariable = x0,
        width = 10)
    x0_entry.grid(row = 1, column = 1)

    range_label2 = ttk.Label(range_frame, text = '-', padding = (5,2))
    range_label2.grid(row = 1, column = 2, sticky = E)
    x1_entry = ttk.Entry(
        range_frame,
        textvariable = x1,
        width = 10)
    x1_entry.grid(row = 1, column = 3)
    range_frame.pack(side = 'top', anchor = 'w')

# Button frame
    button_frame = ttk.Frame(root_frame)
    plot_button = ttk.Button(button_frame, text = 'plot')
    plot_button.pack(side = 'left')
    exit_button = ttk.Button(button_frame, text = 'exit', command = lambda: exit())
    exit_button.pack(side = 'left')
    button_frame.pack(side = 'top', anchor = 'w')
    
    root.mainloop()


if __name__ == '__main__':
    main()
    