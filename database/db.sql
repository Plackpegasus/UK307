drop DATABASE konsert_tickets;
CREATE DATABASE konsert_tickets;
use konsert_tickets;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE `concert_tab` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`name` varchar(255) NOT NULL UNIQUE,
	PRIMARY KEY (`id`)
);

CREATE TABLE `tickets_tab` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`fk_id_concert` INT NOT NULL,
	`fk_id_discount` INT NOT NULL,
	`fk_id_status` INT NOT NULL,
	`buy_date` TIMESTAMP NOT NULL,
	`name` varchar(64) NOT NULL,
	`email` varchar(64) NOT NULL,
	`phonenumber` varchar(24) NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `discount_tab` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`discount` INT NOT NULL,
	`deadline` INT NOT NULL,
	`text` varchar(64) NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `status_tab` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`status` varchar(64) NOT NULL,
	PRIMARY KEY (`id`)
);

ALTER TABLE `tickets_tab` ADD CONSTRAINT `tickets_tab_fk0` FOREIGN KEY (`fk_id_concert`) REFERENCES `concert_tab`(`id`);

ALTER TABLE `tickets_tab` ADD CONSTRAINT `tickets_tab_fk1` FOREIGN KEY (`fk_id_discount`) REFERENCES `discount_tab`(`id`);

ALTER TABLE `tickets_tab` ADD CONSTRAINT `tickets_tab_fk2` FOREIGN KEY (`fk_id_status`) REFERENCES `status_tab`(`id`);



INSERT INTO `concert_tab` (`id`, `name`) VALUES
(1, 'The Beatles'),
(2, 'Elvis Presley'),
(3, 'Michael Jackson'),
(4, 'Madonna'),
(5, 'Elton John'),
(6, 'ABBA'),
(7, 'Led Zeppelin'),
(8, 'Pink Floyd'),
(9, 'Mariah Carey'),
(10, 'Céline Dion'),
(11, 'AC/DC'),
(12, 'Whitney Houston'),
(13, 'Queen'),
(14, 'The Rolling Stones'),
(15, 'Rihanna'),
(16, 'Taylor Swift'),
(17, 'Eminem'),
(18, 'Garth Brooks'),
(19, 'Eagles'),
(20, 'U2'),
(21, 'Billy Joel'),
(22, 'Phil Collins'),
(23, 'Aerosmith'),
(24, 'Frank Sinatra'),
(25, 'Barbra Streisand'),
(26, 'Bon Jovi'),
(27, 'Genesis'),
(28, 'Donna Summer'),
(29, 'Neil Diamond'),
(30, 'Kanye West'),
(31, 'Bruce Springsteen'),
(32, 'Bee Gees'),
(33, 'Julio Iglesias'),
(34, 'Dire Straits'),
(35, 'Lady Gaga'),
(36, 'Metallica'),
(37, 'Bruno Mars'),
(38, 'Jay Z'),
(39, 'Rod Stewart'),
(40, 'Britney Spears'),
(41, 'Fleetwood Mac'),
(42, 'George Strait'),
(43, 'Backstreet Boys'),
(44, 'Guns N’ Roses'),
(45, 'Prince'),
(46, 'Paul McCartney'),
(47, 'Kenny Rogers'),
(48, 'Janet Jackson'),
(49, 'Chicago'),
(50, 'The Carpenters'),
(51, 'Bob Dylan'),
(52, 'George Michael'),
(53, 'Bryan Adams'),
(54, 'Def Leppard'),
(55, 'Cher'),
(56, 'Lionel Richie'),
(57, 'Olivia Newton-John'),
(58, 'Stevie Wonder'),
(59, 'Tina Turner'),
(60, 'Kiss'),
(61, 'The Who'),
(62, 'Barry White'),
(63, 'Katy Perry'),
(64, 'Santana'),
(65, 'Earth, Wind & Fire'),
(66, 'Beyoncé'),
(67, 'Shania Twain'),
(68, 'R.E.M.'),
(69, 'B’z'),
(70, 'Coldplay'),
(71, 'Van Halen'),
(72, 'Red Hot Chili Peppers'),
(73, 'The Doors'),
(74, 'Barry Manilow'),
(75, 'Johnny Hallyday'),
(76, 'The Black Eyed Peas'),
(77, 'Journey'),
(78, 'Kenny G'),
(79, 'Enya'),
(80, 'Green Day'),
(81, 'Tupac Shakur'),
(82, 'Nirvana'),
(83, 'The Police'),
(84, 'Bob Marley'),
(85, 'Depeche Mode'),
(86, 'Aretha Franklin');

ALTER TABLE tickets_tab MODIFY buy_date TIMESTAMP DEFAULT now();
INSERT into discount_tab (discount, deadline, text) VALUES (0, 30, 'kein Rabatt');
INSERT INTO discount_tab (discount, deadline, text) VALUES (-10, 20, '5 % Rabatt');
INSERT INTO discount_tab (discount, deadline, text) VALUES (-15, 15, '10 % Rabatt');
INSERT INTO discount_tab (discount, deadline, text) VALUES (-20, 10, '15 % Rabatt');

INSERT INTO status_tab VALUES(1,'NICHT BEZAHLT');
INSERT INTO status_tab VALUES(2,'BEZAHLT');