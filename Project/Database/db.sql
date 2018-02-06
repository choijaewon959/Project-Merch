

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(60) NOT NULL,
  `user_pass` int(60) NOT NULL,
  `email` varchar(60) NOT NULL,
  `phone_num` varchar(20) NOT NULL,
  `joindate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
   PRIMARY KEY(`id`)
) ENGINE=MariaDB DEFAULT CHARSET=latin1;


CREATE TABLE `sell_product`
(
  `product_id` int(11) NOT NULL AUTO_INCREMENT ,
  `seller_id` int(11) NOT NULL ,
  `product_name` varchar(60) NOT NULL,
  `quality` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `etc` varchar(50) NOT NULL,
  `hashtag_arr` varchar(50) NOT NULL,
  `post_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
  PRIMARY KEY(`product_id`),
  FOREIGN KEY(`seller_id`) references users(`id`)
);
CREATE TABLE `book`
(
  `book_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `edition` varchar(11) NOT NULL,
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
  `size_char` varchar(3) NOT NULL,
  `size_num` int(11) NOT NULL,
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
