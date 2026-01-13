# System Architecture & Flow Diagram

## System Overview

```
┌─────────────────────────────────────────────────────────────────┐
│           SISTEM INFORMASI MINAT JEPANG                         │
│           SMK Yos Sudarso Kawunganten                          │
└─────────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────────┐
│                        USER ROLES                               │
├──────────────┬──────────────────────┬──────────────────────────┤
│   STUDENT    │        ADMIN         │      STAKEHOLDER         │
│              │                      │                          │
│ • Register   │ • Manage Questions   │ • View Analytics         │
│ • Login      │ • View Reports       │ • View Charts            │
│ • Fill Bio   │ • Generate Charts    │ • View Insights          │
│ • Answer     │ • Export CSV         │ • View Recommendations   │
│   Survey     │ • Monitor Stats      │                          │
└──────────────┴──────────────────────┴──────────────────────────┘

┌─────────────────────────────────────────────────────────────────┐
│                     APPLICATION FLOW                            │
└─────────────────────────────────────────────────────────────────┘

                          ┌───────────┐
                          │  Browser  │
                          └─────┬─────┘
                                │
                                ▼
                        ┌───────────────┐
                        │   index.php   │ ◄── Router
                        │   (Router)    │
                        └───────┬───────┘
                                │
                ┌───────────────┼───────────────┐
                │               │               │
                ▼               ▼               ▼
        ┌──────────────┐ ┌──────────────┐ ┌──────────────┐
        │    Auth      │ │   Student    │ │    Admin     │
        │ Controller   │ │ Controller   │ │ Controller   │
        └──────┬───────┘ └──────┬───────┘ └──────┬───────┘
               │                │                │
               │                │                │
               └────────────┬───┴────────────────┘
                            │
                            ▼
                    ┌───────────────┐
                    │   Database    │
                    │ (MySQL/PDO)   │
                    └───────────────┘
                            │
                ┌───────────┼───────────┐
                │           │           │
                ▼           ▼           ▼
        ┌──────────┐ ┌──────────┐ ┌──────────┐
        │  users   │ │ biodata  │ │questions │
        └──────────┘ └──────────┘ └──────────┘
                │           │           │
                └───────────┼───────────┘
                            ▼
                    ┌───────────────┐
                    │  responses    │
                    └───────────────┘

┌─────────────────────────────────────────────────────────────────┐
│                     STUDENT WORKFLOW                            │
└─────────────────────────────────────────────────────────────────┘

    Start
      │
      ▼
   Register ──────► Fill Form ──────► Create Account
      │                                      │
      └──────────────────┬───────────────────┘
                         │
                         ▼
                      Login
                         │
                         ▼
                 Student Dashboard
                         │
          ┌──────────────┼──────────────┐
          │              │              │
          ▼              ▼              ▼
    Fill Biodata   View Progress   Questionnaire
          │              │              │
          │              │              └──► Answer 20 Questions
          │              │                   (Likert Scale 1-5)
          │              │                          │
          │              │                          ▼
          │              │                   Save Responses
          │              │                          │
          └──────────────┴──────────────────────────┘
                         │
                         ▼
                  View Dashboard
                         │
                         ▼
                      Logout

┌─────────────────────────────────────────────────────────────────┐
│                      ADMIN WORKFLOW                             │
└─────────────────────────────────────────────────────────────────┘

    Start
      │
      ▼
    Login (admin/admin123)
      │
      ▼
    Admin Dashboard
      │
      ├───► View Statistics (Students, Responses, etc.)
      │
      ├───► Manage Questions
      │      │
      │      ├──► Add New Question
      │      ├──► Edit Question
      │      ├──► Delete Question
      │      └──► Toggle Active/Inactive
      │
      ├───► View Reports
      │      │
      │      ├──► Category Statistics
      │      ├──► Question Analysis
      │      ├──► View Charts (Chart.js)
      │      │    ├─► Bar Chart
      │      │    └─► Horizontal Bar Chart
      │      │
      │      └──► Export CSV
      │           └─► Download Report
      │
      └───► Logout

┌─────────────────────────────────────────────────────────────────┐
│                   STAKEHOLDER WORKFLOW                          │
└─────────────────────────────────────────────────────────────────┘

    Start
      │
      ▼
    Login
      │
      ▼
    Stakeholder Dashboard
      │
      ├───► View Statistics
      │      ├─► Total Students
      │      ├─► Participation Rate
      │      └─► Overall Average
      │
      ├───► View Category Analysis
      │      ├─► Budaya Jepang
      │      ├─► Pendidikan di Jepang
      │      ├─► Bekerja di Jepang
      │      └─► Bahasa Jepang
      │
      ├───► View Charts
      │      ├─► Bar Chart (Category Averages)
      │      └─► Radar Chart (Interest Profile)
      │
      ├───► View Key Findings
      │      ├─► Highest Interest
      │      ├─► Lowest Interest
      │      └─► Participation Analysis
      │
      ├───► View Recommendations
      │      └─► Automated Suggestions
      │
      └───► Logout

┌─────────────────────────────────────────────────────────────────┐
│                    DATABASE SCHEMA                              │
└─────────────────────────────────────────────────────────────────┘

┌──────────────────┐         ┌──────────────────┐
│      users       │         │     biodata      │
├──────────────────┤         ├──────────────────┤
│ id (PK)          │────┬───►│ id (PK)          │
│ username (UQ)    │    │    │ user_id (FK)     │
│ password         │    │    │ nis              │
│ name             │    │    │ kelas            │
│ role (enum)      │    │    │ jurusan          │
│ created_at       │    │    │ jenis_kelamin    │
│ updated_at       │    │    │ tanggal_lahir    │
└──────────────────┘    │    │ alamat           │
                        │    │ no_telepon       │
                        │    │ email            │
                        │    └──────────────────┘
                        │
                        │    ┌──────────────────┐
                        └───►│    responses     │
                             ├──────────────────┤
                             │ id (PK)          │
                             │ user_id (FK)     │
                             │ question_id (FK) │
                             │ response_value   │
                             │ created_at       │
                             │ updated_at       │
                             └─────────┬────────┘
                                       │
                                       │
┌──────────────────┐         ┌────────┴─────────┐
│   categories     │         │    questions     │
├──────────────────┤         ├──────────────────┤
│ id (PK)          │────────►│ id (PK)          │
│ name             │         │ category_id (FK) │
│ description      │         │ question_text    │
│ order_num        │         │ order_num        │
│ created_at       │         │ is_active        │
└──────────────────┘         │ created_at       │
                             │ updated_at       │
                             └──────────────────┘

┌─────────────────────────────────────────────────────────────────┐
│                    SURVEY STRUCTURE                             │
└─────────────────────────────────────────────────────────────────┘

Category 1: Budaya Jepang (Cultural)
  ├─ Q1: Anime & Manga interest
  ├─ Q2: Traditions & Festivals
  ├─ Q3: Drama & Films
  ├─ Q4: Japanese Food
  └─ Q5: Historical Places

Category 2: Pendidikan di Jepang (Education)
  ├─ Q1: University interest
  ├─ Q2: Education system
  ├─ Q3: Scholarship programs
  ├─ Q4: Career advancement
  └─ Q5: Exchange programs

Category 3: Bekerja di Jepang (Work)
  ├─ Q1: Working in Japanese companies
  ├─ Q2: Internship programs
  ├─ Q3: Work culture
  ├─ Q4: Skill development
  └─ Q5: Salary & benefits

Category 4: Bahasa Jepang (Language)
  ├─ Q1: Learning Japanese
  ├─ Q2: Reading & Writing
  ├─ Q3: Japanese content consumption
  ├─ Q4: Daily communication
  └─ Q5: JLPT examination

Likert Scale: 1 = Strongly Disagree → 5 = Strongly Agree

┌─────────────────────────────────────────────────────────────────┐
│                  SECURITY LAYERS                                │
└─────────────────────────────────────────────────────────────────┘

Layer 1: Authentication
  ├─► Password Hashing (bcrypt)
  ├─► Session Management
  └─► Login Validation

Layer 2: Authorization
  ├─► Role-Based Access Control (RBAC)
  ├─► Route Protection
  └─► Permission Checking

Layer 3: Data Protection
  ├─► SQL Injection Prevention (PDO Prepared Statements)
  ├─► XSS Prevention (HTML Escaping)
  └─► Input Validation

Layer 4: Session Security
  ├─► Session Timeout
  ├─► Session Hijacking Prevention
  └─► CSRF Protection

┌─────────────────────────────────────────────────────────────────┐
│                    TECHNOLOGY STACK                             │
└─────────────────────────────────────────────────────────────────┘

Frontend:
  ├─► HTML5 (Semantic markup)
  ├─► CSS3 (Custom design with variables)
  ├─► JavaScript (ES6+)
  └─► Chart.js v3 (Data visualization)

Backend:
  ├─► PHP 7.4+ (OOP approach)
  ├─► PDO (Database abstraction)
  └─► Session Management

Database:
  └─► MySQL 5.7+ (Relational database)

Architecture:
  └─► MVC Pattern (Model-View-Controller)

Design:
  ├─► Responsive Design (Mobile-first)
  ├─► Blue-White Educational Theme
  └─► Accessibility Considerations

┌─────────────────────────────────────────────────────────────────┐
│                    FILE ORGANIZATION                            │
└─────────────────────────────────────────────────────────────────┘

analisiss-jp/
│
├── config/              ← Configuration & Database
│   ├── database.php
│   └── init.sql
│
├── controllers/         ← Business Logic
│   ├── AuthController.php
│   ├── StudentController.php
│   ├── AdminController.php
│   └── StakeholderController.php
│
├── views/              ← Presentation Layer
│   ├── layouts/
│   ├── admin/
│   ├── student/
│   └── stakeholder/
│
├── public/             ← Static Assets
│   ├── css/
│   ├── js/
│   └── images/
│
└── index.php           ← Entry Point & Router

---

This architecture ensures:
✅ Separation of Concerns
✅ Maintainability
✅ Scalability
✅ Security
✅ User-Friendly Interface
