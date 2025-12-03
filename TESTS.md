# TESTS.md – Application Security Testing Documentation

This document describes how security testing was conducted on both the baseline (v0) and hardened (v1) versions of the College Management System.  
It includes the manual DAST tests, input validation checks, and SAST scanning performed by each team member.  
Below is the testing completed by **Member 2 – Pratham** on the baseline version.

---
## 1 Testing v0 – Member 1: Muneeb

This section summarises the baseline (v0) testing I performed using manual DAST techniques and controlled input manipulation.

### 1.1 Vulnerability V7 – Error Disclosure / Full Path Disclosure

OWASP Mapping: A05 – Security Misconfiguration
Security Requirement Mapping: S_6 – Logging & Monitoring

#### Test Description

To examine how the backend handled unexpected input, I tested the Student Registration form (reg1.html).
I submitted the following malformed payload inside one of the text fields:

");--


When the form was submitted, the request was processed by reg-insert.php.
Instead of responding with a safe validation error, the system displayed full PHP and MySQL error messages in the browser.
This output revealed the full server path, file name, line numbers and underlying SQL errors.

#### Result

The backend leaked detailed internal information directly to the user.
This confirmed an Error Disclosure / Full Path Disclosure vulnerability and violated S_6 Logging & Monitoring.

### 1.2 Vulnerability V10 – Plaintext Password Storage

OWASP Mapping: A02 – Cryptographic Failures
Security Requirement Mapping: S_1 – Authentication

#### Test Description

I reviewed the authentication workflow and inspected the login tables in phpMyAdmin.
Passwords were stored exactly as entered, with no hashing or encryption applied.
The login script also compared passwords directly using plaintext string matching.

#### Result

Because passwords were stored and validated in an unencrypted format, the system was vulnerable to credential exposure.
This confirmed the Plaintext Password Storage issue, violating S_1 Authentication.

## 2 Testing v1 – Member 1: Muneeb
### 2.1 Fixed Vulnerability V7 – Error Disclosure / Full Path Disclosure

Security Requirement Mapping: S_6 – Logging & Monitoring

#### 2.2 Test Description

After implementing the fix in reg-insert.php to disable on-screen error output and enable internal logging, I resubmitted the same test payload:

");--

#### 2.3 Result

Instead of displaying PHP/MySQL warnings, the application now redirects to:

reg1.php?error=1


No file paths, stack traces or SQL details are exposed.
All technical information is now logged internally, confirming the vulnerability is resolved.

### 3 Fixed Vulnerability V10 – Plaintext Password Storage

Security Requirement Mapping: S_1 – Authentication

#### 3.1 Test Description

Password creation and login handling were updated to use PHP’s native hashing functions (password_hash() and password_verify()).
I created a new user and inspected the stored credential format.

#### 3.2 Result

Passwords are now stored as hashed values instead of plaintext.
Login works correctly using password_verify(), confirming the cryptographic failure has been addressed.


## 4.2 Testing v0 – Member 2: Pratham

This section summarises the baseline (v0) testing performed using manual DAST techniques and a Semgrep SAST scan.

---

### 4.2.1 Vulnerability V1 – Broken Access Control  
**OWASP Mapping:** A01 – Broken Access Control  
**Security Requirement Mapping:** S_3 – Authorization  

#### Test Description
To verify whether admin-only pages were properly restricted, I first logged in as an admin and noted the URLs of several admin pages, including:

- adminindex.php  
- Managecontact.php  
- Manageblog.php  
- ManageStudent.php  
- courseManage.php  
- courseADD.php  

I then logged out and attempted to access the ManageStudent.php  directly in the browser, including using an incognito window to confirm there was no active session.

#### Result  
ManageStudent.php page still loaded without authentication and displayed sensitive administrative and student data.  
This confirmed a **Broken Access Control** vulnerability and violated **S_3 Authorization**.

---

### 4.2.2 Vulnerability V4 – Stored XSS in Admin Panel  
**OWASP Mapping:** A03 – Injection (XSS)  
**Security Requirement Mapping:** S_5 – Input Validation  

#### Test Description
To check for improperly sanitised input, I tested the public comment feature available in `blog.html`.  
I submitted the following malicious payload:
`<script>alert(1)</script>`
After submitting the comment, I opened the admin page Manageblog.php to see how the stored input was rendered.

#### Result  
The payload was stored in the database without validation and executed automatically when viewed in the admin panel.
This confirmed a Stored XSS vulnerability and violated S_5 Input Validation.

---

### 4.2.3 Semgrep SAST Scan

#### Test Description
To supplement manual DAST testing, I performed a Semgrep SAST scan on the baseline v0 codebase using:


This scanned all PHP, HTML, and related files for OWASP Top 10 vulnerability patterns.

#### Result
Semgrep successfully analysed the codebase and flagged a manually constructed SQL query in `blog-insert.php` as a **potential SQL Injection** risk.  
However, Semgrep did **not** detect the stored XSS vulnerability discovered during manual testing, showing that DAST/manual testing was necessary to identify certain issues.

----

## 6.2 Testing v1 – Member 2: Pratham

### 6.2.1 Fixed Vulnerability V1 – Broken Access Control  
**Security Requirement Mapping:** S_3 – Authorization  

#### Test Description  
After implementing session-based access control, I retested the previously vulnerable admin pages such as `ManageStudent.php` by attempting to access them directly through the browser URL in an incognito window. This simulates an unauthenticated user attempting to bypass the login process.

#### Result  
The application now correctly prevents access to admin pages when no valid session exists.  
Any attempt to open admin pages directly results in a redirect to `adminLogin.php`, ensuring no sensitive content is exposed.

This confirms that **Broken Access Control is successfully fixed**, and **Security Requirement S_3 (Authorization)** is now properly enforced.

### 6.2.2 Fixed Vulnerability V4 – Stored XSS in Admin Panel  
**Security Requirement Mapping:** S_5 – Input Validation  

#### Test Description  
To verify the fix for Stored XSS, I resubmitted the same malicious payload used during v0 testing:
`<script>alert(1)</script>`
After submitting the comment, I opened the admin page Manageblog.php to check how the stored input was displayed.

#### Result  
The malicious <script> payload no longer executes. Instead of triggering an alert, the characters are now safely escaped and shown as plain text.
This confirms that input sanitisation and output encoding have been applied correctly.
The Stored XSS vulnerability is now fully resolved, and Security Requirement S_5 – Input Validation is successfully implemented.
