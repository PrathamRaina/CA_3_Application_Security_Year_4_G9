# TESTS.md – Application Security Testing Documentation

This document describes how security testing was conducted on both the baseline (v0) and hardened (v1) versions of the College Management System.  
It includes the manual DAST tests, input validation checks, and SAST scanning performed by each team member.  
Below is the testing completed by **Member 2 – Pratham** on the baseline version.

---

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
