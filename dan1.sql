-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 10, 2025 at 10:29 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dan1`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int NOT NULL,
  `product_id` int NOT NULL,
  `size_id` int NOT NULL,
  `color_id` int NOT NULL,
  `quantity` int NOT NULL DEFAULT '0',
  `user_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `product_id`, `size_id`, `color_id`, `quantity`, `user_id`) VALUES
(1, 18, 9, 2, 1, 2),
(152, 5, 7, 1, 4, 9),
(167, 8, 8, 1, 1, 6);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Men\'s dresses'),
(2, 'Women\'s dresses'),
(3, 'Accerssories');

-- --------------------------------------------------------

--
-- Table structure for table `color`
--

CREATE TABLE `color` (
  `id` int NOT NULL,
  `name` varchar(50) NOT NULL,
  `productvarriants_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `color`
--

INSERT INTO `color` (`id`, `name`, `productvarriants_id`) VALUES
(1, 'Green', NULL),
(2, 'Black', NULL),
(3, 'white', NULL),
(4, 'Red', NULL),
(5, 'Blue', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int NOT NULL,
  `product_id` int NOT NULL,
  `user_id` int NOT NULL,
  `content` text NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `product_id`, `user_id`, `content`, `created_at`) VALUES
(1, 5, 9, 'linh day', '2025-04-21 21:01:48'),
(2, 7, 6, 'chất vải đẹp', '2025-04-23 01:52:10'),
(3, 6, 16, 'ahsajsi', '2025-04-23 08:45:38');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `order_date` datetime DEFAULT NULL,
  `fullname` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `country` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `city` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `address` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `payment_method` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `zipcode` int NOT NULL,
  `note` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `total_price` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `order_date`, `fullname`, `email`, `country`, `city`, `address`, `phone`, `payment_method`, `zipcode`, `note`, `status`, `created_at`, `total_price`) VALUES
(71, 9, '2025-04-18 07:47:31', 'linh phông bạt', 'linhnp992004@gmail.com', 'VietNam', 'hai phong', '75 htm', '+84564310421', 'momo', 140000, '', 'hoàn thành', '2025-04-18 07:47:31', '80'),
(72, 9, '2025-04-18 07:58:03', 'linh phông bạt', 'linhnp992004@gmail.com', 'VietNam', 'hai phong', '75 htm', '+84564310421', 'bank', 140000, '', 'hoàn thành', '2025-04-18 07:58:03', '360'),
(73, 9, '2025-04-18 08:02:45', 'linh phông bạt', 'linhnp992004@gmail.com', 'VietNam', 'hai phong', '75 htm', '+84564310421', 'Bank Transfer', 140000, '', 'hoàn thành', '2025-04-18 08:02:45', '310'),
(74, 9, '2025-04-19 14:55:05', 'linh phông bạt', 'linhnp992004@gmail.com', 'VietNam', 'hai phong', '75 htm', '+84564310421', 'momo', 140000, '', 'đã hủy', '2025-04-19 14:55:05', '250'),
(75, 9, '2025-04-19 15:11:03', 'linh phông bạt', 'linhnp992004@gmail.com', 'VietNam', 'hai phong', '75 htm', '+84564310421', 'bank', 140000, '', 'chờ xác nhận', '2025-04-19 15:11:03', '330'),
(76, 11, '2025-04-19 15:35:54', 'nguyễn quang linh22222', 'linhnp992004@gmail.com', 'Afghanistan', '33', '385', '+93564310421', 'momo', 123123, '', 'chờ xác nhận', '2025-04-19 15:35:54', '106'),
(77, 9, '2025-04-21 12:53:05', 'linh phông bạt', 'linhnp992004@gmail.com', 'VietNam', 'hai phong', '75 htm', '+84564310421', 'bank', 140000, '', 'chờ xác nhận', '2025-04-21 12:53:05', '250'),
(78, 9, '2025-04-21 20:00:02', 'linh phông bạt', 'linhnp992004@gmail.com', 'VietNam', 'hai phong', '75 htm', '+84564310421', 'bank', 140000, '', 'chờ xác nhận', '2025-04-21 20:00:02', '130'),
(79, 9, '2025-04-21 20:04:02', 'nguyễn quang linh', 'linhnp992004@gmail.com', 'VietNam', '33', '385', '+84564310421', 'cod', 140000, '', 'chờ xác nhận', '2025-04-21 20:04:02', '98'),
(80, 9, '2025-04-21 20:15:26', 'nguyễn quang linh', 'linhnp992004@gmail.com', 'VietNam', '33', '385', '+84564310421', 'cod', 140000, '', 'chờ xác nhận', '2025-04-21 20:15:26', '78'),
(81, 9, '2025-04-21 20:46:29', 'nguyễn quang linh', 'linhnp992004@gmail.com', 'VietNam', '33', '385', '+84564310421', 'cod', 140000, 'linh đây\r\n', 'chờ xác nhận', '2025-04-21 20:46:29', '268'),
(82, 9, '2025-04-21 20:52:17', 'nguyễn quang linh', 'linhnp992004@gmail.com', 'VietNam', '33', '385', '+84564310421', 'cod', 140000, 'ádasdasdadsadasdasdad', 'chờ xác nhận', '2025-04-21 20:52:17', '74'),
(83, 9, '2025-04-23 00:15:29', 'nguyễn quang linh', 'linhnp992004@gmail.com', 'Afghanistan', '33', '385', '+93564310421', 'cod', 123123, '', 'đã hủy', '2025-04-23 00:15:29', '54'),
(84, 6, '2025-04-23 01:08:59', 'phuong', 'np172005@gmail.com', 'VietNam', 'hai duong', 'hai duong', '+842365998562', 'bank', 123, 'giao giờ hành chính', 'đã hủy', '2025-04-23 01:08:59', '97'),
(85, 6, '2025-04-23 01:29:05', 'phuong', 'np172005@gmail.com', 'VietNam', 'hai duong', 'hai duong', '+842365998562', 'bank', 123, '', 'hoàn thành', '2025-04-23 01:29:05', '27'),
(86, 16, '2025-04-23 01:56:00', 'quynh', 'quynh@gmail.com', 'VietNam', 'hai duong', 'hai duong', '+84235669845', 'bank', 123, 'giao gio hanh chinh', 'đã hủy', '2025-04-23 01:56:00', '36'),
(87, 16, '2025-04-23 02:08:09', 'quynh', 'quynh@gmail.com', 'VietNam', 'hai duong', 'hai duong', '+84235669845', 'cod', 123, '', 'chờ xác nhận', '2025-04-23 02:08:09', '22'),
(88, 16, '2025-04-23 08:39:13', 'dinh', 'quynh@gmail.com', 'VietNam', 'hai duong', 'hai duong', '+84235669845', 'cod', 123, '', 'đã hủy', '2025-04-23 08:39:13', '246');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` int NOT NULL,
  `order_id` int DEFAULT NULL,
  `product_id` int DEFAULT NULL,
  `price` int DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `size_id` int NOT NULL,
  `color_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `product_id`, `price`, `quantity`, `size_id`, `color_id`) VALUES
(61, 71, 3, 14, 5, 7, 2),
(62, 72, 9, 20, 7, 7, 1),
(63, 72, 12, 30, 7, 9, 2),
(64, 73, 5, 60, 5, 7, 1),
(65, 74, 5, 60, 4, 6, 1),
(66, 75, 7, 30, 4, 6, 1),
(67, 75, 9, 20, 10, 7, 2),
(68, 76, 18, 12, 8, 7, 1),
(69, 77, 5, 60, 4, 6, 1),
(70, 78, 5, 60, 2, 7, 2),
(71, 79, 6, 22, 4, 7, 1),
(72, 80, 8, 17, 4, 7, 2),
(73, 81, 5, 62, 2, 7, 1),
(74, 81, 5, 67, 2, 8, 2),
(75, 82, 3, 16, 4, 7, 1),
(76, 83, 9, 22, 2, 7, 1),
(77, 84, 9, 29, 3, 8, 1),
(78, 85, 19, 17, 1, 9, 3),
(79, 86, 22, 13, 2, 6, 2),
(80, 87, 18, 12, 1, 6, 1),
(81, 88, 22, 13, 2, 6, 2),
(82, 88, 19, 10, 3, 7, 2),
(83, 88, 20, 10, 18, 7, 2);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int NOT NULL,
  `category_id` int DEFAULT NULL,
  `title` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `price` int DEFAULT NULL,
  `discount` int DEFAULT NULL,
  `thumbnail` varchar(5000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `category_id`, `title`, `price`, `discount`, `thumbnail`, `description`, `created_at`, `updated_at`, `deleted`) VALUES
(3, 1, 'Dsgn Studio Collegiate Embroidered Boxy Zip Through Hoodie', 46, 32, 'https://media.boohoo.com/i/boohoo/hzz20399_ecru_xl/female-ecru-dsgn-studio-collegiate-embroidered-boxy-zip-through-hoodie-?w=675&qlt=default&fmt.jp2.qlt=70&fmt=auto&sm=fit', 'Steal the style top spot in a statement separate from the tops collectionCamis or crops, bandeaus or bralets, we\'ve got all the trend-setting tops so you can stay statement in separates this season. Hit refresh on your jersey basics with pastel hues and pick a quirky kimono to give your ensemble that Eastern-inspired edge. Off the shoulder styles are oh-so-sweet, with slogans making your tee a talking point.', NULL, NULL, NULL),
(4, 2, 'Textured Button through v neck longline waistcoat', 20, 12, 'https://media.boohoo.com/i/boohoo/hzz24086_cream_xl/female-cream-textured-button-through-v-neck-longline-waistcoat?w=675&qlt=default&fmt.jp2.qlt=70&fmt=auto&sm=fit', 'Steal the style top spot in a statement separate from the tops collection\r\n\r\nCamis or crops, bandeaus or bralets, we\'ve got all the trend-setting tops so you can stay statement in separates this season. Hit refresh on your jersey basics with pastel hues and pick a quirky kimono to give your ensemble that Eastern-inspired edge. Off the shoulder styles are oh-so-sweet, with slogans making your tee a talking point.', NULL, NULL, NULL),
(5, 2, 'Suede Look Short Belted Trench Coat', 60, 42, 'https://media.boohoo.com/i/boohoo/hzz12904_brown_xl/female-brown-suede-look-short-belted-trench-coat?w=675&qlt=default&fmt.jp2.qlt=70&fmt=auto&sm=fit', 'Wrap up in the latest coats and jackets and get out-there with your outerwearBreathe life into your new season layering with the latest coats and jackets from boohoo. Supersize your silhouette in a padded jacket, stick to sporty styling with a bomber, or protect yourself from the elements in a plastic raincoat. For a more luxe layering piece, faux fur coats come in fondant shades and longline duster coats give your look an androgynous edge.Shell: 50% Polyvinyl chloride, 40% Polyester, 10% Viscose. Lining: 100% Polyester. Do not wash. Model wears UK 10. Due to the delicate nature of the fabric, this fabric may naturally develop marks, scuffs, or variations in texture over time.', NULL, NULL, NULL),
(6, 2, 'Linen Look Pleated Tie Front Smock Top', 22, 13, 'https://media.boohoo.com/i/boohoo/hzz22844_white_xl/female-white-linen-look-pleated-tie-front-smock-top?w=675&qlt=default&fmt.jp2.qlt=70&fmt=auto&sm=fit', 'Steal the style top spot in a statement separate from the tops collection\r\n\r\nCamis or crops, bandeaus or bralets, we\'ve got all the trend-setting tops so you can stay statement in separates this season. Hit refresh on your jersey basics with pastel hues and pick a quirky kimono to give your ensemble that Eastern-inspired edge. Off the shoulder styles are oh-so-sweet, with slogans making your tee a talking point.', NULL, NULL, NULL),
(7, 1, 'Textured Button Through Waistcoat', 30, 21, 'https://media.boohoo.com/i/boohoo/hzz24646_olive_xl/female-olive-textured-button-through-waistcoat?w=675&qlt=default&fmt.jp2.qlt=70&fmt=auto&sm=fit', 'abcd', NULL, NULL, NULL),
(8, 2, 'Malibu Keychain Oversized T-shirt', 12, 7, 'https://media.boohoo.com/i/boohoo/hzz27028_white_xl/female-white-malibu-keychain-oversized-t-shirt?w=675&qlt=default&fmt.jp2.qlt=70&fmt=auto&sm=fit', 'Steal the style top spot in a statement separate from the tops collection\r\n\r\nCamis or crops, bandeaus or bralets, we\'ve got all the trend-setting tops so you can stay statement in separates this season. Hit refresh on your jersey basics with pastel hues and pick a quirky kimono to give your ensemble that Eastern-inspired edge. Off the shoulder styles are oh-so-sweet, with slogans making your tee a talking point.', NULL, NULL, NULL),
(9, 1, 'Oversized V Neck Baseball T-Shirt', 25, 18, 'https://media.boohoo.com/i/boohoo/cmm08797_navy_xl/male-navy-oversized-v-neck-baseball-t-shirt?w=675&qlt=default&fmt.jp2.qlt=70&fmt=auto&sm=fit', 'We all know about t-shirts and vests, light layers which have stood the test of time. T-shirts are a seasonless staple which gives your wardrobe a solid foundation to build off. Whether you’re about a plain tee, printed, striped or long-sleeve or you’re flexing something oversized for a comfortably casual look, make sure your outfits have the foundations they need with our range of tees and vests. Combine a plain white tee with denim and trainers for a versatile everyday outfit or pair with cropped trousers to secure minimalistic vibes.', NULL, NULL, NULL),
(10, 1, 'Regular Fit Crinkle Nylon Panelled Track Jacket', 30, 18, 'https://media.boohoo.com/i/boohoo/cmm08729_brown_xl/male-brown-regular-fit-crinkle-nylon-panelled-track-jacket?w=675&qlt=default&fmt.jp2.qlt=70&fmt=auto&sm=fit', 'Rev up your outerwear inventory with our unrivalled collection of coats and jackets for men. Whether you are looking for a heavy coat to combat the low temperatures or a lightweight jacket to stand out at your favourite festival, we\'ve got the trendiest designs to finish off your outfit. Puffers, parkas and borg jackets are the perfect choices if you want to bundle up without sacrificing on style, and they look great when teamed up with knitwear and denim. Bombers and overcoats are beyond versatile and can turn any getup from laid-back to dapper in no time. Denim jackets can\'t be missing in your trans-seasonal wardrobe, whilst cagoules and coach jackets will keep out the chill while you\'re out and about.', NULL, NULL, NULL),
(11, 1, 'Regular Fit Stripe Rugby Polo', 18, 17, 'https://media.boohoo.com/i/boohoo/cmm08817_black_xl/male-black-regular-fit-stripe-rugby-polo?w=675&qlt=default&fmt.jp2.qlt=70&fmt=auto&sm=fit', 'We all know about t-shirts and vests, light layers which have stood the test of time. T-shirts are a seasonless staple which gives your wardrobe a solid foundation to build off. Whether you’re about a plain tee, printed, striped or long-sleeve or you’re flexing something oversized for a comfortably casual look, make sure your outfits have the foundations they need with our range of tees and vests. Combine a plain white tee with denim and trainers for a versatile everyday outfit or pair with cropped trousers to secure minimalistic vibes.', NULL, NULL, NULL),
(12, 1, 'Plus Crinkle Nylon Panelled Regular Track Jacket', 30, 10, 'https://media.boohoo.com/i/boohoo/cmm08585_black_xl/male-black-plus-crinkle-nylon-panelled-regular-track-jacket?w=675&qlt=default&fmt.jp2.qlt=70&fmt=auto&sm=fit', 'Rev up your outerwear inventory with our unrivalled collection of coats and jackets for men. Whether you are looking for a heavy coat to combat the low temperatures or a lightweight jacket to stand out at your favourite festival, we\'ve got the trendiest designs to finish off your outfit. Puffers, parkas and borg jackets are the perfect choices if you want to bundle up without sacrificing on style, and they look great when teamed up with knitwear and denim. Bombers and overcoats are beyond versatile and can turn any getup from laid-back to dapper in no time. Denim jackets can\'t be missing in your trans-seasonal wardrobe, whilst cagoules and coach jackets will keep out the chill while you\'re out and about.', NULL, NULL, NULL),
(13, 1, 'Plus 330GSM Basic Oversized Over The Head Hoodie', 30, 10, 'https://media.boohoo.com/i/boohoo/cmm04240_black_xl/male-black-plus-330gsm-basic-oversized-over-the-head-hoodie?w=675&qlt=default&fmt.jp2.qlt=70&fmt=auto&sm=fit', 'Hoodies and sweatshirts are essential for boxing those clean, comfortable layers. Hoodies work as a classic mid-layer or a standalone everyday basic when the weather is a little bit warmer. When you want a minimal colourway to effortlessly finish off your outfit, choosing a sweatshirt is always a solid option. A staple in your wardrobe already, jersey hoodies and sweats are a failsafe grab-and-go for any occasion. Find the perfect casual top to complement your off-duty look in our selection of hoodies and sweats for men.', NULL, NULL, NULL),
(14, 1, 'Plus Basic Crew Neck Regular Fit T-shirt', 8, 5, 'https://media.boohoo.com/i/boohoo/cmm04473_black_xl/male-black-plus-basic-crew-neck-regular-fit-t-shirt?w=675&qlt=default&fmt.jp2.qlt=70&fmt=auto&sm=fit', 'We all know about t-shirts and vests, light layers which have stood the test of time. T-shirts are a seasonless staple which gives your wardrobe a solid foundation to build off. Whether you’re about a plain tee, printed, striped or long-sleeve or you’re flexing something oversized for a comfortably casual look, make sure your outfits have the foundations they need with our range of tees and vests. Combine a plain white tee with denim and trainers for a versatile everyday outfit or pair with cropped trousers to secure minimalistic vibes.', NULL, NULL, NULL),
(15, 3, 'Chunky Cuban Chain Necklace', 4, 2, 'https://media.boohoo.com/i/boohoo/bmm14674_silver_xl/male-silver-chunky-cuban-chain-necklace?w=675&qlt=default&fmt.jp2.qlt=70&fmt=auto&sm=fit', 'Wanna bring new energy? Complete your look with this men’s chain from our latest arrivals. Designed to provide the finishing touch to your outfit, wear this men’s necklace everywhere – from low-key days to weekend plays. Throw on with jeans and a tee to elevate your basics or wear with a suit to secure some serious serious style points. From men’s gold chains to silver options, we’ve got something for every kinda vibe.', NULL, NULL, NULL),
(17, 3, 'Paisley Printed Bandana In Black', 8, 5, 'https://media.boohoo.com/i/boohoo/bmm78735_black_xl/male-black-paisley-printed-bandana-in-black?w=675&qlt=default&fmt.jp2.qlt=70&fmt=auto&sm=fit', 'Add attitude with our fashion-forward men\'s accessories and inject some personality into your look. Add the perfect finishing touch, from bags and wallets to hats and belts. Find your favourites from rucksacks to beanies and turn heads in oversized sunglasses. Forget less is more, this season we\'re all for out-there statement accessories.', NULL, NULL, NULL),
(18, 3, 'Black Belt With Silver Buckle', 10, 7, 'https://media.boohoo.com/i/boohoo/cmm01516_black_xl/male-black-black-belt-with-silver-buckle?w=675&qlt=default&fmt.jp2.qlt=70&fmt=auto&sm=fit', 'sang trọng', NULL, NULL, NULL),
(19, 3, 'Double Hooped Earrings', 5, 3, 'https://media.boohoo.com/i/boohoo/gzz69301_gold_xl/female-gold-double-hooped-earrings-?w=675&qlt=default&fmt.jp2.qlt=70&fmt=auto&sm=fit', 'Earrings are the must-have accessory of the moment. From simple stud earrings to statement drop designs, our women\'s earrings collection features the hottest styles around. Go with silver or gold earrings to add attitude to the most simplest of looks. We are all about keeping you in this season\'s style loop, so check out our fashion earrings and new season hoop designs to add detail to your \'fits.', NULL, NULL, NULL),
(20, 3, 'Hammered Oval Drop Necklace', 5, 3, 'https://media.boohoo.com/i/boohoo/hzz20260_gold_xl/female-gold-hammered-oval-drop-necklace?w=675&qlt=default&fmt.jp2.qlt=70&fmt=auto&sm=fit', 'Add attitude with accessories for those fashion-forward finishing touches\r\n\r\nIt\'s all about accessories for injecting individuality into your look. Find your festival favourites from fedora hats and floral crowns to bumbags and body glitter, play up your partywear with a pop of pastel nail polish and make a statement in oversized sunglasses. Forget less is more, this season we\'re all for out-there hair, beauty and jewellery.', NULL, NULL, NULL),
(21, 1, 'Quilted Faux Leather Crossbody Chain Bag', 20, 14, 'https://media.boohoo.com/i/boohoo/fzz67448_white_xl/female-white-quilted-faux-leather-crossbody-chain-bag?w=675&qlt=default&fmt.jp2.qlt=70&fmt=auto&sm=fit', 'It’s that magical moment when the perfect accessory meets practicality - introducing the crossbody bag. With one long strap that sits across the body, while the actual bag rests on your waist, this is a secure option for keeping hold of all your valuables. Love festivals? Parties? Got travel plans? No problem, never wake up without your phone, card or house keys ever again. Keep your hands free for the important stuff (like scrolling) and keep looking cute at the same time.', NULL, NULL, NULL),
(22, 2, 'Cotton Pinstripe Pyjama Short', 10, 7, 'https://media.boohoo.com/i/boohoo/gzz52187_blue_xl/female-blue-cotton-pinstripe-pyjama-short?w=675&amp;qlt=default&amp;fmt.jp2.qlt=70&amp;fmt=auto&amp;sm=fit', 'Keep things classic in this cotton pinstripe pyjama short. The most comfortable plus one for nights in. Made from a soft material and featuring an elasticated waistband, these shorts are super dreamy. Whether you’re chilling on the sofa, hosting a night in with the girls or slipping into fresh sheets, these pyjama shorts are the ultimate bedtime companion.', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `productrandy`
--

CREATE TABLE `productrandy` (
  `id` int NOT NULL,
  `category_id` int DEFAULT NULL,
  `title` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `price` int DEFAULT NULL,
  `discount` int DEFAULT NULL,
  `thumbnail` varchar(5000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted` int DEFAULT NULL,
  `color` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `size` varchar(55) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `productrandy`
--

INSERT INTO `productrandy` (`id`, `category_id`, `title`, `price`, `discount`, `thumbnail`, `description`, `created_at`, `updated_at`, `deleted`, `color`, `size`) VALUES
(4, NULL, 'Textured Button through v neck longline waistcoat', 12, 20, 'https://media.boohoo.com/i/boohoo/hzz24086_cream_xl/female-cream-textured-button-through-v-neck-longline-waistcoat?w=675&qlt=default&fmt.jp2.qlt=70&fmt=auto&sm=fit', 'Steal the style top spot in a statement separate from the tops collection\r\n\r\nCamis or crops, bandeaus or bralets, we\'ve got all the trend-setting tops so you can stay statement in separates this season. Hit refresh on your jersey basics with pastel hues and pick a quirky kimono to give your ensemble that Eastern-inspired edge. Off the shoulder styles are oh-so-sweet, with slogans making your tee a talking point.', NULL, NULL, NULL, 'cream', 'L'),
(7, NULL, 'Textured Button Through Waistcoat\r\n', 12, 20, 'https://media.boohoo.com/i/boohoo/hzz24646_olive_xl/female-olive-textured-button-through-waistcoat?w=675&qlt=default&fmt.jp2.qlt=70&fmt=auto&sm=fit', '', NULL, NULL, NULL, 'olive', 'Select'),
(9, NULL, 'Oversized V Neck Baseball T-Shirt', 12, 20, 'https://media.boohoo.com/i/boohoo/cmm08797_navy_xl/male-navy-oversized-v-neck-baseball-t-shirt?w=675&qlt=default&fmt.jp2.qlt=70&fmt=auto&sm=fit', 'We all know about t-shirts and vests, light layers which have stood the test of time. T-shirts are a seasonless staple which gives your wardrobe a solid foundation to build off. Whether you’re about a plain tee, printed, striped or long-sleeve or you’re flexing something oversized for a comfortably casual look, make sure your outfits have the foundations they need with our range of tees and vests. Combine a plain white tee with denim and trainers for a versatile everyday outfit or pair with cropped trousers to secure minimalistic vibes.', NULL, NULL, NULL, 'Navy', 'Select'),
(10, NULL, 'Regular Fit Crinkle Nylon Panelled Track Jacket', 18, 30, 'https://media.boohoo.com/i/boohoo/cmm08729_brown_xl/male-brown-regular-fit-crinkle-nylon-panelled-track-jacket?w=675&qlt=default&fmt.jp2.qlt=70&fmt=auto&sm=fit', 'Rev up your outerwear inventory with our unrivalled collection of coats and jackets for men. Whether you are looking for a heavy coat to combat the low temperatures or a lightweight jacket to stand out at your favourite festival, we\'ve got the trendiest designs to finish off your outfit. Puffers, parkas and borg jackets are the perfect choices if you want to bundle up without sacrificing on style, and they look great when teamed up with knitwear and denim. Bombers and overcoats are beyond versatile and can turn any getup from laid-back to dapper in no time. Denim jackets can\'t be missing in your trans-seasonal wardrobe, whilst cagoules and coach jackets will keep out the chill while you\'re out and about.', NULL, NULL, NULL, 'brown', 'Select'),
(11, NULL, 'Regular Fit Stripe Rugby Polo', 17, 18, 'https://media.boohoo.com/i/boohoo/cmm08817_black_xl/male-black-regular-fit-stripe-rugby-polo?w=675&qlt=default&fmt.jp2.qlt=70&fmt=auto&sm=fit', 'We all know about t-shirts and vests, light layers which have stood the test of time. T-shirts are a seasonless staple which gives your wardrobe a solid foundation to build off. Whether you’re about a plain tee, printed, striped or long-sleeve or you’re flexing something oversized for a comfortably casual look, make sure your outfits have the foundations they need with our range of tees and vests. Combine a plain white tee with denim and trainers for a versatile everyday outfit or pair with cropped trousers to secure minimalistic vibes.', NULL, NULL, NULL, 'black', 'Select'),
(13, NULL, 'Plus 330GSM Basic Oversized Over The Head Hoodie', 21, 30, 'https://media.boohoo.com/i/boohoo/cmm04240_black_xl/male-black-plus-330gsm-basic-oversized-over-the-head-hoodie?w=675&qlt=default&fmt.jp2.qlt=70&fmt=auto&sm=fit', 'Hoodies and sweatshirts are essential for boxing those clean, comfortable layers. Hoodies work as a classic mid-layer or a standalone everyday basic when the weather is a little bit warmer. When you want a minimal colourway to effortlessly finish off your outfit, choosing a sweatshirt is always a solid option. A staple in your wardrobe already, jersey hoodies and sweats are a failsafe grab-and-go for any occasion. Find the perfect casual top to complement your off-duty look in our selection of hoodies and sweats for men.', NULL, NULL, NULL, 'black', 'Select'),
(17, NULL, 'Paisley Printed Bandana In Black', 5, 8, 'https://media.boohoo.com/i/boohoo/bmm78735_black_xl/male-black-paisley-printed-bandana-in-black?w=675&qlt=default&fmt.jp2.qlt=70&fmt=auto&sm=fit', 'Add attitude with our fashion-forward men\'s accessories and inject some personality into your look. Add the perfect finishing touch, from bags and wallets to hats and belts. Find your favourites from rucksacks to beanies and turn heads in oversized sunglasses. Forget less is more, this season we\'re all for out-there statement accessories.', NULL, NULL, NULL, 'black', 'One size'),
(18, NULL, 'Black Belt With Silver Buckle', 8, 12, 'https://media.boohoo.com/i/boohoo/cmm01516_black_xl/male-black-black-belt-with-silver-buckle?w=675&qlt=default&fmt.jp2.qlt=70&fmt=auto&sm=fit', NULL, NULL, NULL, NULL, 'black', 'One size');

-- --------------------------------------------------------

--
-- Table structure for table `product_variants`
--

CREATE TABLE `product_variants` (
  `id` int NOT NULL,
  `product_id` int NOT NULL,
  `color_id` int NOT NULL,
  `size_id` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int NOT NULL DEFAULT '0',
  `sku` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `product_variants`
--

INSERT INTO `product_variants` (`id`, `product_id`, `color_id`, `size_id`, `price`, `stock`, `sku`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 6, 46.00, 12, 'P3-C1-S6', '2025-04-16 13:18:52', '2025-04-22 17:37:15'),
(2, 3, 1, 7, 48.00, 12, 'P3-C1-S7', '2025-04-16 13:18:52', '2025-04-22 17:37:15'),
(3, 3, 1, 8, 50.00, 7, 'P3-C1-S8', '2025-04-16 13:18:52', '2025-04-22 17:37:15'),
(4, 3, 1, 9, 53.00, 10, 'P3-C1-S9', '2025-04-16 13:18:52', '2025-04-22 17:37:15'),
(5, 3, 2, 6, 49.00, 10, 'P3-C2-S6', '2025-04-16 13:18:52', '2025-04-22 17:37:15'),
(6, 3, 2, 7, 51.00, 3, 'P3-C2-S7', '2025-04-16 13:18:52', '2025-04-22 17:37:15'),
(7, 3, 2, 8, 53.00, 1, 'P3-C2-S8', '2025-04-16 13:18:52', '2025-04-22 17:37:15'),
(8, 3, 2, 9, 56.00, 10, 'P3-C2-S9', '2025-04-16 13:18:52', '2025-04-22 17:37:15'),
(9, 3, 3, 6, 51.00, 10, 'P3-C3-S6', '2025-04-16 13:18:52', '2025-04-22 17:37:15'),
(10, 3, 3, 7, 53.00, 10, 'P3-C3-S7', '2025-04-16 13:18:52', '2025-04-22 17:37:15'),
(11, 3, 3, 8, 55.00, 10, 'P3-C3-S8', '2025-04-16 13:18:52', '2025-04-22 17:37:15'),
(12, 3, 3, 9, 58.00, 10, 'P3-C3-S9', '2025-04-16 13:18:52', '2025-04-22 17:37:15'),
(13, 3, 4, 6, 53.00, 10, 'P3-C4-S6', '2025-04-16 13:18:52', '2025-04-22 17:37:15'),
(14, 3, 4, 7, 55.00, 10, 'P3-C4-S7', '2025-04-16 13:18:52', '2025-04-22 17:37:15'),
(15, 3, 4, 8, 57.00, 10, 'P3-C4-S8', '2025-04-16 13:18:52', '2025-04-22 17:37:15'),
(16, 3, 4, 9, 60.00, 10, 'P3-C4-S9', '2025-04-16 13:18:52', '2025-04-22 17:37:15'),
(17, 3, 5, 6, 48.00, 10, 'P3-C5-S6', '2025-04-16 13:18:52', '2025-04-22 17:37:15'),
(18, 3, 5, 7, 50.00, 10, 'P3-C5-S7', '2025-04-16 13:18:52', '2025-04-22 17:37:15'),
(19, 3, 5, 8, 52.00, 10, 'P3-C5-S8', '2025-04-16 13:18:52', '2025-04-22 17:37:15'),
(20, 3, 5, 9, 55.00, 10, 'P3-C5-S9', '2025-04-16 13:18:52', '2025-04-22 17:37:15'),
(41, 5, 1, 6, 60.00, 2, 'P5-C1-S6', '2025-04-16 13:18:52', '2025-04-21 05:53:06'),
(42, 5, 1, 7, 62.00, 4, 'P5-C1-S7', '2025-04-16 13:18:52', '2025-04-22 17:53:16'),
(43, 5, 1, 8, 64.00, 10, 'P5-C1-S8', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(44, 5, 1, 9, 67.00, 10, 'P5-C1-S9', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(45, 5, 2, 6, 63.00, 10, 'P5-C2-S6', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(46, 5, 2, 7, 65.00, 8, 'P5-C2-S7', '2025-04-16 13:18:52', '2025-04-21 13:00:09'),
(47, 5, 2, 8, 67.00, 8, 'P5-C2-S8', '2025-04-16 13:18:52', '2025-04-21 13:46:39'),
(48, 5, 2, 9, 70.00, 10, 'P5-C2-S9', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(49, 5, 3, 6, 65.00, 10, 'P5-C3-S6', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(50, 5, 3, 7, 67.00, 5, 'P5-C3-S7', '2025-04-16 13:18:52', '2025-04-17 21:03:13'),
(51, 5, 3, 8, 69.00, 10, 'P5-C3-S8', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(52, 5, 3, 9, 72.00, 10, 'P5-C3-S9', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(53, 5, 4, 6, 67.00, 10, 'P5-C4-S6', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(54, 5, 4, 7, 69.00, 10, 'P5-C4-S7', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(55, 5, 4, 8, 71.00, 10, 'P5-C4-S8', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(56, 5, 4, 9, 74.00, 10, 'P5-C4-S9', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(57, 5, 5, 6, 62.00, 10, 'P5-C5-S6', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(58, 5, 5, 7, 64.00, 10, 'P5-C5-S7', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(59, 5, 5, 8, 66.00, 10, 'P5-C5-S8', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(60, 5, 5, 9, 69.00, 10, 'P5-C5-S9', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(61, 6, 1, 6, 22.00, 10, 'P6-C1-S6', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(62, 6, 1, 7, 24.00, 6, 'P6-C1-S7', '2025-04-16 13:18:52', '2025-04-21 13:04:03'),
(63, 6, 1, 8, 26.00, 10, 'P6-C1-S8', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(64, 6, 1, 9, 29.00, 10, 'P6-C1-S9', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(65, 6, 2, 6, 25.00, 10, 'P6-C2-S6', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(66, 6, 2, 7, 27.00, 10, 'P6-C2-S7', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(67, 6, 2, 8, 29.00, 10, 'P6-C2-S8', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(68, 6, 2, 9, 32.00, 10, 'P6-C2-S9', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(69, 6, 3, 6, 27.00, 10, 'P6-C3-S6', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(70, 6, 3, 7, 29.00, 10, 'P6-C3-S7', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(71, 6, 3, 8, 31.00, 10, 'P6-C3-S8', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(72, 6, 3, 9, 34.00, 10, 'P6-C3-S9', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(73, 6, 4, 6, 29.00, 10, 'P6-C4-S6', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(74, 6, 4, 7, 31.00, 10, 'P6-C4-S7', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(75, 6, 4, 8, 33.00, 10, 'P6-C4-S8', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(76, 6, 4, 9, 36.00, 10, 'P6-C4-S9', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(77, 6, 5, 6, 24.00, 10, 'P6-C5-S6', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(78, 6, 5, 7, 26.00, 10, 'P6-C5-S7', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(79, 6, 5, 8, 28.00, 10, 'P6-C5-S8', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(80, 6, 5, 9, 31.00, 10, 'P6-C5-S9', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(81, 7, 1, 6, 30.00, 6, 'P7-C1-S6', '2025-04-16 13:18:52', '2025-04-19 08:11:35'),
(82, 7, 1, 7, 32.00, 10, 'P7-C1-S7', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(83, 7, 1, 8, 34.00, 10, 'P7-C1-S8', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(84, 7, 1, 9, 37.00, 10, 'P7-C1-S9', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(85, 7, 2, 6, 33.00, 10, 'P7-C2-S6', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(86, 7, 2, 7, 35.00, 10, 'P7-C2-S7', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(87, 7, 2, 8, 37.00, 10, 'P7-C2-S8', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(88, 7, 2, 9, 40.00, 10, 'P7-C2-S9', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(89, 7, 3, 6, 35.00, 10, 'P7-C3-S6', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(90, 7, 3, 7, 37.00, 10, 'P7-C3-S7', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(91, 7, 3, 8, 39.00, 10, 'P7-C3-S8', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(92, 7, 3, 9, 42.00, 10, 'P7-C3-S9', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(93, 7, 4, 6, 37.00, 10, 'P7-C4-S6', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(94, 7, 4, 7, 39.00, 10, 'P7-C4-S7', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(95, 7, 4, 8, 41.00, 10, 'P7-C4-S8', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(96, 7, 4, 9, 44.00, 10, 'P7-C4-S9', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(97, 7, 5, 6, 32.00, 10, 'P7-C5-S6', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(98, 7, 5, 7, 34.00, 10, 'P7-C5-S7', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(99, 7, 5, 8, 36.00, 10, 'P7-C5-S8', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(100, 7, 5, 9, 39.00, 10, 'P7-C5-S9', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(101, 8, 1, 6, 12.00, 10, 'P8-C1-S6', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(102, 8, 1, 7, 14.00, 8, 'P8-C1-S7', '2025-04-16 13:18:52', '2025-04-18 00:30:56'),
(103, 8, 1, 8, 16.00, 10, 'P8-C1-S8', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(104, 8, 1, 9, 19.00, 10, 'P8-C1-S9', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(105, 8, 2, 6, 15.00, 5, 'P8-C2-S6', '2025-04-16 13:18:52', '2025-04-18 00:15:07'),
(106, 8, 2, 7, 17.00, 6, 'P8-C2-S7', '2025-04-16 13:18:52', '2025-04-21 13:15:30'),
(107, 8, 2, 8, 19.00, 10, 'P8-C2-S8', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(108, 8, 2, 9, 22.00, 10, 'P8-C2-S9', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(109, 8, 3, 6, 17.00, 10, 'P8-C3-S6', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(110, 8, 3, 7, 19.00, 10, 'P8-C3-S7', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(111, 8, 3, 8, 21.00, 10, 'P8-C3-S8', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(112, 8, 3, 9, 24.00, 10, 'P8-C3-S9', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(113, 8, 4, 6, 19.00, 10, 'P8-C4-S6', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(114, 8, 4, 7, 21.00, 10, 'P8-C4-S7', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(115, 8, 4, 8, 23.00, 10, 'P8-C4-S8', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(116, 8, 4, 9, 26.00, 10, 'P8-C4-S9', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(117, 8, 5, 6, 14.00, 10, 'P8-C5-S6', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(118, 8, 5, 7, 16.00, 10, 'P8-C5-S7', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(119, 8, 5, 8, 18.00, 10, 'P8-C5-S8', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(120, 8, 5, 9, 21.00, 10, 'P8-C5-S9', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(121, 9, 1, 6, 25.00, 10, 'P9-C1-S6', '2025-04-16 13:18:52', '2025-04-22 17:48:05'),
(122, 9, 1, 7, 27.00, 10, 'P9-C1-S7', '2025-04-16 13:18:52', '2025-04-22 17:48:05'),
(123, 9, 1, 8, 29.00, 7, 'P9-C1-S8', '2025-04-16 13:18:52', '2025-04-22 18:09:13'),
(124, 9, 1, 9, 32.00, 10, 'P9-C1-S9', '2025-04-16 13:18:52', '2025-04-22 17:48:05'),
(125, 9, 2, 6, 28.00, 10, 'P9-C2-S6', '2025-04-16 13:18:52', '2025-04-22 17:48:05'),
(126, 9, 2, 7, 30.00, 0, 'P9-C2-S7', '2025-04-16 13:18:52', '2025-04-22 17:48:05'),
(127, 9, 2, 8, 32.00, 10, 'P9-C2-S8', '2025-04-16 13:18:52', '2025-04-22 17:48:05'),
(128, 9, 2, 9, 35.00, 10, 'P9-C2-S9', '2025-04-16 13:18:52', '2025-04-22 17:48:05'),
(129, 9, 3, 6, 30.00, 10, 'P9-C3-S6', '2025-04-16 13:18:52', '2025-04-22 17:48:05'),
(130, 9, 3, 7, 32.00, 10, 'P9-C3-S7', '2025-04-16 13:18:52', '2025-04-22 17:48:05'),
(131, 9, 3, 8, 34.00, 10, 'P9-C3-S8', '2025-04-16 13:18:52', '2025-04-22 17:48:05'),
(132, 9, 3, 9, 37.00, 10, 'P9-C3-S9', '2025-04-16 13:18:52', '2025-04-22 17:48:05'),
(133, 9, 4, 6, 32.00, 10, 'P9-C4-S6', '2025-04-16 13:18:52', '2025-04-22 17:48:05'),
(134, 9, 4, 7, 34.00, 10, 'P9-C4-S7', '2025-04-16 13:18:52', '2025-04-22 17:48:05'),
(135, 9, 4, 8, 36.00, 10, 'P9-C4-S8', '2025-04-16 13:18:52', '2025-04-22 17:48:05'),
(136, 9, 4, 9, 39.00, 10, 'P9-C4-S9', '2025-04-16 13:18:52', '2025-04-22 17:48:05'),
(137, 9, 5, 6, 27.00, 10, 'P9-C5-S6', '2025-04-16 13:18:52', '2025-04-22 17:48:05'),
(138, 9, 5, 7, 29.00, 10, 'P9-C5-S7', '2025-04-16 13:18:52', '2025-04-22 17:48:05'),
(139, 9, 5, 8, 31.00, 10, 'P9-C5-S8', '2025-04-16 13:18:52', '2025-04-22 17:48:05'),
(140, 9, 5, 9, 34.00, 10, 'P9-C5-S9', '2025-04-16 13:18:52', '2025-04-22 17:48:05'),
(141, 10, 1, 6, 30.00, 10, 'P10-C1-S6', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(142, 10, 1, 7, 32.00, 10, 'P10-C1-S7', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(143, 10, 1, 8, 34.00, 10, 'P10-C1-S8', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(144, 10, 1, 9, 37.00, 10, 'P10-C1-S9', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(145, 10, 2, 6, 33.00, 10, 'P10-C2-S6', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(146, 10, 2, 7, 35.00, 10, 'P10-C2-S7', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(147, 10, 2, 8, 37.00, 10, 'P10-C2-S8', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(148, 10, 2, 9, 40.00, 10, 'P10-C2-S9', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(149, 10, 3, 6, 35.00, 10, 'P10-C3-S6', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(150, 10, 3, 7, 37.00, 10, 'P10-C3-S7', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(151, 10, 3, 8, 39.00, 10, 'P10-C3-S8', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(152, 10, 3, 9, 42.00, 10, 'P10-C3-S9', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(153, 10, 4, 6, 37.00, 10, 'P10-C4-S6', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(154, 10, 4, 7, 39.00, 10, 'P10-C4-S7', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(155, 10, 4, 8, 41.00, 10, 'P10-C4-S8', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(156, 10, 4, 9, 44.00, 10, 'P10-C4-S9', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(157, 10, 5, 6, 32.00, 10, 'P10-C5-S6', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(158, 10, 5, 7, 34.00, 10, 'P10-C5-S7', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(159, 10, 5, 8, 36.00, 10, 'P10-C5-S8', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(160, 10, 5, 9, 39.00, 10, 'P10-C5-S9', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(161, 11, 1, 6, 18.00, 10, 'P11-C1-S6', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(162, 11, 1, 7, 20.00, 10, 'P11-C1-S7', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(163, 11, 1, 8, 22.00, 10, 'P11-C1-S8', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(164, 11, 1, 9, 25.00, 10, 'P11-C1-S9', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(165, 11, 2, 6, 21.00, 10, 'P11-C2-S6', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(166, 11, 2, 7, 23.00, 10, 'P11-C2-S7', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(167, 11, 2, 8, 25.00, 10, 'P11-C2-S8', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(168, 11, 2, 9, 28.00, 10, 'P11-C2-S9', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(169, 11, 3, 6, 23.00, 10, 'P11-C3-S6', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(170, 11, 3, 7, 25.00, 10, 'P11-C3-S7', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(171, 11, 3, 8, 27.00, 10, 'P11-C3-S8', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(172, 11, 3, 9, 30.00, 10, 'P11-C3-S9', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(173, 11, 4, 6, 25.00, 10, 'P11-C4-S6', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(174, 11, 4, 7, 27.00, 10, 'P11-C4-S7', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(175, 11, 4, 8, 29.00, 10, 'P11-C4-S8', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(176, 11, 4, 9, 32.00, 10, 'P11-C4-S9', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(177, 11, 5, 6, 20.00, 10, 'P11-C5-S6', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(178, 11, 5, 7, 22.00, 10, 'P11-C5-S7', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(179, 11, 5, 8, 24.00, 10, 'P11-C5-S8', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(180, 11, 5, 9, 27.00, 10, 'P11-C5-S9', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(181, 12, 1, 6, 30.00, 10, 'P12-C1-S6', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(182, 12, 1, 7, 32.00, 10, 'P12-C1-S7', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(183, 12, 1, 8, 34.00, 10, 'P12-C1-S8', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(184, 12, 1, 9, 37.00, 10, 'P12-C1-S9', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(185, 12, 2, 6, 33.00, 10, 'P12-C2-S6', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(186, 12, 2, 7, 35.00, 10, 'P12-C2-S7', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(187, 12, 2, 8, 37.00, 10, 'P12-C2-S8', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(188, 12, 2, 9, 40.00, 3, 'P12-C2-S9', '2025-04-16 13:18:52', '2025-04-18 00:58:05'),
(189, 12, 3, 6, 35.00, 10, 'P12-C3-S6', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(190, 12, 3, 7, 37.00, 10, 'P12-C3-S7', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(191, 12, 3, 8, 39.00, 10, 'P12-C3-S8', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(192, 12, 3, 9, 42.00, 10, 'P12-C3-S9', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(193, 12, 4, 6, 37.00, 10, 'P12-C4-S6', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(194, 12, 4, 7, 39.00, 10, 'P12-C4-S7', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(195, 12, 4, 8, 41.00, 10, 'P12-C4-S8', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(196, 12, 4, 9, 44.00, 10, 'P12-C4-S9', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(197, 12, 5, 6, 32.00, 10, 'P12-C5-S6', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(198, 12, 5, 7, 34.00, 10, 'P12-C5-S7', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(199, 12, 5, 8, 36.00, 10, 'P12-C5-S8', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(200, 12, 5, 9, 39.00, 10, 'P12-C5-S9', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(201, 13, 1, 6, 30.00, 10, 'P13-C1-S6', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(202, 13, 1, 7, 32.00, 10, 'P13-C1-S7', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(203, 13, 1, 8, 34.00, 10, 'P13-C1-S8', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(204, 13, 1, 9, 37.00, 10, 'P13-C1-S9', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(205, 13, 2, 6, 33.00, 10, 'P13-C2-S6', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(206, 13, 2, 7, 35.00, 10, 'P13-C2-S7', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(207, 13, 2, 8, 37.00, 10, 'P13-C2-S8', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(208, 13, 2, 9, 40.00, 10, 'P13-C2-S9', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(209, 13, 3, 6, 35.00, 10, 'P13-C3-S6', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(210, 13, 3, 7, 37.00, 10, 'P13-C3-S7', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(211, 13, 3, 8, 39.00, 10, 'P13-C3-S8', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(212, 13, 3, 9, 42.00, 10, 'P13-C3-S9', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(213, 13, 4, 6, 37.00, 10, 'P13-C4-S6', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(214, 13, 4, 7, 39.00, 10, 'P13-C4-S7', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(215, 13, 4, 8, 41.00, 10, 'P13-C4-S8', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(216, 13, 4, 9, 44.00, 10, 'P13-C4-S9', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(217, 13, 5, 6, 32.00, 10, 'P13-C5-S6', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(218, 13, 5, 7, 34.00, 10, 'P13-C5-S7', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(219, 13, 5, 8, 36.00, 10, 'P13-C5-S8', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(220, 13, 5, 9, 39.00, 10, 'P13-C5-S9', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(221, 14, 1, 6, 8.00, 10, 'P14-C1-S6', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(222, 14, 1, 7, 10.00, 10, 'P14-C1-S7', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(223, 14, 1, 8, 12.00, 10, 'P14-C1-S8', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(224, 14, 1, 9, 15.00, 10, 'P14-C1-S9', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(225, 14, 2, 6, 11.00, 10, 'P14-C2-S6', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(226, 14, 2, 7, 13.00, 10, 'P14-C2-S7', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(227, 14, 2, 8, 15.00, 10, 'P14-C2-S8', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(228, 14, 2, 9, 18.00, 10, 'P14-C2-S9', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(229, 14, 3, 6, 13.00, 10, 'P14-C3-S6', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(230, 14, 3, 7, 15.00, 10, 'P14-C3-S7', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(231, 14, 3, 8, 17.00, 10, 'P14-C3-S8', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(232, 14, 3, 9, 20.00, 10, 'P14-C3-S9', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(233, 14, 4, 6, 15.00, 10, 'P14-C4-S6', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(234, 14, 4, 7, 17.00, 10, 'P14-C4-S7', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(235, 14, 4, 8, 19.00, 10, 'P14-C4-S8', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(236, 14, 4, 9, 22.00, 10, 'P14-C4-S9', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(237, 14, 5, 6, 10.00, 10, 'P14-C5-S6', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(238, 14, 5, 7, 12.00, 10, 'P14-C5-S7', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(239, 14, 5, 8, 14.00, 10, 'P14-C5-S8', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(240, 14, 5, 9, 17.00, 10, 'P14-C5-S9', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(241, 15, 1, 6, 4.00, 10, 'P15-C1-S6', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(242, 15, 1, 7, 6.00, 10, 'P15-C1-S7', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(243, 15, 1, 8, 8.00, 10, 'P15-C1-S8', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(244, 15, 1, 9, 11.00, 10, 'P15-C1-S9', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(245, 15, 2, 6, 7.00, 10, 'P15-C2-S6', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(246, 15, 2, 7, 9.00, 10, 'P15-C2-S7', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(247, 15, 2, 8, 11.00, 10, 'P15-C2-S8', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(248, 15, 2, 9, 14.00, 10, 'P15-C2-S9', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(249, 15, 3, 6, 9.00, 10, 'P15-C3-S6', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(250, 15, 3, 7, 11.00, 10, 'P15-C3-S7', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(251, 15, 3, 8, 13.00, 10, 'P15-C3-S8', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(252, 15, 3, 9, 16.00, 10, 'P15-C3-S9', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(253, 15, 4, 6, 11.00, 10, 'P15-C4-S6', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(254, 15, 4, 7, 13.00, 10, 'P15-C4-S7', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(255, 15, 4, 8, 15.00, 10, 'P15-C4-S8', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(256, 15, 4, 9, 18.00, 10, 'P15-C4-S9', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(257, 15, 5, 6, 6.00, 10, 'P15-C5-S6', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(258, 15, 5, 7, 8.00, 10, 'P15-C5-S7', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(259, 15, 5, 8, 10.00, 10, 'P15-C5-S8', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(260, 15, 5, 9, 13.00, 10, 'P15-C5-S9', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(261, 17, 1, 6, 8.00, 10, 'P17-C1-S6', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(262, 17, 1, 7, 10.00, 10, 'P17-C1-S7', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(263, 17, 1, 8, 12.00, 10, 'P17-C1-S8', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(264, 17, 1, 9, 15.00, 10, 'P17-C1-S9', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(265, 17, 2, 6, 11.00, 10, 'P17-C2-S6', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(266, 17, 2, 7, 13.00, 10, 'P17-C2-S7', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(267, 17, 2, 8, 15.00, 10, 'P17-C2-S8', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(268, 17, 2, 9, 18.00, 10, 'P17-C2-S9', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(269, 17, 3, 6, 13.00, 10, 'P17-C3-S6', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(270, 17, 3, 7, 15.00, 10, 'P17-C3-S7', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(271, 17, 3, 8, 17.00, 10, 'P17-C3-S8', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(272, 17, 3, 9, 20.00, 10, 'P17-C3-S9', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(273, 17, 4, 6, 15.00, 10, 'P17-C4-S6', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(274, 17, 4, 7, 17.00, 10, 'P17-C4-S7', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(275, 17, 4, 8, 19.00, 10, 'P17-C4-S8', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(276, 17, 4, 9, 22.00, 10, 'P17-C4-S9', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(277, 17, 5, 6, 10.00, 10, 'P17-C5-S6', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(278, 17, 5, 7, 12.00, 10, 'P17-C5-S7', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(279, 17, 5, 8, 14.00, 10, 'P17-C5-S8', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(280, 17, 5, 9, 17.00, 10, 'P17-C5-S9', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(281, 18, 1, 6, 10.00, 9, 'P18-C1-S6', '2025-04-16 13:18:52', '2025-04-22 19:09:28'),
(282, 18, 1, 7, 12.00, 2, 'P18-C1-S7', '2025-04-16 13:18:52', '2025-04-22 19:09:28'),
(283, 18, 1, 8, 14.00, 10, 'P18-C1-S8', '2025-04-16 13:18:52', '2025-04-22 19:09:28'),
(284, 18, 1, 9, 17.00, 10, 'P18-C1-S9', '2025-04-16 13:18:52', '2025-04-22 19:09:28'),
(285, 18, 2, 6, 13.00, 10, 'P18-C2-S6', '2025-04-16 13:18:52', '2025-04-22 19:09:29'),
(286, 18, 2, 7, 15.00, 10, 'P18-C2-S7', '2025-04-16 13:18:52', '2025-04-22 19:09:29'),
(287, 18, 2, 8, 17.00, 10, 'P18-C2-S8', '2025-04-16 13:18:52', '2025-04-22 19:09:28'),
(288, 18, 2, 9, 20.00, 10, 'P18-C2-S9', '2025-04-16 13:18:52', '2025-04-22 19:09:28'),
(289, 18, 3, 6, 15.00, 10, 'P18-C3-S6', '2025-04-16 13:18:52', '2025-04-22 19:09:29'),
(290, 18, 3, 7, 17.00, 10, 'P18-C3-S7', '2025-04-16 13:18:52', '2025-04-22 19:09:29'),
(291, 18, 3, 8, 19.00, 10, 'P18-C3-S8', '2025-04-16 13:18:52', '2025-04-22 19:09:29'),
(292, 18, 3, 9, 22.00, 10, 'P18-C3-S9', '2025-04-16 13:18:52', '2025-04-22 19:09:29'),
(293, 18, 4, 6, 17.00, 10, 'P18-C4-S6', '2025-04-16 13:18:52', '2025-04-22 19:09:29'),
(294, 18, 4, 7, 19.00, 10, 'P18-C4-S7', '2025-04-16 13:18:52', '2025-04-22 19:09:29'),
(295, 18, 4, 8, 21.00, 10, 'P18-C4-S8', '2025-04-16 13:18:52', '2025-04-22 19:09:29'),
(296, 18, 4, 9, 24.00, 10, 'P18-C4-S9', '2025-04-16 13:18:52', '2025-04-22 19:09:29'),
(297, 18, 5, 6, 12.00, 10, 'P18-C5-S6', '2025-04-16 13:18:52', '2025-04-22 19:09:29'),
(298, 18, 5, 7, 14.00, 10, 'P18-C5-S7', '2025-04-16 13:18:52', '2025-04-22 19:09:29'),
(299, 18, 5, 8, 16.00, 10, 'P18-C5-S8', '2025-04-16 13:18:52', '2025-04-22 19:09:29'),
(300, 18, 5, 9, 19.00, 10, 'P18-C5-S9', '2025-04-16 13:18:52', '2025-04-22 19:09:29'),
(301, 19, 1, 6, 5.00, 10, 'P19-C1-S6', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(302, 19, 1, 7, 7.00, 10, 'P19-C1-S7', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(303, 19, 1, 8, 9.00, 10, 'P19-C1-S8', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(304, 19, 1, 9, 12.00, 10, 'P19-C1-S9', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(305, 19, 2, 6, 8.00, 2, 'P19-C2-S6', '2025-04-16 13:18:52', '2025-04-18 00:10:52'),
(306, 19, 2, 7, 10.00, 0, 'P19-C2-S7', '2025-04-16 13:18:52', '2025-04-23 01:39:32'),
(307, 19, 2, 8, 12.00, 10, 'P19-C2-S8', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(308, 19, 2, 9, 15.00, 10, 'P19-C2-S9', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(309, 19, 3, 6, 10.00, 10, 'P19-C3-S6', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(310, 19, 3, 7, 12.00, 10, 'P19-C3-S7', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(311, 19, 3, 8, 14.00, 10, 'P19-C3-S8', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(312, 19, 3, 9, 17.00, 9, 'P19-C3-S9', '2025-04-16 13:18:52', '2025-04-22 18:29:07'),
(313, 19, 4, 6, 12.00, 10, 'P19-C4-S6', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(314, 19, 4, 7, 14.00, 10, 'P19-C4-S7', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(315, 19, 4, 8, 16.00, 10, 'P19-C4-S8', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(316, 19, 4, 9, 19.00, 10, 'P19-C4-S9', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(317, 19, 5, 6, 7.00, 10, 'P19-C5-S6', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(318, 19, 5, 7, 9.00, 10, 'P19-C5-S7', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(319, 19, 5, 8, 11.00, 10, 'P19-C5-S8', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(320, 19, 5, 9, 14.00, 10, 'P19-C5-S9', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(321, 20, 1, 6, 5.00, 10, 'P20-C1-S6', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(322, 20, 1, 7, 7.00, 10, 'P20-C1-S7', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(323, 20, 1, 8, 9.00, 10, 'P20-C1-S8', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(324, 20, 1, 9, 12.00, 10, 'P20-C1-S9', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(325, 20, 2, 6, 8.00, 10, 'P20-C2-S6', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(326, 20, 2, 7, 10.00, -8, 'P20-C2-S7', '2025-04-16 13:18:52', '2025-04-23 01:39:32'),
(327, 20, 2, 8, 12.00, 10, 'P20-C2-S8', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(328, 20, 2, 9, 15.00, 10, 'P20-C2-S9', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(329, 20, 3, 6, 10.00, 10, 'P20-C3-S6', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(330, 20, 3, 7, 12.00, 10, 'P20-C3-S7', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(331, 20, 3, 8, 14.00, 10, 'P20-C3-S8', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(332, 20, 3, 9, 17.00, 10, 'P20-C3-S9', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(333, 20, 4, 6, 12.00, 10, 'P20-C4-S6', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(334, 20, 4, 7, 14.00, 10, 'P20-C4-S7', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(335, 20, 4, 8, 16.00, 10, 'P20-C4-S8', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(336, 20, 4, 9, 19.00, 10, 'P20-C4-S9', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(337, 20, 5, 6, 7.00, 10, 'P20-C5-S6', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(338, 20, 5, 7, 9.00, 10, 'P20-C5-S7', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(339, 20, 5, 8, 11.00, 10, 'P20-C5-S8', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(340, 20, 5, 9, 14.00, 10, 'P20-C5-S9', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(341, 21, 1, 6, 20.00, 10, 'P21-C1-S6', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(342, 21, 1, 7, 22.00, 10, 'P21-C1-S7', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(343, 21, 1, 8, 24.00, 10, 'P21-C1-S8', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(344, 21, 1, 9, 27.00, 10, 'P21-C1-S9', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(345, 21, 2, 6, 23.00, 10, 'P21-C2-S6', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(346, 21, 2, 7, 25.00, 10, 'P21-C2-S7', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(347, 21, 2, 8, 27.00, 10, 'P21-C2-S8', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(348, 21, 2, 9, 30.00, 10, 'P21-C2-S9', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(349, 21, 3, 6, 25.00, 10, 'P21-C3-S6', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(350, 21, 3, 7, 27.00, 10, 'P21-C3-S7', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(351, 21, 3, 8, 29.00, 10, 'P21-C3-S8', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(352, 21, 3, 9, 32.00, 10, 'P21-C3-S9', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(353, 21, 4, 6, 27.00, 10, 'P21-C4-S6', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(354, 21, 4, 7, 29.00, 10, 'P21-C4-S7', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(355, 21, 4, 8, 31.00, 10, 'P21-C4-S8', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(356, 21, 4, 9, 34.00, 10, 'P21-C4-S9', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(357, 21, 5, 6, 22.00, 10, 'P21-C5-S6', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(358, 21, 5, 7, 24.00, 10, 'P21-C5-S7', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(359, 21, 5, 8, 26.00, 10, 'P21-C5-S8', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(360, 21, 5, 9, 29.00, 10, 'P21-C5-S9', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(361, 22, 1, 6, 10.00, 10, 'P22-C1-S6', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(362, 22, 1, 7, 12.00, 10, 'P22-C1-S7', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(363, 22, 1, 8, 14.00, 10, 'P22-C1-S8', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(364, 22, 1, 9, 17.00, 10, 'P22-C1-S9', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(365, 22, 2, 6, 13.00, 6, 'P22-C2-S6', '2025-04-16 13:18:52', '2025-04-23 01:39:32'),
(366, 22, 2, 7, 15.00, 10, 'P22-C2-S7', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(367, 22, 2, 8, 17.00, 10, 'P22-C2-S8', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(368, 22, 2, 9, 20.00, 10, 'P22-C2-S9', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(369, 22, 3, 6, 15.00, 10, 'P22-C3-S6', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(370, 22, 3, 7, 17.00, 10, 'P22-C3-S7', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(371, 22, 3, 8, 19.00, 10, 'P22-C3-S8', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(372, 22, 3, 9, 22.00, 10, 'P22-C3-S9', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(373, 22, 4, 6, 17.00, 10, 'P22-C4-S6', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(374, 22, 4, 7, 19.00, 10, 'P22-C4-S7', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(375, 22, 4, 8, 21.00, 10, 'P22-C4-S8', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(376, 22, 4, 9, 24.00, 10, 'P22-C4-S9', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(377, 22, 5, 6, 12.00, 10, 'P22-C5-S6', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(378, 22, 5, 7, 14.00, 10, 'P22-C5-S7', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(379, 22, 5, 8, 16.00, 10, 'P22-C5-S8', '2025-04-16 13:18:52', '2025-04-16 13:18:52'),
(380, 22, 5, 9, 19.00, 10, 'P22-C5-S9', '2025-04-16 13:18:52', '2025-04-16 13:18:52');

-- --------------------------------------------------------

--
-- Table structure for table `size`
--

CREATE TABLE `size` (
  `id` int NOT NULL,
  `name` varchar(4) NOT NULL,
  `productvarriants_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `size`
--

INSERT INTO `size` (`id`, `name`, `productvarriants_id`) VALUES
(6, 'XS', NULL),
(7, 'S', NULL),
(8, 'M', NULL),
(9, 'L', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `fullname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `phone_number` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `address` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `role_id` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted` int DEFAULT NULL,
  `reset_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `reset_token_expires` datetime DEFAULT NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `fullname`, `email`, `phone_number`, `address`, `password`, `role_id`, `created_at`, `updated_at`, `deleted`, `reset_token`, `reset_token_expires`, `avatar`) VALUES
(2, 'phuong', 'josakdosa@gmail.com', '2345678965', 'hai duong', '$2y$10$8MTGaCG5J6574.RgdWt26eL1UFJ1Ot3M39lQNS0nnsaH8dJligJqm', NULL, NULL, NULL, NULL, NULL, NULL, ''),
(5, 'phuong', 'nmphuong57007@gmail.com', '123123123', 'hp', '$2y$10$SiUzCWc98qY4gMnBegIT2.ebrrmdq1t1kqi6WNgZsl7RmZ46z1DLi', NULL, NULL, NULL, NULL, NULL, NULL, ''),
(6, 'phuong', 'np172005@gmail.com', '0123456789', 'Cam Giang', '$2y$10$987MdY0/7Gt2u1CEembFH.IgKxkYweMogtTt9aalVeC35et/m5QIO', NULL, NULL, NULL, NULL, NULL, NULL, '67fa7c5ea58b3-IMG_5620.JPG'),
(9, 'nguyễn quang linh', 'linhnp992004@gmail.com', '0564310422', '75 htm', '$2y$10$.aBEPzqT5//ujtH.yCT5/ukglKvXg9LeQqk7./VRi4t41SkR9mpfO', NULL, NULL, NULL, NULL, NULL, NULL, '680195dd62b3b-IMG_5954.jpg'),
(11, 'nguyễn quang linh', 'linhnqph46354@fpt.edu.vn', '05643104212', '75 htm', '$2y$10$8eZHKK6N1EwJA1t.5BnZhONctamaVbgKVU96kj9w0kHVVkb6bqvYS', NULL, NULL, NULL, NULL, NULL, NULL, '67fa6c8d1adc1-e54b91adf570882d30b8071317489ba9.JPG'),
(12, 'nguyễn quang linh', 'linhnp9920043@gmail.com', '0564310421', '385', '$2y$10$oqvPtNYTTfHunjGVcguQYuqczF6rcGlRuGVSMHsHRhnDNlzicgWCK', NULL, NULL, NULL, NULL, NULL, NULL, '6805d8f484a55-download (2).jpg'),
(13, 'phạm tuấn huy', 'linhnp99200@gmail.com', '0564310421', 'đẩu vũ, văn đẩu, kiến an, hp', '$2y$10$8d31jqf.UCh0nHl0.0eDcO.YgE8ilXZor1inuPWLfE4BUihbcox.O', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(14, 'phạm tuấn huy2', 'linhnp992005@gmail.com', '0564310421', 'đẩu vũ, văn đẩu, kiến an, hp', '$2y$10$goi/vh0u2h4YqJb8KEpp/O/z1yp/JQ11OVo/Zu9xbE8S7gfsEfMPm', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(15, 'Minh', 'ph57007@gmail.com', '236599865', 'hai duong', '$2y$10$g0/qBgKwG/olY67KlLmm4.PlM58a8Jn09.2aVga/UhvOSCBtpQW62', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(16, 'Quỳnh', 'quynh@gmail.com', '0235669845', 'hai duong', '$2y$10$0n9Wikf6Maym6/.Rlk8zHuNG1J.crmf0pOEKVSxOSLf38hGHXinuC', NULL, NULL, NULL, NULL, NULL, NULL, '680836c1bd89b-image24-1660292012-373-width2048height1696.jpg'),
(18, 'phuong', 'csdsd@gmail.com', '12312312', 'Hai Dương', '$2y$10$GcbtQEemCCqozHR/Hlbzp.RioHBb6hYwmbG1r0fisBhPw93w2Ks1.', NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_admin`
--

CREATE TABLE `user_admin` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_admin`
--

INSERT INTO `user_admin` (`id`, `username`, `password`) VALUES
(2, 'admin', 'e10adc3949ba59abbe56e057f20f883e');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `size_id` (`size_id`),
  ADD KEY `color_id` (`color_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `color`
--
ALTER TABLE `color`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`productvarriants_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `ỏder_detail_size` (`size_id`),
  ADD KEY `order_detail_color` (`color_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `size_id` (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `productrandy`
--
ALTER TABLE `productrandy`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `product_variants`
--
ALTER TABLE `product_variants`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_variant` (`product_id`,`color_id`,`size_id`),
  ADD UNIQUE KEY `sku` (`sku`),
  ADD KEY `color_id` (`color_id`),
  ADD KEY `size_id` (`size_id`);

--
-- Indexes for table `size`
--
ALTER TABLE `size`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`productvarriants_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `user_admin`
--
ALTER TABLE `user_admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=170;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `color`
--
ALTER TABLE `color`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `productrandy`
--
ALTER TABLE `productrandy`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `product_variants`
--
ALTER TABLE `product_variants`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=521;

--
-- AUTO_INCREMENT for table `size`
--
ALTER TABLE `size`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `user_admin`
--
ALTER TABLE `user_admin`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `lk_cart_color` FOREIGN KEY (`color_id`) REFERENCES `color` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `lk_cart_product` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `lk_cart_size` FOREIGN KEY (`size_id`) REFERENCES `size` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `lk_cart_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_detail_color` FOREIGN KEY (`color_id`) REFERENCES `color` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `ỏder_detail_size` FOREIGN KEY (`size_id`) REFERENCES `size` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);

--
-- Constraints for table `product_variants`
--
ALTER TABLE `product_variants`
  ADD CONSTRAINT `product_variants_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_variants_ibfk_2` FOREIGN KEY (`color_id`) REFERENCES `color` (`id`),
  ADD CONSTRAINT `product_variants_ibfk_3` FOREIGN KEY (`size_id`) REFERENCES `size` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
