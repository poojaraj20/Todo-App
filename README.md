
# Todo Project

This is a simple Laravel-based Todo management application. The application allows users to create projects and manage todos within each project, supporting functionalities like adding, updating, deleting, and marking todos as complete. The app also provides an option to export project summaries to GitHub Gists.

## Table of Contents
1. [Setup Instructions](#setup-instructions)
2. [Running the Application](#running-the-application)
3. [Additional Features](#additional-features)

---

## Setup Instructions

### Prerequisites

To set up this project, ensure the following software is installed on your local machine:
- **PHP** >= 8.0
- **Composer** for dependency management
- **Node.js** and **npm** (required for frontend assets)
- **MySQL** or **SQLite** for database

### Installation Steps

1. **Clone the Repository**  
   Clone this repository to your local machine:
   ```bash
   git clone https://github.com/yourusername/todo-project.git
   cd todo-project
2. **Install JavaScript Dependencies**  
   Use npm to install JavaScript dependencies:
   ```bash
   npm install
3. **Set Up Environment Variables**  
   Copy the example environment file and configure the .env file for your database and GitHub token:
   ```bash
   cp .env.example .env
In .env, set up your database configuration:

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database_name
    DB_USERNAME=your_database_user
    DB_PASSWORD=your_database_password
Also, add your GitHub personal access token for exporting Gists:

    GITHUB_TOKEN=your_github_token
4. **Generate Application Key**  
   Generate the application key for your Laravel application:
   ```bash
   php artisan key:generate

5. **Run Migrations**  
   Run the migrations to create the necessary tables:
   ```bash
   php artisan migrate
6. **Compile Assets**  
   Build and compile the front-end assets:
   ```bash
   npm run dev

# Running the Application

### Start the Server
Use the following command to start the local development server:  
`php artisan serve`

### Access the Application
Open your browser and go to:  
`http://localhost:8000`

### Create a User
Since this project uses Laravel Breeze for authentication, you’ll need to register a new user to log in. The login and registration views are set up by default.

## Additional Features

### Export Gist
You can export project summaries to GitHub as secret Gists. This feature will create a Markdown file containing:
- The project title
- A summary of completed and pending todos
- A list of pending tasks (open checkbox)
- A list of completed tasks (checked box)

### Download Gist as Markdown
A feature is available to save the project summary locally as a Markdown file. A “Download Gist” button is available on the dashboard for each project to trigger the download.



