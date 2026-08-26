\# Task 3 - User Management System



\## Project Overview



Task 3 is a PHP and MySQL based User Management System developed as part of the 60 Days Internship.



The system provides user registration, authentication, role-based access, CRUD operations, profile management, and profile picture upload.



\## Technologies Used



\- PHP 8.2

\- MySQL / MariaDB

\- HTML5

\- CSS3

\- Bootstrap 5

\- JavaScript

\- XAMPP

\- Git and GitHub



\## Features



\### Authentication



\- User registration

\- Secure password hashing using `password\_hash()`

\- User login

\- Logout using PHP sessions

\- Role-based authentication

\- USER and ADMIN roles



\### User Management



Administrators can:



\- Add users

\- View users

\- Edit users

\- Delete users

\- Change user roles



\### Profile Management



Users can:



\- View their profile

\- Edit their name

\- Edit their email

\- Change their password

\- Upload a profile picture



\### Security



The project uses:



\- Prepared statements

\- Server-side validation

\- Password hashing

\- Session-based authentication

\- Role-based authorization

\- File type validation

\- File size validation

\- Protection against deleting the currently logged-in account



\## Database



Database name:



`task3\_user\_management`



\### Roles Table



| Column | Type |

|---|---|

| id | INT |

| role\_name | VARCHAR(50) |



\### Users Table



| Column | Type |

|---|---|

| id | INT |

| role\_id | INT |

| full\_name | VARCHAR(100) |

| email | VARCHAR(150) |

| password | VARCHAR(255) |

| profile\_picture | VARCHAR(255) |

| created\_at | TIMESTAMP |



The `role\_id` column connects the users table with the roles table.



\## Project Structure



```text

task3/

│

├── config.php

├── index.php

├── register.php

├── login.php

├── logout.php

├── dashboard.php

├── users.php

├── edit\_user.php

├── delete\_user.php

├── profile.php

├── style.css

├── README.md

│

└── uploads/

&#x20;   └── profile pictures

