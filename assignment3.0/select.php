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

        <h2>Thomas H Ernst - CS 148 Assignment 3.0</h2>
        <ol>
            <li><a href="q01.php"><b>query1</b>:</a> SELECT DISTINCT tblCourses.fldCourseName, tblEnrolls.fldGrade FROM tblCourses INNER JOIN tblEnrolls ON tblCourses.pmkCourseId=tblEnrolls.fnkCourseId WHERE fldGrade = "100"</li>
            <li><a href="q02.php"><b>query2:</b></a> SELECT DISTINCT tblSections.fldDays, tblSections.fldStart, tblSections.fldStop FROM tblSections INNER JOIN tblTeachers ON tblSections.fnkTeacherNetId = tblTeachers.pmkNetId WHERE tblTeachers.fldLastName = "Snapp" AND tblTeachers.fldFirstName = "Robert Raymond ORDER BY tblSections.fldStart ASC'</li>
            <li><a href="q03.php"><b>query3:</b></a> SELECT DISTINCT tblSections.fldDays, tblCourses.fldCourseName, tblSections.fldStart, tblSections.fldStop FROM tblSections INNER JOIN tblTeachers ON tblSections.fnkTeacherNetId = tblTeachers.pmkNetId INNER JOIN tblCourses ON tblCourses.pmkCourseId = tblSections.fnkCourseId WHERE tblTeachers.fldLastName = "Horton" AND tblTeachers.fldFirstName = "Jackie Lynn" ORDER BY tblSections.fldStart ASC'</li>
            <li><a href="q04.php"><b>query4:</b></a> SELECT DISTINCT tblSections.fldCRN, tblStudents.fldLastName, tblStudents.fldFirstName FROM tblSections INNER JOIN tblEnrolls ON tblSections.fnkCourseId = tblEnrolls.fnkCourseId INNER JOIN tblStudents ON tblEnrolls.fnkStudentId = tblStudents.pmkStudentId WHERE tblSections.fldCRN = "91954" ORDER BY tblSections.fldCRN, tblStudents.fldLastName, tblStudents.fldFirstName</li>
            <li><a href="q05.php"><b>query5:</b></a> SELECT tblTeachers.fldFirstName, tblTeachers.fldLastName,  count(tblStudents.fldFirstName) as total FROM tblSections JOIN tblEnrolls on tblSections.fldCRN  = tblEnrolls.`fnkSectionId` JOIN tblStudents on pmkStudentId = fnkStudentId JOIN tblTeachers on tblSections.fnkTeacherNetId=pmkNetId WHERE fldType != 'LAB' group by fnkTeacherNetId ORDER BY total desc</li>
            <li><a href="q06.php"><b>query6:</b></a> SELECT fldFirstName, fldPhone, fldSalary FROM tblTeachers WHERE fldSalary < (SELECT AVG(fldSalary) FROM tblTeachers)ORDER BY fldSalary</li>
            
        </ol>