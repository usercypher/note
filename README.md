# note

## How to Run

### 1. Download the Project

- Download the project as a ZIP file and extract it.

### 2. Install the Required Binary

- Download the binary for your OS from:
  https://github.com/usercypher/uc/tree/main/bin/uc-web/dist
- Place the binary in the folder `bin/uc-web/dist/`.

### 3. Install PHP and MariaDB

**Linux / macOS**

- Install PHP-FPM (use your distribution's package manager if needed):

      apt install php php-fpm

**Windows**

- Download PHP from https://www.php.net/downloads.php and extract it **into** `bin/php/php-windows-amd64\` (64-bit) or `bin/php/php-windows-386\` (32-bit), so that `php.exe` sits directly at `bin/php/php-windows-amd64\php.exe` (or the 386 equivalent).

> **Windows notes**
>
> - **PHP path:** The folder must be `bin\php\php-windows-amd64\` or `bin\php\php-windows-386\` — `php.exe` directly inside it, not nested in an extra subfolder.
> - **Running scripts:** Run `compile.bat` and `uc-web.bat` from a `cmd` window opened in the project root (`cd` into it first), not by double-clicking — this keeps the console open so you can see errors.
> - **Server window:** Leave the `uc-web.bat` window open; it **is** the server. Closing it stops the app.
> - **chmod:** The `chmod +x` lines in the Linux/macOS block have no Windows equivalent and can be ignored.

### 4. Compile the App

Open a terminal in the project root folder and run:

**Linux / macOS**

    chmod +x compile.sh
    ./compile.sh

**Windows**

    compile.bat

### 5. Configure and Run the Server

**Linux / macOS**

1. Edit `bin/uc-web/uc-web.json` and set the `bin` value to the path of your PHP-FPM binary.
2. Then run (in a separate terminal):

       chmod +x uc-web.sh
       chmod +x bin/uc-web/dist/*
       ./uc-web.sh

**Windows**

- Run `uc-web.bat` from a `cmd` window in the project root.
- The Windows setup is automatic after placing the PHP binary in `bin\php\php-windows-amd64\` or `bin\php\php-windows-386\` (see Step 3).
- Leave the window open — it **is** the server.

### 6. Database Management (Adminer)

Adminer is included for SQLite database management.

Open:

**http://127.0.0.1:8080/adminer**

#### Login

- **127.0.0.1:** Leave the password empty.
- **Other IPs:** Default password is `root`.

To change the password or allowed IPs, edit:

```text
src/Adminer/res/index.php
```

#### Database

| Field | Value |
|---|---|
| System | `sqlite` |
| Database | `../var/lib/.sqlite` |
