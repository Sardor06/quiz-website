# 🎯 Quiz Website (PHP + MySQL)

A full-stack Quiz Web Application built using **PHP, MySQL, HTML, and CSS**, deployed online with a live working demo.

---

## 🌐 Live Demo

👉 https://quiz-web.kesug.com/

---

## 🚀 Features

* 🔐 User Registration & Login system
* 🧠 Take quizzes with multiple questions
* 📊 Automatic score calculation
* 📁 Store results in database
* 🏠 Homepage with available quizzes
* 👨‍💻 Admin panel (create quizzes)
* 🎨 Clean responsive UI

---

## 🛠️ Tech Stack

* **Frontend:** HTML, CSS
* **Backend:** PHP
* **Database:** MySQL
* **Hosting:** InfinityFree

---

## 📂 Project Structure

```
htdocs/
│
├── index.php
├── login.php
├── register.php
├── quiz.php
├── result.php
├── my_results.php
├── logout.php
│
├── admin/
│   └── create_quiz.php
│
├── config/
│   ├── database.php
│   └── init.php
│
├── includes/
│   ├── header.php
│   └── footer.php
│
├── assets/
│   └── style.css
│
└── database/
    └── quiz_website.sql
```

---

## ⚙️ Installation (Run Locally)

### 1. Clone the repository

```
git clone https://github.com/your-username/quiz-website.git
```

### 2. Move project to server

* XAMPP → `htdocs/`
* WAMP → `www/`

---

### 3. Create Database

1. Open phpMyAdmin
2. Create database:

```
quiz
```

3. Import SQL file:

```
database/quiz_website.sql
```

---

### 4. Configure Database

Open:

```
config/database.php
```

Edit:

```php
$host = "localhost";
$dbname = "quiz_website";
$username = "root";
$password = "";
```

---

### 5. Run Project

Open browser:

```
http://localhost/quiz-website
```

---

## 🔐 Admin Access

1. Register a user
2. Go to phpMyAdmin → `users` table
3. Change role:

```
admin
```

---

## 📸 Screenshots

<img src="image.jpg" alt="image">


---

## 💡 Future Improvements

* ⏱️ Quiz timer
* 🏆 Leaderboard system
* 📱 Mobile responsive UI
* 🎨 Better UI/UX design
* ✏️ Edit/Delete quizzes

---

## 👨‍💻 Author

* Atamurodov Sardor
* GitHub: https://github.com/Sardor6606

