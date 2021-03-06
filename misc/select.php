<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<!DOCTYPE HTML>
<html lang="en">

    <head>
        <title>Tommy Ernst - CS 148 site map</title>
        <link href="style.css" type="text/css" rel="stylesheet" />
        <meta charset="utf-8">
        <meta name="author" content="Tommy Ernst">
        <meta name="description" content="CS148 - Database Design for the web">
    </head>

    <body>

        <h2>Thomas H Ernst - CS 148 Assignment 2.0</h2>
        <ol>
            <li><a href="q01.php">query1:</a> SELECT pmkNetId FROM tblTeachers</li>
            <li><a href="q02.php">query2:</a> SELECT fldDepartment FROM tblCourses WHERE fldCourseName LIKE "Introduction</li>
            <li><a href="q03.php">query3:</a> SELECT fnkCourseId FROM tblSections WHERE fldStart = "13:10" AND fldBuilding = "Kalkin</li>
            <li><a href="q04.php">query4:</a> SELECT * FROM tblSections WHERE fnkCourseId = "392" AND fldSection = "A"</li>
            <li><a href="q05.php">query5:</a> SELECT fldLastName, fldFirstName FROM tblTeachers WHERE pmkNetId LIKE "r%_" AND pmkNetId LIKE "%o"</li>
            <li><a href="q06.php">query6:</a> SELECT fldCourseName FROM tblCourses WHERE fldCourseName LIKE "%data%" AND fldDepartment NOT IN ("CS")</li>
            <li><a href="q07.php">query7:</a> SELECT COUNT(DISTINCT fldDepartment) FROM tblCourses</li>
            <li><a href="q08.php">query8:</a> SELECT DISTINCT fldBuilding, COUNT(fldSection) FROM tblSections GROUP BY fldBuilding</li>
            <li><a href="q09.php">query9:</a> SELECT DISTINCT fldBuilding, COUNT(DISTINCT fldNumStudents) FROM tblSections WHERE fldDays LIKE "%W%" GROUP BY fldBuilding ORDER BY count(DISTINCT fldNumStudents) DESC</li>
            <li><a href="q10.php">query10:</a> SELECT DISTINCT fldBuilding, COUNT(DISTINCT fldNumStudents) FROM tblSections WHERE fldDays LIKE "%F%" GROUP BY fldBuilding ORDER BY count(DISTINCT fldNumStudents) DESC</li>
        </ol>