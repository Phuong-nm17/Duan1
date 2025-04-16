-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 25, 2025 at 07:21 PM
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
(2, 'Black', NULL),
(3, 'white', NULL),
(4, 'Red', NULL),
(5, 'Blue', NULL),
(6, 'Green', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int NOT NULL,
  `firstname` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `lastname` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `phone_number` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `subject_name` varchar(350) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `note` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` int DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `galery`
--

CREATE TABLE `galery` (
  `id` int NOT NULL,
  `product_id` int DEFAULT NULL,
  `thumbnail` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `fullname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `phone_number` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `address` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `note` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `order_date` datetime DEFAULT NULL,
  `status` int DEFAULT NULL,
  `total_money` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` int NOT NULL,
  `order_id` int DEFAULT NULL,
  `product_id` int DEFAULT NULL,
  `price` int DEFAULT NULL,
  `num` int DEFAULT NULL,
  `total_money` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(3, 2, 'Dsgn Studio Collegiate Embroidered Boxy Zip Through Hoodie', 15, 25, 'https://media.boohoo.com/i/boohoo/hzz20399_ecru_xl/female-ecru-dsgn-studio-collegiate-embroidered-boxy-zip-through-hoodie-?w=675&qlt=default&fmt.jp2.qlt=70&fmt=auto&sm=fit', 'Steal the style top spot in a statement separate from the tops collection\r\n\r\nCamis or crops, bandeaus or bralets, we\'ve got all the trend-setting tops so you can stay statement in separates this season. Hit refresh on your jersey basics with pastel hues and pick a quirky kimono to give your ensemble that Eastern-inspired edge. Off the shoulder styles are oh-so-sweet, with slogans making your tee a talking point.', NULL, NULL, NULL),
(4, 2, 'Textured Button through v neck longline waistcoat', 12, 20, 'https://media.boohoo.com/i/boohoo/hzz24086_cream_xl/female-cream-textured-button-through-v-neck-longline-waistcoat?w=675&qlt=default&fmt.jp2.qlt=70&fmt=auto&sm=fit', 'Steal the style top spot in a statement separate from the tops collection\r\n\r\nCamis or crops, bandeaus or bralets, we\'ve got all the trend-setting tops so you can stay statement in separates this season. Hit refresh on your jersey basics with pastel hues and pick a quirky kimono to give your ensemble that Eastern-inspired edge. Off the shoulder styles are oh-so-sweet, with slogans making your tee a talking point.', NULL, NULL, NULL),
(5, 2, 'Suede Look Short Belted Trench Coat', 36, 60, 'https://media.boohoo.com/i/boohoo/hzz12904_brown_xl/female-brown-suede-look-short-belted-trench-coat?w=675&qlt=default&fmt.jp2.qlt=70&fmt=auto&sm=fit', 'Wrap up in the latest coats and jackets and get out-there with your outerwear\r\n\r\nBreathe life into your new season layering with the latest coats and jackets from boohoo. Supersize your silhouette in a padded jacket, stick to sporty styling with a bomber, or protect yourself from the elements in a plastic raincoat. For a more luxe layering piece, faux fur coats come in fondant shades and longline duster coats give your look an androgynous edge.\r\n\r\nShell: 50% Polyvinyl chloride, 40% Polyester, 10% Viscose. Lining: 100% Polyester. Do not wash. Model wears UK 10. Due to the delicate nature of the fabric, this fabric may naturally develop marks, scuffs, or variations in texture over time.', NULL, NULL, NULL),
(6, 2, 'Linen Look Pleated Tie Front Smock Top', 13, 22, 'https://media.boohoo.com/i/boohoo/hzz22844_white_xl/female-white-linen-look-pleated-tie-front-smock-top?w=675&qlt=default&fmt.jp2.qlt=70&fmt=auto&sm=fit', 'Steal the style top spot in a statement separate from the tops collection\r\n\r\nCamis or crops, bandeaus or bralets, we\'ve got all the trend-setting tops so you can stay statement in separates this season. Hit refresh on your jersey basics with pastel hues and pick a quirky kimono to give your ensemble that Eastern-inspired edge. Off the shoulder styles are oh-so-sweet, with slogans making your tee a talking point.', NULL, NULL, NULL),
(7, 2, 'Textured Button Through Waistcoat\r\n', 12, 20, 'https://media.boohoo.com/i/boohoo/hzz24646_olive_xl/female-olive-textured-button-through-waistcoat?w=675&qlt=default&fmt.jp2.qlt=70&fmt=auto&sm=fit', '', NULL, NULL, NULL),
(8, 2, 'Malibu Keychain Oversized T-shirt', 7, 12, 'https://media.boohoo.com/i/boohoo/hzz27028_white_xl/female-white-malibu-keychain-oversized-t-shirt?w=675&qlt=default&fmt.jp2.qlt=70&fmt=auto&sm=fit', 'Steal the style top spot in a statement separate from the tops collection\r\n\r\nCamis or crops, bandeaus or bralets, we\'ve got all the trend-setting tops so you can stay statement in separates this season. Hit refresh on your jersey basics with pastel hues and pick a quirky kimono to give your ensemble that Eastern-inspired edge. Off the shoulder styles are oh-so-sweet, with slogans making your tee a talking point.', NULL, NULL, NULL),
(9, 1, 'Oversized V Neck Baseball T-Shirt', 12, 20, 'https://media.boohoo.com/i/boohoo/cmm08797_navy_xl/male-navy-oversized-v-neck-baseball-t-shirt?w=675&qlt=default&fmt.jp2.qlt=70&fmt=auto&sm=fit', 'We all know about t-shirts and vests, light layers which have stood the test of time. T-shirts are a seasonless staple which gives your wardrobe a solid foundation to build off. Whether you’re about a plain tee, printed, striped or long-sleeve or you’re flexing something oversized for a comfortably casual look, make sure your outfits have the foundations they need with our range of tees and vests. Combine a plain white tee with denim and trainers for a versatile everyday outfit or pair with cropped trousers to secure minimalistic vibes.', NULL, NULL, NULL),
(10, 1, 'Regular Fit Crinkle Nylon Panelled Track Jacket', 18, 30, 'https://media.boohoo.com/i/boohoo/cmm08729_brown_xl/male-brown-regular-fit-crinkle-nylon-panelled-track-jacket?w=675&qlt=default&fmt.jp2.qlt=70&fmt=auto&sm=fit', 'Rev up your outerwear inventory with our unrivalled collection of coats and jackets for men. Whether you are looking for a heavy coat to combat the low temperatures or a lightweight jacket to stand out at your favourite festival, we\'ve got the trendiest designs to finish off your outfit. Puffers, parkas and borg jackets are the perfect choices if you want to bundle up without sacrificing on style, and they look great when teamed up with knitwear and denim. Bombers and overcoats are beyond versatile and can turn any getup from laid-back to dapper in no time. Denim jackets can\'t be missing in your trans-seasonal wardrobe, whilst cagoules and coach jackets will keep out the chill while you\'re out and about.', NULL, NULL, NULL),
(11, 1, 'Regular Fit Stripe Rugby Polo', 17, 18, 'https://media.boohoo.com/i/boohoo/cmm08817_black_xl/male-black-regular-fit-stripe-rugby-polo?w=675&qlt=default&fmt.jp2.qlt=70&fmt=auto&sm=fit', 'We all know about t-shirts and vests, light layers which have stood the test of time. T-shirts are a seasonless staple which gives your wardrobe a solid foundation to build off. Whether you’re about a plain tee, printed, striped or long-sleeve or you’re flexing something oversized for a comfortably casual look, make sure your outfits have the foundations they need with our range of tees and vests. Combine a plain white tee with denim and trainers for a versatile everyday outfit or pair with cropped trousers to secure minimalistic vibes.', NULL, NULL, NULL),
(12, 1, 'Plus Crinkle Nylon Panelled Regular Track Jacket', 21, 30, 'https://media.boohoo.com/i/boohoo/cmm08585_black_xl/male-black-plus-crinkle-nylon-panelled-regular-track-jacket?w=675&qlt=default&fmt.jp2.qlt=70&fmt=auto&sm=fit', 'Rev up your outerwear inventory with our unrivalled collection of coats and jackets for men. Whether you are looking for a heavy coat to combat the low temperatures or a lightweight jacket to stand out at your favourite festival, we\'ve got the trendiest designs to finish off your outfit. Puffers, parkas and borg jackets are the perfect choices if you want to bundle up without sacrificing on style, and they look great when teamed up with knitwear and denim. Bombers and overcoats are beyond versatile and can turn any getup from laid-back to dapper in no time. Denim jackets can\'t be missing in your trans-seasonal wardrobe, whilst cagoules and coach jackets will keep out the chill while you\'re out and about.', NULL, NULL, NULL),
(13, 1, 'Plus 330GSM Basic Oversized Over The Head Hoodie', 21, 30, 'https://media.boohoo.com/i/boohoo/cmm04240_black_xl/male-black-plus-330gsm-basic-oversized-over-the-head-hoodie?w=675&qlt=default&fmt.jp2.qlt=70&fmt=auto&sm=fit', 'Hoodies and sweatshirts are essential for boxing those clean, comfortable layers. Hoodies work as a classic mid-layer or a standalone everyday basic when the weather is a little bit warmer. When you want a minimal colourway to effortlessly finish off your outfit, choosing a sweatshirt is always a solid option. A staple in your wardrobe already, jersey hoodies and sweats are a failsafe grab-and-go for any occasion. Find the perfect casual top to complement your off-duty look in our selection of hoodies and sweats for men.', NULL, NULL, NULL),
(14, 1, 'Plus Basic Crew Neck Regular Fit T-shirt', 5, 8, 'https://media.boohoo.com/i/boohoo/cmm04473_black_xl/male-black-plus-basic-crew-neck-regular-fit-t-shirt?w=675&qlt=default&fmt.jp2.qlt=70&fmt=auto&sm=fit', 'We all know about t-shirts and vests, light layers which have stood the test of time. T-shirts are a seasonless staple which gives your wardrobe a solid foundation to build off. Whether you’re about a plain tee, printed, striped or long-sleeve or you’re flexing something oversized for a comfortably casual look, make sure your outfits have the foundations they need with our range of tees and vests. Combine a plain white tee with denim and trainers for a versatile everyday outfit or pair with cropped trousers to secure minimalistic vibes.', NULL, NULL, NULL),
(15, 3, 'Chunky Cuban Chain Necklace', 2, 4, 'https://media.boohoo.com/i/boohoo/bmm14674_silver_xl/male-silver-chunky-cuban-chain-necklace?w=675&qlt=default&fmt.jp2.qlt=70&fmt=auto&sm=fit', 'Wanna bring new energy? Complete your look with this men’s chain from our latest arrivals. Designed to provide the finishing touch to your outfit, wear this men’s necklace everywhere – from low-key days to weekend plays. Throw on with jeans and a tee to elevate your basics or wear with a suit to secure some serious serious style points. From men’s gold chains to silver options, we’ve got something for every kinda vibe.', NULL, NULL, NULL),
(17, 3, 'Paisley Printed Bandana In Black', 5, 8, 'https://media.boohoo.com/i/boohoo/bmm78735_black_xl/male-black-paisley-printed-bandana-in-black?w=675&qlt=default&fmt.jp2.qlt=70&fmt=auto&sm=fit', 'Add attitude with our fashion-forward men\'s accessories and inject some personality into your look. Add the perfect finishing touch, from bags and wallets to hats and belts. Find your favourites from rucksacks to beanies and turn heads in oversized sunglasses. Forget less is more, this season we\'re all for out-there statement accessories.', NULL, NULL, NULL),
(18, 3, 'Black Belt With Silver Buckle', 8, 12, 'https://media.boohoo.com/i/boohoo/cmm01516_black_xl/male-black-black-belt-with-silver-buckle?w=675&qlt=default&fmt.jp2.qlt=70&fmt=auto&sm=fit', NULL, NULL, NULL, NULL),
(19, 3, 'Double Hooped Earrings', 3, 5, 'https://media.boohoo.com/i/boohoo/gzz69301_gold_xl/female-gold-double-hooped-earrings-?w=675&qlt=default&fmt.jp2.qlt=70&fmt=auto&sm=fit', 'Earrings are the must-have accessory of the moment. From simple stud earrings to statement drop designs, our women\'s earrings collection features the hottest styles around. Go with silver or gold earrings to add attitude to the most simplest of looks. We are all about keeping you in this season\'s style loop, so check out our fashion earrings and new season hoop designs to add detail to your \'fits.', NULL, NULL, NULL),
(20, 3, 'Hammered Oval Drop Necklace', 3, 5, 'https://media.boohoo.com/i/boohoo/hzz20260_gold_xl/female-gold-hammered-oval-drop-necklace?w=675&qlt=default&fmt.jp2.qlt=70&fmt=auto&sm=fit', 'Add attitude with accessories for those fashion-forward finishing touches\r\n\r\nIt\'s all about accessories for injecting individuality into your look. Find your festival favourites from fedora hats and floral crowns to bumbags and body glitter, play up your partywear with a pop of pastel nail polish and make a statement in oversized sunglasses. Forget less is more, this season we\'re all for out-there hair, beauty and jewellery.', NULL, NULL, NULL),
(21, 3, 'Quilted Faux Leather Crossbody Chain Bag', 12, 20, 'https://media.boohoo.com/i/boohoo/fzz67448_white_xl/female-white-quilted-faux-leather-crossbody-chain-bag?w=675&qlt=default&fmt.jp2.qlt=70&fmt=auto&sm=fit', 'It’s that magical moment when the perfect accessory meets practicality - introducing the crossbody bag. With one long strap that sits across the body, while the actual bag rests on your waist, this is a secure option for keeping hold of all your valuables. Love festivals? Parties? Got travel plans? No problem, never wake up without your phone, card or house keys ever again. Keep your hands free for the important stuff (like scrolling) and keep looking cute at the same time.', NULL, NULL, NULL);

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
(12, NULL, 'Plus Crinkle Nylon Panelled Regular Track Jacket', 21, 30, 'https://media.boohoo.com/i/boohoo/cmm08585_black_xl/male-black-plus-crinkle-nylon-panelled-regular-track-jacket?w=675&qlt=default&fmt.jp2.qlt=70&fmt=auto&sm=fit', 'Rev up your outerwear inventory with our unrivalled collection of coats and jackets for men. Whether you are looking for a heavy coat to combat the low temperatures or a lightweight jacket to stand out at your favourite festival, we\'ve got the trendiest designs to finish off your outfit. Puffers, parkas and borg jackets are the perfect choices if you want to bundle up without sacrificing on style, and they look great when teamed up with knitwear and denim. Bombers and overcoats are beyond versatile and can turn any getup from laid-back to dapper in no time. Denim jackets can\'t be missing in your trans-seasonal wardrobe, whilst cagoules and coach jackets will keep out the chill while you\'re out and about.', NULL, NULL, NULL, 'black', 'Select'),
(13, NULL, 'Plus 330GSM Basic Oversized Over The Head Hoodie', 21, 30, 'https://media.boohoo.com/i/boohoo/cmm04240_black_xl/male-black-plus-330gsm-basic-oversized-over-the-head-hoodie?w=675&qlt=default&fmt.jp2.qlt=70&fmt=auto&sm=fit', 'Hoodies and sweatshirts are essential for boxing those clean, comfortable layers. Hoodies work as a classic mid-layer or a standalone everyday basic when the weather is a little bit warmer. When you want a minimal colourway to effortlessly finish off your outfit, choosing a sweatshirt is always a solid option. A staple in your wardrobe already, jersey hoodies and sweats are a failsafe grab-and-go for any occasion. Find the perfect casual top to complement your off-duty look in our selection of hoodies and sweats for men.', NULL, NULL, NULL, 'black', 'Select'),
(15, NULL, 'Chunky Cuban Chain Necklace', 2, 4, 'https://media.boohoo.com/i/boohoo/bmm14674_silver_xl/male-silver-chunky-cuban-chain-necklace?w=675&qlt=default&fmt.jp2.qlt=70&fmt=auto&sm=fit', 'Wanna bring new energy? Complete your look with this men’s chain from our latest arrivals. Designed to provide the finishing touch to your outfit, wear this men’s necklace everywhere – from low-key days to weekend plays. Throw on with jeans and a tee to elevate your basics or wear with a suit to secure some serious serious style points. From men’s gold chains to silver options, we’ve got something for every kinda vibe.', NULL, NULL, NULL, 'silver', 'One size'),
(17, NULL, 'Paisley Printed Bandana In Black', 5, 8, 'https://media.boohoo.com/i/boohoo/bmm78735_black_xl/male-black-paisley-printed-bandana-in-black?w=675&qlt=default&fmt.jp2.qlt=70&fmt=auto&sm=fit', 'Add attitude with our fashion-forward men\'s accessories and inject some personality into your look. Add the perfect finishing touch, from bags and wallets to hats and belts. Find your favourites from rucksacks to beanies and turn heads in oversized sunglasses. Forget less is more, this season we\'re all for out-there statement accessories.', NULL, NULL, NULL, 'black', 'One size'),
(18, NULL, 'Black Belt With Silver Buckle', 8, 12, 'https://media.boohoo.com/i/boohoo/cmm01516_black_xl/male-black-black-belt-with-silver-buckle?w=675&qlt=default&fmt.jp2.qlt=70&fmt=auto&sm=fit', NULL, NULL, NULL, NULL, 'black', 'One size'),
(20, NULL, 'Hammered Oval Drop Necklace', 3, 5, 'https://media.boohoo.com/i/boohoo/hzz20260_gold_xl/female-gold-hammered-oval-drop-necklace?w=675&qlt=default&fmt.jp2.qlt=70&fmt=auto&sm=fit', 'Add attitude with accessories for those fashion-forward finishing touches\r\n\r\nIt\'s all about accessories for injecting individuality into your look. Find your festival favourites from fedora hats and floral crowns to bumbags and body glitter, play up your partywear with a pop of pastel nail polish and make a statement in oversized sunglasses. Forget less is more, this season we\'re all for out-there hair, beauty and jewellery.', NULL, NULL, NULL, 'Golde', 'One size');

-- --------------------------------------------------------

--
-- Table structure for table `productvarriants`
--

CREATE TABLE `productvarriants` (
  `id` int NOT NULL,
  `product_id` int DEFAULT NULL,
  `color_id` int DEFAULT NULL,
  `size_id` int DEFAULT NULL,
  `price` int DEFAULT NULL,
  `discount` int DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `quantity` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int NOT NULL,
  `name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Table structure for table `tokens`
--

CREATE TABLE `tokens` (
  `user_id` int NOT NULL,
  `token` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `deleted` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `fullname`, `email`, `phone_number`, `address`, `password`, `role_id`, `created_at`, `updated_at`, `deleted`) VALUES
(2, 'phuong', 'josakdosa@gmail.com', '2345678965', 'hai duong', '$2y$10$8MTGaCG5J6574.RgdWt26eL1UFJ1Ot3M39lQNS0nnsaH8dJligJqm', NULL, NULL, NULL, NULL),
(3, 'phuong', 'josakdosa@gmail.com', '2345678965', 'hai duong', '$2y$10$d7AyBU/wy1MHgESp19r32uqBE625f9fJdcYEwe0xOwSx33x/HQo2S', NULL, NULL, NULL, NULL),
(4, 'Phuong', 'nmphuong57007@gmail.com', '123123123', 'hai duong', '$2y$10$ZgcFt5QIdLv4.suiv3jHq.Wax9Q7PfjkldVfQKtjRlzEnMIIJZLou', NULL, NULL, NULL, NULL),
(5, 'phuong', 'nmphuong57007@gmail.com', '123123123', 'hp', '$2y$10$fwVlX5oLdso3qqn0vjIFwu/FCdyBS1CKg.LBpkq48bj1IC28k/lg6', NULL, NULL, NULL, NULL),
(6, 'phuong', 'np172005@gmail.com', '12312312', 'hai duong', '$2y$10$QVvjCUf2tlSz/v.9ydK4GuhjW7Ep8rHhOzqScR/d.VhzpthyjJS7i', NULL, NULL, NULL, NULL),
(7, 'phuong', 'josakdosa@gmail.com', '123456', 'hai duong', '$2y$10$mnQgVp4e/1NhMGEOFCZJyOlL4DPy55eVTR/GPWTNxXply74Mf3P/6', NULL, NULL, NULL, NULL),
(8, 'phuong', 'np172005@gmail.com', '12345678', 'hai duong', '$2y$10$isHFAYvuHbWyxOj.EyM4V.lq0/5055gYNDgtmlkcPx271aqEHBwSC', NULL, NULL, NULL, NULL);

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
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `galery`
--
ALTER TABLE `galery`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

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
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `productrandy`
--
ALTER TABLE `productrandy`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `productvarriants`
--
ALTER TABLE `productvarriants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lk_productvarriants_size` (`size_id`),
  ADD KEY `lk_productvarriants_color` (`color_id`),
  ADD KEY `lk_productvarriants_product` (`product_id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `size`
--
ALTER TABLE `size`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`productvarriants_id`);

--
-- Indexes for table `tokens`
--
ALTER TABLE `tokens`
  ADD PRIMARY KEY (`user_id`,`token`);

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
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `color`
--
ALTER TABLE `color`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `galery`
--
ALTER TABLE `galery`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `productrandy`
--
ALTER TABLE `productrandy`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `productvarriants`
--
ALTER TABLE `productvarriants`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `size`
--
ALTER TABLE `size`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user_admin`
--
ALTER TABLE `user_admin`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `galery`
--
ALTER TABLE `galery`
  ADD CONSTRAINT `galery_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);

--
-- Constraints for table `productvarriants`
--
ALTER TABLE `productvarriants`
  ADD CONSTRAINT `lk_productvarriants_color` FOREIGN KEY (`color_id`) REFERENCES `color` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `lk_productvarriants_product` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `lk_productvarriants_size` FOREIGN KEY (`size_id`) REFERENCES `size` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `tokens`
--
ALTER TABLE `tokens`
  ADD CONSTRAINT `tokens_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
