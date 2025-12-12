You are a **Senior Full-Stack Developer**.
Design and implement a **complete website** with the following strict technical requirements.

---

## 1. Technology Stack

### Backend

* **Pure PHP** only
  ❌ No framework
  ❌ No CMS
* Database access using **PDO + Prepared Statements**

### Frontend

* **DaisyUI** (via CDN)
* **AJAX using Fetch API** for most interactions
* **DaisyUI Modal** for confirmations, success, and error messages
* **RemixIcon** (via CDN)
* **DataTables** for data tables

---

## 2. Required Folder Structure

```
config/
helpers/
models/
controllers/
views/
assets/
uploads/
api/
admin/
```

---

## 3. Environment & Configuration

### `.env` file

* Must be read using **pure PHP**
* ❌ Do NOT use `getenv()`, `putenv()`, or any third-party libraries

Required environment variables:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE={project_name}
DB_USERNAME={project_name}
DB_PASSWORD=
APP_BASE_URL={project_name}.laptrinh.site
```

### Required helper

* `helpers/Env.php`
  Responsible for parsing and reading the `.env` file

---

## 4. Database

* MySQL / MariaDB
* Provide a **SQL file** that includes:

  * Database creation
  * Table creation
  * Sample seed data

---

## 5. Routing

* Simple routing using:

  * Query string **or**
  * `.htaccess`
* Must remain **pure PHP**

---

## 6. Validation & Security

### Validation

* Client-side validation using JavaScript
* Server-side validation using PHP

### Security (mandatory)

* Prevent **SQL Injection**
* Prevent **XSS**
* Session-based authentication
* **CSRF token** protection for sensitive forms

---

## 7. UI & API Standards

### UI

* Responsive
* Clean and modern
* Lightweight and dynamic

### CRUD & API

* Most CRUD actions must:

  * Use **AJAX**
  * Return standardized JSON responses:

```json
{
  "status": "success | error",
  "message": "string",
  "data": {}
}
```

* Use **Modal dialogs** for:

  * Confirmation
  * Success messages
  * Error messages
* Use icons in buttons when appropriate
* **Each screen = one distinct feature**

---

## 8. STRICT RULES (VERY IMPORTANT)

* ❗ **Always follow `spec.md` strictly**

  * No mocking
  * No hard-coded data
  * All data must come from:

    * Database
    * `.env`
    * Configuration files
* ❗ Maintain a progress file `tien-do.md`:

  * Completed tasks
  * Pending tasks
  * Next plan (if any)
* ❗ Account creation rules:

  * Emails must be:

    * `admin@example.com`
    * `user@example.com`
    * etc.
  * Password must always be: `123456`
  * Fixed password hash:

    ```
    $2y$10$XmYFYy.VNeY/L4/8SSeO0.ODMgBk0.ujvcCb4WB.XBF40sWia7zLa
    ```
* ❗ Always provide API documentation:

  * `api.yaml` **or** `api.json`
* ❗ Always use placeholder images from:

  ```
  https://placehold.co/
  ```

---

## 9. Expected Output

* Clean, readable, maintainable code
* Strict pure-PHP architecture
* Complete documentation
* SQL, API docs, and progress tracking included
* Ready for real deployment
