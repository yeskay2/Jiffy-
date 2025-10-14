# Copilot Instructions for Jiffy-new

## Project Overview
- **Jiffy-new** is a modular PHP-based HR and Project Management System.
- The system is organized by user roles: Admin (`/admin`), Management (`/management`), Project Manager (`/project`), Business/HR (`/business`), and Accounts (`/Accounts`).
- Each role has a dedicated subdirectory with its own dashboard, authentication, and feature set.
- Core business logic and configuration are in `include/` (e.g., `config.php`, `db_config_local.php`).
- Assets (CSS, JS, images) are in `assets/` and `assets2/`.

## Key Patterns & Conventions
- **Authentication**: Each module (e.g., `admin`, `Accounts`) has its own `loginverify.php` using PHPMailer for notifications and password recovery.
- **Database**: Uses MySQL (`pms` database, see `CREDENTIALS.txt`). Connection is established in `include/config.php` or `db_config_local.php`.
- **Session Management**: All dashboards and sensitive pages require `$_SESSION['user_id']`.
- **Role-based Access**: User role is checked in SQL queries and session logic. Example: `user_role` and `Allpannel` fields in `employee` table.
- **Sanitization**: Use `sanitize_input()` from `include/config.php` for all user input.
- **Password Storage**: All passwords are stored as MD5 hashes (see `CREDENTIALS.txt`).
- **Demo/Test Users**: Add via `add_dummy_credentials.php`. Remove `get_credentials.php` after setup for security.

## Developer Workflows
- **Local Setup**: Use XAMPP (Apache + MySQL). Database: `pms`, user: `root`, password: (empty).
- **Testing**: Use provided demo credentials (see `CREDENTIALS.txt` and `QUICK_START.txt`).
- **Debugging**: Error reporting is enabled by default in config files.
- **Adding Features**: Place new modules in the relevant role directory. Use `include/` for shared logic.
- **Front-end**: Use CSS/JS from `assets/` or `assets2/`. Custom styles in `assets2/css/`.

## Integration Points
- **PHPMailer**: For email notifications (see `PHPMailer/`).
- **PHPWord**: For document generation (see `vendor/phpoffice/phpword/`).
- **PDF Generation**: Likely via custom scripts in `Accounts/`, `project/`, etc.

## Security Notes
- Remove or secure `get_credentials.php` and `add_dummy_credentials.php` in production.
- Change all default/demo passwords before deployment.
- All user input should be sanitized and validated.

## Example: Adding a New Role
1. Create a new directory (e.g., `/newrole/`).
2. Copy `loginverify.php`, `dashboard.php`, and supporting files from an existing role.
3. Update SQL queries to filter by the new role.
4. Register new users via the admin panel or directly in the database.

## References
- `CREDENTIALS.txt` — All system and demo credentials
- `QUICK_START.txt` — Step-by-step setup and usage guide
- `README.md` — General project info
- `include/config.php` — DB connection and shared functions
- `admin/`, `Accounts/`, `business/`, `management/`, `project/` — Main modules

---
For more details, see the above files and explore each module's directory for specific logic and workflows.
