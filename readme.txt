# PHP Web Project – User & Posts Feed

This project was built as part of an assignment for a junior PHP developer position at inManage.
It demonstrates core concepts of PHP, MySQL, OOP, error handling, and integration with external APIs.

---

##  Features

- Fetch users and posts from `jsonplaceholder.typicode.com`
- Store them in a normalized MySQL database (`users`, `posts` tables)
- Add randomized `birth_date` and `created_at` fields
- Generate:
  - User Feed
  - Birthday Feed
  - Posts grouped by hour
- Use of OOP structure (`User`, `Post`, `Logger`, `ApiHelper`, `Dbh`)
- Centralized error logging (`logs/app.log`)
- Simple UI with HTML/CSS
- Homepage to run full setup and navigate easily

---

## Folder Structure

---
website/
├── classes/
│   ├── ApiHelper.php
│   ├── Database.php
│   ├── Logger.php
│   ├── Post.php
│   └── User.php
├── logs/
│   └── app.log
├── images/
│   └── image.jpg
├── create_tables.php
├── insert_users_from_api.php
├── insert_posts_from_api.php
├── display_feed.php
├── birthday_feed.php
├── posts_by_hour.php
├── homepage.php
├── download_image.php
└── why_me.php
----

---

## Setup Instructions

1. Clone or download the project
2. Place inside XAMPP `htdocs` folder (or equivalent)
3. Start MySQL & Apache
4. Navigate to:

---
http://localhost/website/homepage.php
---


5. This will:
   - Create DB tables
   - Download image
   - Fetch and insert users & posts

6. From there, access all displays via UI

---

##  Screens Included

- **Users Feed** – all users and their posts
- **Birthday Feed** – last post of users whose birthday is this month
- **Posts by Hour** – table view of posting activity
- **Why Me** – personal note about the candidate

---

## Technologies

- PHP 8+
- MySQL
- HTML/CSS
- cURL
- JSON APIs

---

## Notes

- Code uses centralized error handling and logging
- Designed with modularity and readability in mind
- `Logger` handles both file logging and optional screen output

---
##  What I'd Improve or Expand


- Index database tables based on columns frequently used in SELECT queries.
- Add security checks before downloading external images.
- Batch-insert users/posts instead of one by one (optimize performance)
- Add user-specific avatar download logic instead of one shared image.
- Improve UI with a frontend framework.

---

## Why Me?

See 'why_me.php' for a short personal note.

---

##  Contact

Made by Matan Meir