SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


CREATE TABLE `users` (
  `user_id` int(5) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(11) NOT NULL,
  `user_pass` varchar(255) NOT NULL,
  `email` varchar(30) NOT NULL,
  `phone_num` varchar(15) NOT NULL,
  `token` varchar(10) NOT NULL,
  `joindate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
   PRIMARY KEY(`user_id`)
)ENGINE=MariaDB DEFAULT CHARSET=latin1;

CREATE TABLE `mycart`(
  `cart_id`int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `product_id`  int(11) NOT NULL,
  PRIMARY KEY (`cart_id`)
);

CREATE TABLE `sell_product`
(
  `product_id` int(11) NOT NULL AUTO_INCREMENT ,
  `seller_id` int(11) NOT NULL ,
  `quality` varchar(5) NOT NULL,
  `title` varchar(20) NOT NULL,
  `category` varchar(9) NOT NULL,
  `price` int(6) NOT NULL,
  `description` varchar(100) NOT NULL,
  `upload_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY(`product_id`),
  FOREIGN KEY(`seller_id`) references users(`user_id`)
);
CREATE TABLE `hashtag`
(
  `hashtag_id` int(11) NOT NULL AUTO_INCREMENT,
  `hashtag` varchar(50) NOT NULL,
  `product_id` int(11) NOT null,
  `upload_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY(`hashtag_id`),
  FOREIGN KEY (`product_id`) references sell_product(product_id)
);

CREATE TABLE `request`
(
  `request_id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `price` int(5) NOT NULL,
  `title` varchar (20) NOT NULL,
  `category` varchar(10) NOT NULL,
  `description` varchar(100) NOT NULL,
  `upload_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY(`request_id`),
  FOREIGN KEY(`user_id`) references users(user_id)
);

CREATE TABLE `book`
(
  `book_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `edition` int(2) NOT NULL,
  `author` varchar(50) NOT NULL,
  `subject` varchar(50) NOT NULL,
  `upload_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,

  PRIMARY KEY(`book_id`),
  FOREIGN KEY (`product_id`) references sell_product(product_id)
);
CREATE TABLE `clothe`
(
  `clothe_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `size_char` varchar(3) NOT NULL,
  `size_num` int(3) NOT NULL,
  `upload_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,

  PRIMARY KEY(`clothe_id`),
  FOREIGN KEY (`product_id`) references sell_product(product_id)
);
CREATE TABLE `appliance`
(
  `appliance_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `brand` varchar(50) NOT NULL,
  `upload_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,

  PRIMARY KEY(`appliance_id`),
  FOREIGN KEY (`product_id`) references sell_product(product_id)
);
