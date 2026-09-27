# <img width="30" height="30" alt="logo-icon-512" src="https://github.com/user-attachments/assets/1f527729-d739-4c24-988f-509056c8e63b" /> LegalAid — Online Lawyer Booking and Legal Case Management System

A web-based legal service platform designed to connect clients with lawyers, simplify appointment booking, and provide an organized system for managing legal cases, reports, and user accounts.

---

## <img width="19" height="19" alt="image" src="https://github.com/user-attachments/assets/0ce9f1d6-55a3-4fcb-845b-f044227c07c3" /> American International University-Bangladesh (AIUB)

**Department:** Computer Science

**Course:** 01005 – Web Technologies

**Semester:** Summer 2025-2026

**Section:** B

**Group:** 10

### Supervised By:

**Tofayet Sultan**

Lecturer

Department of Computer Science

American International University-Bangladesh (AIUB)

---

## 👨‍💻 Developed By

### Jannatul Masiyat

### Sadia Aniqua

### Marufa Yeasmin

### Taha Bin Amanot Ullah

---

# ⚖️ Project Overview

**LegalAid** is a web-based legal service platform that connects clients with lawyers.

Clients can search for verified lawyers based on their specialization, view professional information, book appointments, manage appointments, and monitor their legal cases.

Lawyers can manage their profiles, accept or reject appointment requests, create and manage cases, and monitor appointment and case statistics.

Administrators can manage users and lawyers, verify lawyers, review reports, and take action against fraudulent users.

---

# 🎯 Project Objectives

* Provide a centralized platform for finding lawyers
* Allow clients to search lawyers based on specialization
* Enable online appointment booking
* Allow lawyers to manage appointments and cases
* Provide separate dashboards for different user roles
* Support lawyer verification
* Provide user reporting and fraud management
* Organize legal case information in one platform

---

# 👥 User Types

### 👤 Client

Clients can search for lawyers, book appointments, manage appointments, view legal cases, and submit reports.

### ⚖️ Lawyer

Lawyers can manage their professional profiles, handle appointment requests, manage cases, and view relevant client information.

### 🛡️ Administrator

Administrators manage users and lawyers, verify lawyers, review reports, and manage fraudulent accounts.

---

# ✨ Key Features

## 🔐 Authentication & Account Management

* User Registration
* Login
* Logout
* Change / Reset Password
* Profile Management
* Account Management
* Role-based Dashboards

Users are redirected to a dashboard according to their role:

```text
Client  → Client Dashboard
Lawyer  → Lawyer Dashboard
Admin   → Admin Dashboard
```

---

# 👤 Client Features

### 🔍 Find Lawyers

Clients can search for verified lawyers using:

* Lawyer Name
* Legal Specialization

The platform also uses **AJAX search** so lawyer results can be searched dynamically without completely reloading the page.

### 📅 Book Appointment

Clients can select a lawyer and submit an appointment request with:

* Date
* Time
* Reason

### 📋 Manage Appointments

Clients can:

* View appointments
* View appointment details
* Cancel appointments
* Request rescheduling

### ⚖️ Manage Legal Cases

Clients can view:

* Lawyer
* Case Title
* Case Type
* Description
* Status

### 🚨 Report Users

Clients can report potentially fraudulent lawyers or other users.

### 📊 Reports & Statistics

Clients can view appointment and case summaries.

---

# ⚖️ Lawyer Features

### 👨‍⚖️ Manage Lawyer Profile

Lawyers can manage:

* Specialization
* Experience
* Chamber Name
* Address
* Bio
* Consultation Fee

### 📅 Manage Client Bookings

Lawyers can:

* View appointment requests
* Accept appointments
* Reject appointments

### 📁 Manage Legal Cases

Lawyers can:

* Create cases
* View cases
* Update case status

Available case statuses include:

```text
Open
In Progress
Completed
Closed
```

### 📊 Reports & Statistics

Lawyers can view appointment and case statistics.

### 👤 View Client Information

Lawyers can view relevant client information associated with their bookings and cases.

---

# 🛡️ Administrator Features

### 👥 Manage Users

Administrators can view and manage registered users.

### ⚖️ Manage Lawyers

Administrators can view registered lawyers and their information.

### ✅ Lawyer Verification

Administrators can verify lawyer profiles before they become available to clients.

Verification statuses:

```text
Pending
Verified
Rejected
```

### 🚨 Manage Reports

Administrators can review reports submitted against users, including:

* Reporter
* Reported User
* Appointment
* Reason
* Description
* Report Status

### 🚫 Ban Fraudulent Users

Administrators can change a fraudulent user's account status to **Banned**.

### 📊 Administrative Dashboard

The admin dashboard provides centralized access to system monitoring and management functions.

---

# 🖥️ User Interface

The project includes several interfaces designed for different users and functions.

### 🏠 Landing Page

The homepage provides options for users to **Login** or **Register**.

### 🔐 Login Page

