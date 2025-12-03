# CA_3_Application_Security_Year_4_G9
CA3 Application Security Project Group 9 : Fixing the Vulnerabilities by applying S-SDLC activities. 

We analysed a vulnerable PHP/MySQL college management web app and then created a hardened version with security fixes.

---

## Application provenance (baseline source)

Original base code:  
https://github.com/Rohitlakha/college-management-system-php/

In this repository:

- `baseline_v0/` – unmodified copy of the original application (used as our baseline).
- `hardened_v1/` – our improved version with all implemented security changes.

---

## Prerequisites

- XAMPP (Apache + MySQL)
- PHP 7.x or later (included with XAMPP)
- Web browser (Chrome / Edge / Firefox)

These instructions assume the default XAMPP folders:

- **Windows:** `C:\xampp\htdocs\`
- **macOS:** `/Applications/XAMPP/htdocs/`

---

## Database setup

1. Start **Apache** and **MySQL** from the XAMPP Control Panel.  
2. Open phpMyAdmin at: `http://localhost/phpmyadmin`.  
3. Create a new database with the **exact** name: "University"
