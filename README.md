

### ✅ `README.md`

````markdown
# Italian VAT Validator

A Laravel-based web application that allows you to upload a CSV file containing Italian VAT numbers, validate them, auto-correct common issues, and view the results in a user-friendly format. It also includes a single input validator for manual testing.

---

## 🚀 How to Run the Project

1. **Clone the repository:**

   ```bash
   git clone https://github.com/your-username/italian-vat-validator.git
   cd italian-vat-validator
````

2. **Install PHP dependencies:**

   ```bash
   composer install
   ```

3. **Copy `.env` file and generate app key:**

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Set up database (see below) and update `.env` with DB credentials.**

5. **Run migrations and seeders (if needed):**

   ```bash
   php artisan migrate --seed
   ```

6. **Start the local server:**

   ```bash
   php artisan serve
   ```

---

## 🛠️ Technologies Used

* PHP ^8.0.2
* Laravel ^9.19
* Laravel Sanctum (for authentication)
* Laravel Tinker (for CLI interaction)
* Bootstrap/Tailwind (optional for UI)
* SQLite / MySQL (your choice for DB)

---

## 📂 How to Upload the CSV

1. Go to the home page (e.g., `/` or `/upload`).
2. Use the file input form to upload your CSV file containing VAT numbers.
3. Submit the form and wait for validation results.

CSV should contain VAT numbers, one per line or per row.

---

## 🔎 How to Test Single VAT Number

1. Navigate to the "Test a VAT" section or `/validate-single`.
2. Enter a VAT number (e.g., `12345678901`).
3. Click "Validate".
4. You will see:

   * ✅ Valid
   * 🔄 Corrected (e.g., missing "IT" prefix)
   * ❌ Invalid with an error reason

---

## 📊 How to View the Results

After uploading a file:

* You will see three sections:

  * ✅ Valid VAT numbers
  * 🔄 Corrected VAT numbers (with notes)
  * ❌ Invalid VAT numbers (with reasons)

Results may also be downloadable in CSV or JSON format.

---

## 🖥️ How to Run Locally

Laravel handles it via:

```bash
php artisan serve
```

The app will be available at: `http://127.0.0.1:8000`

---

## 🧩 Seeding the Database (Optional)

If you use a database:

1. Configure DB connection in `.env` (e.g., SQLite, MySQL).
2. Run:

   ```bash
   php artisan migrate --seed
   ```

You can include test data in `database/seeders` or use factories if needed.

