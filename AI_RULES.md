# AI Development Rules for MediCare System

This document outlines the technical stack and development conventions for the MediCare System application. As the AI assistant, you must adhere to these rules to ensure consistency and maintainability.

## Tech Stack

*   **Backend Language**: PHP, using an object-oriented approach for data models.
*   **Frontend Languages**: HTML5, CSS3, and vanilla JavaScript for client-side interactions.
*   **Database**: MySQL, accessed from the backend using PHP's PDO extension.
*   **Architecture**: This is a classic Multi-Page Application (MPA). Each page is a separate `.html` file that interacts with the PHP backend via form submissions.
*   **Styling**: All styling is done with custom, plain CSS. There is a base stylesheet (`css/gerenciamento.css`) and page-specific stylesheets.
*   **Icons**: The project uses Font Awesome for all icons, included via a CDN link in the HTML files.
*   **Server Interaction**: The frontend communicates with the backend primarily through standard HTML `<form>` submissions.

## Development Guidelines

### Project Structure

The project follows a structure that separates concerns into distinct layers:

*   `/public/`: The web server's document root. All publicly accessible files reside here.
    *   `css/`: Contains all CSS stylesheets.
    *   `views/`: Contains all user-facing HTML pages.
*   `/scripts/`: Contains all PHP scripts that handle form submissions and other server-side actions. These are the "Controllers" of the application.
*   `/src/`: Contains the core application logic, which is not directly accessible from the web.
    *   `Database/`: Manages the database connection.
    *   `Models/`: Contains the PHP classes that represent the application's data (e.g., `Paciente`, `Medico`).
*   `/sql/`: Contains database schema and migration files.

This structure enhances security by keeping sensitive PHP logic outside the public root and improves maintainability by organizing files based on their function.

### Backend (PHP)

*   **Database Connection**: Always use the `Conexao::getConexao()` static method from `src/Database/Conexao.php` for all database operations. Do not write new connection logic.
*   **Data Models**: Follow the existing object-oriented pattern. For entities like "Médico" or "Paciente," use or extend the corresponding class in the `src/Models/` directory (e.g., `Medico.php`, `Paciente.php`).
*   **Security**: Be mindful of SQL injection. Use prepared statements with placeholders (`?`) for all queries involving user input.

### Frontend (HTML/CSS/JS)

*   **Styling**: **Do not** introduce CSS frameworks like Tailwind CSS or Bootstrap. All styling must be done by extending the existing CSS files and following the established conventions. `gerenciamento.css` serves as the primary style file.
*   **Icons**: Only use Font Awesome for icons. Add icons using the `<i class="fas fa-icon-name"></i>` syntax.
*   **JavaScript**: Use vanilla JavaScript for any necessary client-side interactivity (like the tabs on the login page). **Do not** add libraries like jQuery or frameworks like React or Vue.js.

### General Rules

*   Maintain a clear separation of concerns: HTML for structure, CSS for presentation, and PHP for server-side logic.
*   Do not introduce any build tools, package managers (like npm or composer), or modern frontend frameworks. The project is designed to be simple and run on a standard PHP server without a build step.
*   When creating new pages, replicate the structure of existing pages (e.g., `pacientes.html`) to maintain a consistent layout with the sidebar and header.