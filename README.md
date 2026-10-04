# Forces Academy LMS

A full-stack Learning Management System for Forces Academy, with separate student and admin portals for courses, assignments, results, fees, and notices.

---

## Screenshots

| Student Dashboard | Course Listing |
|---|---|
| ![Student Dashboard](screenshots/dashboard.png) | ![Courses](screenshots/courses.png) |

| Admin Panel | Manage Assignments |
|---|---|
| ![Admin Dashboard](screenshots/admin%20dashboard.png) | ![Manage Assignments](screenshots/manage%20assignment.png) |

---

## Tech Stack

- **HTML5**
- **CSS3** — custom neon-themed design system with CSS variables
- **Bootstrap 5.3** — layout, cards, tables, forms
- **PHP 8** — server-side logic (procedural, `mysqli` with prepared statements)
- **MySQL** — relational database
- **JavaScript** — `window.print()` for the print-friendly results view

---

## Features

### Student Portal
- Registration and login with hashed passwords (`password_hash` / `password_verify`)
- Dashboard with live stats (total courses, latest notice), recent notices, and quick links
- Course listing pulled from the database
- Assignments page with PDF/image file upload submissions
  - Server-side file type verification via `finfo` (checks real file content, not just the extension)
  - "Submitted" badge once a student has turned in an assignment
- Results page with a print-friendly view (sidebar and buttons hidden when printing)
- Notice board with search by title
- Weekly timetable view, filtered to the student's own class
- Fees page showing total pending amount and a full fee history
- Editable profile (name, email) and secure password change (current password verified first)

### Admin Portal
- Separate admin login and session, fully isolated from student sessions
- Dashboard with live counts (students, courses, assignments, notices)
- Manage Students — search by name, email, or roll number; delete with confirmation
- Manage Courses — add, edit (pre-filled form), delete
- Manage Assignments — add, edit, delete, with a course dropdown
- Post Notices — add and delete
- Upload Results — dropdown selection of student and course
- Manage Timetable — add and delete weekly class entries
- Manage Fees — add fee records per student

### Security & Architecture
- All passwords hashed with `password_hash()`, never stored in plain text
- Prepared statements (`mysqli_prepare` + `bind_param`) used throughout to prevent SQL injection
- Session-based route protection on every page — separate `$_SESSION` keys for students and admins
- Shared `sidebar.php` include for both portals, avoiding duplicated markup across pages

---

## How to Run Locally

1. **Install XAMPP** (or any Apache + PHP + MySQL stack).
2. **Clone this repo** into your `htdocs` folder:
   ```
   git clone [your-repo-url] forces-academy-lms
   ```
3. **Start Apache and MySQL** from the XAMPP control panel.
4. **Create the database**: open phpMyAdmin, create a database (e.g. `forces_academy_lms`), and import the SQL file from the repo (if included), or run the `CREATE TABLE` statements for: `students`, `admins`, `courses`, `notices`, `assignments`, `submissions`, `results`, `timetable`, `fees`.
5. **Configure the database connection**: open `config/db.php` and set your local database name, username, and password.
6. **Create an admin account**: since there's no admin registration form, generate a password hash with PHP's `password_hash()` and insert it directly into the `admins` table via phpMyAdmin.
7. **Create the uploads folder**: make sure an empty `uploads/` folder exists in the project root for assignment submissions.
8. **Visit the site**: open `http://localhost/forces-academy-lms/index.php` in your browser.

---

**Built by:** Anam Shahbaz | Code Saviours SI-26 | 2026
