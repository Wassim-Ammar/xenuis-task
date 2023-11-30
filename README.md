# Application for Managing Applications and Offers

## Key Features

1. **Candidate Registration :** Candidates can register on the platform by creating an account with personal information.

2. **CV Creation :** Once registered, candidates can create and manage their CV by adding relevant details such as experience, and education.

3. **Application to Offers :** Candidates can browse available job offers and apply to positions that match their skills and professional goals.

4. **Offer Management :** The administrator has the ability to create, edit, and delete job offers.

5. **Application Tracking :** The administrator can review the list of candidates who have applied for a particular offer, facilitating the tracking of applications.

6. **CV Download :** The administrator has the option to download candidates' CVs to examine their qualifications and experiences in more detail.

## Tools Used

- **Authentication :** Sanctum is utilized to manage user authentication, ensuring secure access to the application's features.

- **Code Quality Improvement :** PHPStan is integrated to enhance code readability, maintainability, and overall code quality, ensuring robust development without errors.

# Requirements and Docker Installation

Before running your Dockerized application, ensure that you have the following requirements in place:

## Requirements

- **Docker**: Docker is a containerization platform that allows you to package and run applications in isolated environments. It's an essential component for running this Dockerized application.

## Docker Installation

If you haven't already installed Docker, you should install it to run the application.

## Clone the repository

To do this, run the following command:

```
git clone git@github.com:Wassim-Ammar/xenuis-task.git
```

## Create volume file for mysql container

You need to create a volume file for the MySQL container. To do this, run the following command under the application folder:

```
 mkdir mysql
```

# Run the application

To run the application, all you need to do is to run these commands in the cloned repository folder on your host.

```
 docker-compose up -d
```

```
 sudo docker exec <php_container_ID> chown -R www-data:www-data /var/www/html/storage
```

```
 sudo docker exec <php_container_ID> cp .env.example .env
```

```
 sudo docker exec <php_container_ID> php artisan key:generate
```

```
 sudo docker exec <php_container_ID> php artisan migrate
```

# Finally

Tape this on your browser URI

```
 localhost:8080
```
