-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 23, 2024 at 01:23 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `once_inicial_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `ID_Usuario` int(11) NOT NULL,
  `Usuario` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Telefono` varchar(15) DEFAULT NULL,
  `Direccion` varchar(255) DEFAULT NULL,
  `Fecha_Registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `Rol` enum('usuario','admin') NOT NULL,
  `Estado` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`ID_Usuario`, `Usuario`, `Email`, `Password`, `Telefono`, `Direccion`, `Fecha_Registro`, `Rol`, `Estado`) VALUES
(2, 'Alejandro Rodriguez', 'alejo.rodriguez013@gmail.com', '$2y$10$KRhJxduCY/L/dLEa7EQrH.liYkfsELU7fqXX6trzp4.2yNqwmJ/QG', '12332526', 'Cra 123 #45 A07', '2024-11-22 21:04:36', 'usuario', 1),
(3, 'Alejandro Rodriguez', 'alejo.rodriguez013@gmail.com', '$2y$10$5Kb8LdqAFHE1dWM4v/oxwOg4uoqM3ZdLC2A0yExIwQPlwqViNejQK', '12332526', 'Cra 123 #45 A07', '2024-11-22 21:04:47', 'usuario', 1),
(4, 'admin', 'admin@tusitio.com', '$2y$10$qcc7IYC8/9o1yMJgy85s0ON4FuBVfNEMQnX/qrVk8I3XtXER8uomy', '12332526', 'Cra 123 #45 A07', '2024-11-22 21:16:06', 'admin', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`ID_Usuario`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `ID_Usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
