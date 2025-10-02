import tkinter as tk

def on_button_click():
    print("Button clicked!")

# Create the main window
root = tk.Tk()
root.title("Button Example")

# Create a button
my_button = tk.Button(root, text="Click Me", command=on_button_click)

# Pack the button into the window
my_button.pack(pady=20) # Add some padding for better aesthetics

# Start the Tkinter event loop
root.mainloop()