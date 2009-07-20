<?php

/*
Name:    gdDBInstallGDSR
Version: 1.1.0
Author:  Milan Petrovic
Email:   milan@gdragon.info
Website: http://wp.gdragon.info/

== Copyright ==

Copyright 2008 Milan Petrovic (email : milan@gdragon.info)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if (!class_exists('gdDBInstallGDSR')) {
    /*
     * Class for installing, droping, populating and upgrading database tables using the file format for each table.
     */
    class gdDBInstallGDSR {
        /**
         * Drops all tables according to the table names.
         *
         * @global object $wpdb Wordpress DB class
         * @global string $table_prefix Wordpress table prefix
         * @param string $path base path to folder where the install folder is located with trailing slash
         */
        function drop_tables($path) {
            global $wpdb, $table_prefix;
            $path.= "install/tables";
            $files = gdDBInstallGDSR::scan_folder($path);
            foreach ($files as $file) {
                $file_path = $path."/".$file;
                $table_name = $table_prefix.substr($file, 0, strlen($file) - 4);
                $wpdb->query("drop table ".$table_name);
            }
        }

        /**
         * Drops the table from the database.
         *
         * @global object $wpdb Wordpress DB class
         * @global string $table_prefix Wordpress table prefix
         * @param <type> $table_name table to drop without the prefix
         */
        function drop_table($table_name) {
            global $wpdb, $table_prefix;
            $wpdb->query("drop table ".$table_prefix.$table_name);
        }

        /**
         * Executes alert scrips from alert.txt file.
         *
         * @global object $wpdb Wordpress DB class
         * @global string $table_prefix Wordpress table prefix
         * @param string $path base path to folder where the install folder is located with trailing slash
         */
        function alter_tables($path) {
            global $wpdb, $table_prefix;
            $path.= "install/alter.txt";
            if (file_exists($path)) {
                $alters = file($path);
                foreach ($alters as $a) {
                    if (trim($a) != '') {
                        $a = sprintf($a, $table_prefix);
                        $wpdb->query($a);
                    }
                }
            }
        }

        /**
         * Executes drop scrips from delete.txt file.
         *
         * @global object $wpdb Wordpress DB class
         * @global string $table_prefix Wordpress table prefix
         * @param string $path base path to folder where the install folder is located with trailing slash
         */
        function delete_tables($path) {
            global $wpdb, $table_prefix;
            $path.= "install/delete.txt";
            if (file_exists($path)) {
                $tables = file($path);
                foreach ($tables as $table_name) {
                    if (trim($table_name) != '') {
                        $table_name = $table_prefix.$table_name;
                        $wpdb->query("drop table ".$table_name);
                    }
                }
            }
        }

        /**
         * Upgrades database tables.
         *
         * @param string $path base path to folder where the install folder is located with trailing slash
         */
        function upgrade_tables($path) {
            $path.= "install/tables";
            $files = gdDBInstallGDSR::scan_folder($path);
            foreach ($files as $file) {
                gdDBInstallGDSR::upgrade_table($path, $file);
            }
        }

        /**
         * Checks if the column exists in the table columns.
         *
         * @param array $columns all columns in the table
         * @param string $column column name to check
         */
        function check_column($columns, $column) {
            foreach ($columns as $c)
                if ($c->Field == $column) return true;
            return false;
        }

        /**
         * Upgrades table.
         *
         * @global object $wpdb Wordpress DB class
         * @global string $table_prefix Wordpress table prefix
         * @param string $path base path to folder where the install folder is located with trailing slash
         * @param string $file table file name
         */
        function upgrade_table($path, $file) {
            global $wpdb, $table_prefix;
            $file_path = $path."/".$file;
            $table_name = $table_prefix.substr($file, 0, strlen($file) - 4);
            $columns = $wpdb->get_results(sprintf("SHOW COLUMNS FROM %s", $table_name));
            $fc = file($file_path);
            $after = '';
            foreach ($fc as $f) {
                $f = trim($f);
                if (substr($f, 0, 1) == "`") {
                    $column = substr($f, 1);
                    $column = substr($column, 0, strpos($column, "`"));
                    if (!gdDBInstallGDSR::check_column($columns, $column))
                        gdDBInstallGDSR::add_column($table_name, $f, $after);
                    $after = $column;
                }
            }
        }

        /**
         * Adds column to the database.
         *
         * @global object $wpdb Wordpress DB class
         * @param string $table table name
         * @param string $column_info column definition
         * @param string $position column name used for after element in alter table
         */
        function add_column($table, $column_info, $position = '') {
            global $wpdb;
            if (substr($column_info, -1) == ",")
                $column_info = substr($column_info, 0, strlen($column_info) - 1);
            if ($position == '') $position = "FIRST";
            else $position = "AFTER ".$position;
            $sql = sprintf("ALTER TABLE %s ADD %s %s", $table, $column_info, $position);
            $wpdb->query($sql);
        }

        /**
         * Creates table based on the table install file
         *
         * @global object $wpdb Wordpress DB class
         * @global string $table_prefix Wordpress table prefix
         * @param string $path base path to folder where the install folder is located with trailing slash
         */
        function create_tables($path) {
            global $wpdb, $table_prefix;
            $path.= "install/tables";
            $files = gdDBInstallGDSR::scan_folder($path);
            foreach ($files as $file) {
                $file_path = $path."/".$file;
                $table_name = $table_prefix.substr($file, 0, strlen($file) - 4);
                if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
                    $fc = file($file_path);
                    $first = true;
                    $sql = "";
                    foreach ($fc as $f) {
                        if ($first) {
                            $sql.= sprintf($f, $table_prefix);
                            $first = false;
                        }
                        else $sql.= $f;
                    }
                    $wpdb->query($sql);
                }
            }
        }

        /**
         * Imports data from file into table
         *
         * @global object $wpdb Wordpress DB class
         * @global string $table_prefix Wordpress table prefix
         * @param string $path base path to folder where the install folder is located with trailing slash
         */
        function import_data($path) {
            global $wpdb, $table_prefix;
            $path.= "install/data";
            $files = gdDBInstallGDSR::scan_folder($path);
            $wpdb->show_errors = true;
            foreach ($files as $file) {
                if (substr($file, 0, 1) != '.') {
                    $file_path = $path."/".$file;
                    $handle = @fopen($file_path, "r");
                    if ($handle) {
                         while (!feof($handle)) {
                             $line = fgets($handle);
                             $sql = sprintf($line, $table_prefix);
                             $wpdb->query($sql);
                         }
                         fclose($handle);
                    }
                }
            }
        }

        /**
         * Scans folder for files.
         *
         * @param string $path base path to folder where the install folder is located with trailing slash
         * @return array list of files and folders
         */
        function scan_folder($path) {
            $files = array();
            if (function_exists(scandir)) {
                $f = scandir($path);
                foreach ($f as $filename) {
                    if (substr($filename, 0, 1) != '.' && substr($filename, 0, 1) != '_' && is_file($path."/".$filename))
                        $files[] = $filename;
                }
            }
            else {
                $dh = opendir($path);
                while (false !== ($filename = readdir($dh))) {
                    if (substr($filename, 0, 1) != '.' && substr($filename, 0, 1) != '_' && is_file($path."/".$filename))
                        $files[] = $filename;
                }
            }
            return $files;
        }
    }
}

?>
