# Online Career and Job Portal System

A complete web-based job portal connecting Students (Job Seekers), Companies (Recruiters), Career Counselors, and Admins on a single platform.

## Technologies Used
- HTML
- CSS (Basic - White, Blue, Red color scheme)
- JavaScript (ES5 - XMLHttpRequest for Ajax)
- PHP (Procedural - No OOP)
- MySQL (Simple queries - No prepared statements)

## Features

### Common Features (All Users)
- Login / Logout
- User Registration (4 types)
- Change Password
- Reset Password
- Profile Management
- Role-based Dashboard

### Student Features
1. Profile Completion Percentage
2. Edit Resume
3. Upload Video Resume
4. View Career Counselor Profiles
5. Apply for Consultations
6. View Job Listing
7. Search Jobs by Category
8. Shortlist Jobs
9. Apply For Jobs
10. View Application Status

### Company Features
1. View Job Post List
2. Create Job Post
3. Edit Job Post
4. Delete Job Post
5. View Applicant List
6. Shortlist Candidates
7. Resume Download
8. Schedule Interviews
9. Edit Interview Details
10. Result Management
11. Track Job Post Performance

### Career Counselor Features
1. View Applicant List
2. Receive Appointment Requests
3. Create Consultation Sessions
4. Edit Session Details
5. View Session List
6. Review Student Resume
7. Feedback Session
8. Track Applicant Placement Status

### Admin Features
1. View all Users
2. Approve Company Account Request
3. Reject Company Account Request
4. Approve Counselor Account Request
5. Reject Counselor Account Request
6. Block User Account
7. Approve Job Post
8. Mark User as Fraud

## Installation Instructions

### Prerequisites
- XAMPP installed on your computer
- Web browser (Chrome, Firefox, etc.)

### Step 1: Setup Project
1. Copy the entire `Nayeem` folder to `C:\xampp\htdocs\`
2. The project path should be: `C:\xampp\htdocs\Nayeem\`

### Step 2: Create Database
1. Start XAMPP Control Panel
2. Start **Apache** and **MySQL** services
3. Open browser and go to: `http://localhost/phpmyadmin/`
4. Click on **Import** tab
5. Click **Choose File** and select `database.sql` from the project folder
6. Click **Go** to import the database
7. Database `job_portal` will be created with sample data

### Step 3: Run the Application
1. Open browser and go to: `http://localhost/Nayeem/`
2. You will see the homepage with Login and Register buttons

## Default Login Credentials

### Admin Account
- Username: `admin`
- Password: `password`

### Student Account
- Username: `john_doe`
- Password: `password`

### Company Account (Pending Approval)
- Username: `techcorp`
- Password: `password`
- *Note: Admin needs to approve this account first*

### Counselor Account (Pending Approval)
- Username: `dr_smith`
- Password: `password`
- *Note: Admin needs to approve this account first*

## Folder Structure

```
Nayeem/
├── controller/          # All controller files (business logic)
│   ├── loginController.php
│   ├── registrationController.php
│   ├── logoutController.php
│   └── ... (separate file for each feature)
│
├── model/              # All model files (database operations)
│   ├── db.php
│   ├── loginModel.php
│   ├── studentModel.php
│   └── ... (separate file for each feature)
│
├── view/               # All view files (UI)
│   ├── login.php
│   ├── registration.php
│   ├── student/       # Student views
│   ├── company/       # Company views
│   ├── counselor/     # Counselor views
│   └── admin/         # Admin views
│
├── asset/
│   ├── css/
│   │   └── style.css
│   ├── js/
│   │   ├── validation.js    # JavaScript validation
│   │   └── ajax.js          # Ajax/JSON functions
│   └── uploads/
│       ├── resumes/         # Resume files
│       └── videos/          # Video resume files
│
├── database.sql        # Database schema and sample data
└── index.php          # Entry point
```

## How to Use

### For Students
1. Register as Student
2. Login to your account
3. Complete your profile
4. Upload resume and video resume
5. Browse available jobs
6. Apply for jobs
7. Track application status
8. Book consultation with career counselors

### For Companies
1. Register as Company
2. Wait for Admin approval
3. Login after approval
4. Create job posts (requires admin approval)
5. View applicants
6. Shortlist candidates
7. Schedule interviews
8. Update interview results

### For Career Counselors
1. Register as Counselor
2. Wait for Admin approval
3. Login after approval
4. View appointment requests
5. Approve consultations
6. Provide career guidance
7. Give feedback to students

### For Admin
1. Login with admin credentials
2. Approve/reject company registrations
3. Approve/reject counselor registrations
4. Approve/reject job posts
5. View all users
6. Block users if necessary
7. Mark fraudulent accounts

## Security Features
- Password Hashing using `password_hash()` and `password_verify()`
- Session Management on every page
- Cookie-based authentication with `$_COOKIE['status']`
- Remember Me functionality using cookies
- Input validation (JavaScript + PHP)
- Email format validation (no regex - using if-else)
- Role-based access control

## Ajax/JSON Features
- Username availability check during registration
- Email availability check during registration
- Live job search
- Shortlist jobs without page reload
- Apply for jobs with instant feedback
- Shortlist candidates
- Update interview results
- Approve/reject users and job posts
- Profile completion percentage calculation

## Database Tables
1. **users** - Main authentication table
2. **students** - Student profile data
3. **companies** - Company profile data
4. **counselors** - Counselor profile data
5. **jobs** - Job postings
6. **applications** - Job applications
7. **shortlisted_jobs** - Student's shortlisted jobs
8. **shortlisted_candidates** - Company's shortlisted candidates
9. **interviews** - Interview schedules
10. **consultations** - Consultation sessions
11. **feedback** - Counselor feedback

## Troubleshooting

### Cannot access the website
- Make sure Apache and MySQL are running in XAMPP
- Check if you're using correct URL: `http://localhost/Nayeem/`

### Database connection error
- Open `model/db.php` and check database credentials
- Default settings: host=127.0.0.1, user=root, password="", database=job_portal

### Login not working
- Clear browser cookies
- Check if database is imported correctly
- Verify user status is 'approved' in users table

### File upload not working
- Check if `asset/uploads/resumes/` and `asset/uploads/videos/` folders exist
- Check folder permissions (should be writable)

### Ajax not working
- Open browser console (F12) to see JavaScript errors
- Check if jQuery or other libraries are NOT being used (project uses vanilla JS)

## Notes
- This is a basic educational project following procedural PHP patterns
- No advanced security measures like prepared statements
- No OOP concepts used
- Simple if-else validation (no regex)
- Basic CSS styling (no frameworks)
- Uses mysqli (not PDO)

## Developer
Created as a teaching project demonstrating basic web technologies and MVC architecture.
