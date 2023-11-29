DROP SCHEMA IF EXISTS `book_flow`;

CREATE SCHEMA IF NOT EXISTS `book_flow` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE  `book_flow`;


CREATE TABLE user(
`id` INT NOT NULL AUTO_INCREMENT,
`name` VARCHAR(255) NOT NULL,
`login` VARCHAR(255) NOT NULL,
`email` VARCHAR(255) NOT NULL,
`password` VARCHAR(255) NOT NULL,
`api_token` varchar(200) DEFAULT NULL COMMENT 'Token para autenticação de usuário',
  PRIMARY KEY (`id`)

);

CREATE TABLE book(
`id` INT NOT NULL AUTO_INCREMENT,
`name` VARCHAR(255) NOT NULL,
`author` VARCHAR(255) NOT NULL,
`genre` VARCHAR(255) NOT NULL,
`image_data` MEDIUMBLOB,
`image_type` VARCHAR(255),
  PRIMARY KEY (`id`)
);


SELECT * FROM user;
SELECT * FROM book;

