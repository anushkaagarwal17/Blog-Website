# Blog Website

A simple blog website built with PHP and MySQL. It includes user registration, login, posts, categories, comments, and a soft CSS theme.

## Features

- User registration and login
- User roles: admin, author, and subscriber
- Add, display, update, and delete posts
- Upload post images
- Add and display comments
- Add categories
- Shared header and CSS styling

## Technologies

- PHP
- MySQL
- HTML
- CSS
- XAMPP

## Run Locally

1. Install and start Apache and MySQL in XAMPP.
2. Copy the project folder into:

   ```text
   C:\xampp\htdocs\PHP_Projects\
   ```

3. Create a MySQL database named `blogpostdb`.
4. Import the database tables using phpMyAdmin.
5. Check the database details in `db.php`.
6. Open the project in your browser:

   ```text
   http://localhost/PHP_Projects/blogpost/
   ```

## Main Files

| File | Purpose |
|---|---|
| `register.php` | Register a new user |
| `login.php` | Log in a user |
| `dashboard.php` | Show the user dashboard |
| `insertpost.php` | Add a post |
| `displaypost.php` | Display posts and comments |
| `updatepost.php` | Update a post |
| `deletepost.php` | Delete a post |
| `insertcomment.php` | Save a comment |
| `allheader.php` | Shared website header |
| `allstyle.css` | Website styling |
| `db.php` | Database connection |

## Note

For live hosting, update the database credentials in `db.php` and use secure password hashing before deploying a real website.

