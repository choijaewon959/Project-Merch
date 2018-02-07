

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_pass` int(60) NOT NULL,
  `email` varchar(60) NOT NULL,
  `phone_num` varchar(20) NOT NULL,
  `joindate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MariaDB DEFAULT CHARSET=latin1;


CREATE TABLE `sell_product`
(
  `product_id` int(11) ,
  `seller_id` int(11),
  `quality` int(11),
  `category` int(11),
  `price` int(11),
  `etc` varchar(50),
  `hashtag_arr` varchar(50)
);
CREATE TABLE `book`
(
  `book_id` int(11),
  `product_id` int(11),
  `edition` int(11),
  `author` varchar(50),
  `subject` varchar(50)
);
CREATE TABLE `clothe`
(
  `clothe_id` int(11),
  `product_id` int(11),
  `brand` varchar(50),
  `size_char` varchar(1),
  `size_num` int(11)
);
CREATE TABLE `appliance`
(
  `appliance_id` int(11),
  `product_id` int(11),
  `brand` varchar(50)
);

CREATE TABLE `hashtag`
(
  `hashtag` varchar(50),
  `product_id` int(11)
);
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`) ;

ALTER TABLE `sell_product`
  ADD PRIMARY KEY (`product_id`);
  ADD FOREIGN KEY (`seller_id`) references users(`id`);

ALTER TABLE `hashtag`
  ADD FOREIGN KEY (`product_id`) references sell_product(product_id);

ALTER TABLE `users`
  MODIFY 'id' int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE 'sell_product'
  MODIFY 'product_id' NOT NULL AUTO_INCREMENT;

----------------------------------------------
ALTER TABLE `book`
  MODIFY 'book_id' NOT NULL AUTO_INCREMENT
ALTER TABLE `clothe`
  MODIFY 'clothe_id' NOT NULL AUTO_INCREMENT
ALTER TABLE `appliance`
  MODIFY 'appliance_id' NOT NULL AUTO_INCREMENT
