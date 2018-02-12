

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(11) NOT NULL,
  `user_pass` varchar(255) NOT NULL,
  `email` varchar(30) NOT NULL,
  `phone_num` varchar(15) NOT NULL,
  `joindate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
   PRIMARY KEY(`user_id`)
) ENGINE=MariaDB DEFAULT CHARSET=latin1;


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
  `quality` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `etc` varchar(50) NOT NULL,
  `hashtag_arr` varchar(50) NOT NULL,
  PRIMARY KEY(`product_id`),
  FOREIGN KEY(`seller_id`) references users(`user_id`)
);
CREATE TABLE `book`
(
  `book_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `edition` int(2) NOT NULL,
  `author` varchar(50) NOT NULL,
  `subject` varchar(50) NOT NULL,
  PRIMARY KEY(`book_id`),
  FOREIGN KEY (`product_id`) references sell_product(product_id)

);
CREATE TABLE `clothe`
(
  `clothe_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `brand` varchar(50) NOT NULL,
  `size_char` varchar(1) NOT NULL,
  `size_num` int(3) NOT NULL,
  PRIMARY KEY(`clothe_id`),
  FOREIGN KEY (`product_id`) references sell_product(product_id)
);
CREATE TABLE `appliance`
(
  `appliance_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `brand` varchar(50) NOT NULL,
  PRIMARY KEY(`appliance_id`),
  FOREIGN KEY (`product_id`) references sell_product(product_id)
);
CREATE TABLE `hashtag`
(
  `hashtag_id` int(11) NOT NULL,
  `hashtag` varchar(50) NOT NULL,
  `product_id` int(11) NOT null,
  PRIMARY KEY(`hashtag_id`),
  FOREIGN KEY (`product_id`) references sell_product(product_id)
);
