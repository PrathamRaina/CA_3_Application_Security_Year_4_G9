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
4. Import the university.sql file onto the dataabse.

--- 

## Running the Baseline Version (v0)

1. Copy the contents of **`baseline_v0/`** into your XAMPP web root folder:

   - **Windows:** `C:\xampp\htdocs\college-management-system-main`
   - **macOS:** `/Applications/XAMPP/htdocs/college-management-system-main`

2. Open the application's database configuration file  
   (e.g. `connection.php`, `config.php`, or similar) and ensure it contains:

   ```php
   $servername = "localhost";
   $username   = "root";
   $password   = "";              // default XAMPP setting
   $dbname     = "university";    // must be exactly 'university'

3. Open the Baseline v1 in the browser using the link: http://localhost/college-management-system-main/

  ***Note*** : Make sure the College-management-system-main in URL above is same as the name folder you save the downloaded files from this github Repo.

## Running the Hardened Version (v1)

To run the secured version:

1. Copy the contents of **`hardened_v1/`** into your XAMPP web root, for example:

   - **Windows:** `C:\xampp\htdocs\college-management-system-main-fixed`
   - **macOS:** `/Applications/XAMPP/htdocs/college-management-system-main-fixed`

2. Confirm that the database settings (in `connection.php` or `config.php`) are:

   ```php
   $servername = "localhost";
   $username   = "root";
   $password   = "";
   $dbname     = "university";   // must match the database created earlier

 ***Note*** : Make sure the College-management-system-main in URL above is same as the name folder you save the downloaded files from this github Repo.
