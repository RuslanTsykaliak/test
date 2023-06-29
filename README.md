The website was created using Docker and is also hosted on a shared cPanel account
On the posts feed page, the maximum post size is limited to 255 characters, and the title is limited to 25 characters

Both the posts and authors' cookies are stored in the MySQL database

The delete button is only visible for the authors of the posts

There is a limit of one post per 10 minutes


SQL to create the tables authors and posts in the database:

CREATE TABLE `authors` (
  `id` int NOT NULL AUTO_INCREMENT,
  `creator_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `last_creation` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_creator_id` (`creator_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `date_of_creation` timestamp NULL DEFAULT current_timestamp(),
  `creator_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


Tests/
composer.json 

run:
composer install --dev 

vendor/bin/phpunit tests/submitPostTest.php  // tests = folder for the tests and submitPostTest.php = the file for testing


Structure of files and folders

root folder/
composer.json
docker-compose.yml
Dockerfile
README.md
test_db.sql

website folder src/
favicon.ico
index.php

controller/
cookie.php
deletePost.php
functionSubmitPost.php

model/
connection.php ready

view/
footer.php
header.php
postsList.php
createPost.php
