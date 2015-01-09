<?php

use Illuminate\Database\Migrations\Migration;

class CreateMlmDatabase extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $sql = "
        USE `mlm`;
        CREATE DATABASE IF NOT EXISTS mlm DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

        DROP TABLE IF EXISTS `admins`;
        CREATE TABLE IF NOT EXISTS `admins` (
          `user_id` int(10) unsigned NOT NULL,
          `admin_id` int(10) unsigned NOT NULL,
          PRIMARY KEY (`user_id`),
          KEY `user_id` (`user_id`),
          KEY `admin_id` (`admin_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

        DROP TABLE IF EXISTS `customers`;
        CREATE TABLE IF NOT EXISTS `customers` (
          `user_id` int(10) unsigned NOT NULL,
          `ic_num` varchar(12) CHARACTER SET utf8 NOT NULL,
          `contact_num` varchar(20) CHARACTER SET utf8 NOT NULL,
          `heir_name` varchar(255) CHARACTER SET utf8 NOT NULL,
          `heir_contact_num` varchar(20) CHARACTER SET utf8 NOT NULL,
          `bank_account` varchar(100) CHARACTER SET utf8 NOT NULL,
          `account_num` varchar(50) CHARACTER SET utf8 NOT NULL,
          PRIMARY KEY (`user_id`),
          UNIQUE KEY `user_id` (`user_id`),
          KEY `ic_num` (`ic_num`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

        DROP TABLE IF EXISTS `downlines`;
        CREATE TABLE IF NOT EXISTS `downlines` (
          `user_id` int(10) unsigned NOT NULL,
          `downline_user_id` int(10) unsigned NOT NULL,
          PRIMARY KEY (`user_id`),
          KEY `downline_user_id` (`downline_user_id`),
          KEY `user_id` (`user_id`) USING BTREE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

        DROP TABLE IF EXISTS `profiles`;
        CREATE TABLE IF NOT EXISTS `profiles` (
          `user_id` int(10) unsigned NOT NULL,
          `full_name` varchar(255) CHARACTER SET utf8 NOT NULL,
          `gender` enum('female','male') CHARACTER SET utf8 NOT NULL,
          `contact_num` varchar(20) CHARACTER SET utf8 NOT NULL,
          `picture` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
          `created_date` datetime NOT NULL,
          PRIMARY KEY (`user_id`),
          UNIQUE KEY `user_id` (`user_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

        DROP TABLE IF EXISTS `users`;
        CREATE TABLE IF NOT EXISTS `users` (
          `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
          `username` varchar(255) CHARACTER SET utf8 NOT NULL,
          `password` varchar(255) CHARACTER SET utf8 NOT NULL,
          `status` enum('inactive','active') CHARACTER SET utf8 NOT NULL DEFAULT 'inactive',
          `groups` enum('regular_user','ultimate_user','regular_admin','super_admin') CHARACTER SET utf8 NOT NULL,
          PRIMARY KEY (`id`),
          UNIQUE KEY `id` (`id`),
          UNIQUE KEY `username` (`username`) USING BTREE,
          KEY `status` (`status`),
          KEY `groups` (`groups`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

        ALTER TABLE `admins`
          ADD CONSTRAINT `admins_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
          ADD CONSTRAINT `admins_ibfk_2` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

        ALTER TABLE `customers`
          ADD CONSTRAINT `customers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

        ALTER TABLE `downlines`
          ADD CONSTRAINT `downlines_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
          ADD CONSTRAINT `downlines_ibfk_2` FOREIGN KEY (`downline_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

        ALTER TABLE `profiles`
          ADD CONSTRAINT `profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;";

        DB::unprepared( $sql );
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('drop table admins');
        DB::unprepared('drop table customers');
        DB::unprepared('drop table downlines');
        DB::unprepared('drop table profiles');
        DB::unprepared('drop table users');

    }
}