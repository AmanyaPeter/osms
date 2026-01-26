import webview
import subprocess
import threading
import time
import os

def run_django():
    """Start the Django development server."""
    # It's recommended to use the full path to python executable
    # especially when running from a bundled app.
    # For development, 'python3' might be sufficient.
    python_executable = 'python3'
    manage_py_path = os.path.join(os.path.dirname(__file__), 'manage.py')
    subprocess.call([python_executable, manage_py_path, 'runserver'])

if __name__ == '__main__':
    # Start Django server in a new thread
    django_thread = threading.Thread(target=run_django)
    django_thread.daemon = True
    django_thread.start()

    # Give the server a moment to start
    time.sleep(2)

    # Create a webview window
    webview.create_window('Offline School Management System', 'http://127.0.0.1:8000/')
    webview.start()