Users can log in using their registered email and password, with client-side field validation.

### 👤 Client Dashboard

Provides quick access to:

* Edit Profile
* Find Lawyer
* My Appointments
* My Cases
* Reports

### ⚖️ Lawyer Profile

Displays professional information such as:

* Specialization
* Experience
* Chamber
* Consultation Fee

### 🔎 Find a Lawyer

Displays verified lawyers with filters for:

* Name
* Specialization
* Experience
* Chamber
* Consultation Fee

### 📅 Book Appointment

Allows clients to select a lawyer and schedule a consultation by choosing a date, time, and reason.

### 🛡️ Admin Dashboard

Provides administrative pages for:

* Registered Lawyers
* Reports & Complaints
* All Cases
* User Management

The project documentation includes UI designs for these interfaces.

---

# 🔄 System Workflow

```text
                    ┌──────────────┐
                    │   LegalAid   │
                    │   Platform   │
                    └──────┬───────┘
                           │
             ┌─────────────┼─────────────┐
             ↓             ↓             ↓
          Client         Lawyer        Admin
             │             │             │
             ↓             ↓             ↓
        Find Lawyer    Manage Profile  Manage Users
             │             │             │
             ↓             ↓             ↓
        Book Appt.     Manage Appts.  Verify Lawyers
             │             │             │
             ↓             ↓             ↓
        Manage Cases   Manage Cases    Manage Reports
             │             │             │
             └─────────────┼─────────────┘
                           ↓
                    LegalAid System
```

---

# 🗃️ System Design

The project includes an **ER Diagram** and **Use Case Diagram** to represent the system's data relationships and user interactions.

The system is organized around three primary roles: **Client, Lawyer, and Administrator**, with features assigned according to each user's role.

**ER Diagram**

<img width="491" height="528" alt="image" src="https://github.com/user-attachments/assets/ac335fbd-dd1d-4fb3-b1b3-d9a583a8fe1f" />

**Use Case Diagram**

<img width="439" height="539" alt="image" src="https://github.com/user-attachments/assets/21495018-fe18-4e1d-b246-88edd7f399f1" />


---

# 🔑 Important System Functions

| Function               | Purpose                                  |
| ---------------------- | ---------------------------------------- |
| User Registration      | Creates a new user account               |
| Login                  | Authenticates users                      |
| Logout                 | Ends the user session                    |
| Profile Management     | Updates user information                 |
| Lawyer Search          | Finds lawyers by name or specialization  |
| Appointment Booking    | Allows clients to request consultations  |
| Appointment Management | Handles appointment requests and changes |
| Case Management        | Creates and manages legal cases          |
| Lawyer Verification    | Allows admin to verify lawyers           |
| User Reporting         | Reports potentially fraudulent users     |
| User Management        | Allows admin to manage registered users  |
| Statistics             | Provides appointment and case summaries  |

---

# 📚 Learning Outcomes

Through this project, the team demonstrates practical understanding of:

* Web-based application development
* User authentication
* Role-based access
* Database-driven systems
* Appointment management
* CRUD-based functionality
* AJAX-based dynamic searching
* Dashboard design
* Case management
* User reporting and administration
* UI/UX design

---

# 📸 Screenshots

### 🏠 Landing Page

<img width="958" height="433" alt="image" src="https://github.com/user-attachments/assets/97e20dba-755e-4120-a694-dad12186334e" />


### 🔐 Login Page

<img width="958" height="433" alt="image" src="https://github.com/user-attachments/assets/d2e25fbe-8449-4966-b14a-d4bbaf6d98d1" />


### 👤 Client Dashboard

<img width="740" height="433" alt="image" src="https://github.com/user-attachments/assets/9a4c5e38-5157-49df-858b-cfdbec6608cc" />


### 🔎 Find Lawyer

<img width="825.5" height="431" alt="image" src="https://github.com/user-attachments/assets/171d23bb-0515-4bec-9265-f41d552cafbf" />


### 📅 Book Appointment

<img width="718" height="432.5" alt="image" src="https://github.com/user-attachments/assets/d9fb29da-086a-45d5-be69-829fbbb6e723" />


### ⚖️ Lawyer Dashboard

<img width="751" height="435" alt="image" src="https://github.com/user-attachments/assets/f0184d90-c80a-44c1-b74e-a4e5b591f4e2" />


### 🛡️ Admin Dashboard

<img width="743" height="433.5" alt="image" src="https://github.com/user-attachments/assets/08e0c403-a3a1-4cf1-9949-5c40bd9d29b7" />


---

# 🚀 How to Run

### Clone the Repository

```bash
git clone https://github.com/your-username/LegalAid.git
```

### Open the Project

Open the project using your preferred web development environment.

### Configure the Database

Set up the required database and application configuration.

### Run the Project

Start the local web server and open the application in your browser.

### Start Using LegalAid ⚖️

Register or log in according to your user role and access the available features.

---


