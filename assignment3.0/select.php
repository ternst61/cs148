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
            <li><a href="q01.php"><b>query01</b>:</a> SELECT DISTINCT tblCourses.fldCourseName, tblEnrolls.fldGrade FROM tblCourses INNER JOIN tblEnrolls ON tblCourses.pmkCourseId=tblEnrolls.fnkCourseId WHERE fldGrade = "100"</li>
            <li><a href="q02.php"><b>query02:</b></a> SELECT DISTINCT tblSections.fldDays, tblSections.fldStart, tblSections.fldStop FROM tblSections INNER JOIN tblTeachers ON tblSections.fnkTeacherNetId = tblTeachers.pmkNetId WHERE tblTeachers.fldLastName = "Snapp" AND tblTeachers.fldFirstName = "Robert Raymond ORDER BY tblSections.fldStart ASC'</li>
            <li><a href="q03.php"><b>query03:</b></a> SELECT DISTINCT tblSections.fldDays, tblCourses.fldCourseName, tblSections.fldStart, tblSections.fldStop FROM tblSections INNER JOIN tblTeachers ON tblSections.fnkTeacherNetId = tblTeachers.pmkNetId INNER JOIN tblCourses ON tblCourses.pmkCourseId = tblSections.fnkCourseId WHERE tblTeachers.fldLastName = "Horton" AND tblTeachers.fldFirstName = "Jackie Lynn" ORDER BY tblSections.fldStart ASC'</li>
            <li><a href="q04.php"><b>query04:</b></a> SELECT DISTINCT tblSections.fldCRN, tblStudents.fldLastName, tblStudents.fldFirstName FROM tblSections INNER JOIN tblEnrolls ON tblSections.fnkCourseId = tblEnrolls.fnkCourseId INNER JOIN tblStudents ON tblEnrolls.fnkStudentId = tblStudents.pmkStudentId WHERE tblSections.fldCRN = "91954" ORDER BY tblSections.fldCRN, tblStudents.fldLastName, tblStudents.fldFirstName</li>
            <li><a href="q05.php"><b>query05:</b></a> SELECT tblTeachers.fldFirstName, tblTeachers.fldLastName,  count(tblStudents.fldFirstName) as total FROM tblSections JOIN tblEnrolls on tblSections.fldCRN  = tblEnrolls.`fnkSectionId` JOIN tblStudents on pmkStudentId = fnkStudentId JOIN tblTeachers on tblSections.fnkTeacherNetId=pmkNetId WHERE fldType != 'LAB' group by fnkTeacherNetId ORDER BY total desc</li>
            <li><a href="q06.php"><b>query06:</b></a> SELECT fldFirstName, fldPhone, fldSalary FROM tblTeachers WHERE fldSalary < (SELECT AVG(fldSalary) FROM tblTeachers)ORDER BY fldSalary</li>
            <li><a href="q07.php"><b>query07:</b></a> SELECT fldFirstName, fldLastName, COUNT(fnkSectionId) AS NumberOfClasses, SUM(fldGrade) / COUNT(fnkSectionId) AS GPA FROM tblStudents JOIN tblEnrolls ON pmkStudentId = fnkStudentId WHERE fldState = "VT" GROUP BY fldFirstName, fldLastName HAVING GPA > (SELECT SUM(fldGrade) / COUNT(fnkSectionId) FROM tblEnrolls JOIN tblStudents ON fnkStudentId = pmkStudentId WHERE fldState = "VT") ORDER BY GPA DESC, fldLastName, fldFirstName</li>
            <li><a href="q08.php"><b>query08:</b></a> SELECT tblTeachers.fldFirstName, tblTeachers.fldLastName, COUNT(tblEnrolls.fnkStudentId) AS NumberOfStudents, tblTeachers.fldSalary, tblTeachers.fldSalary / COUNT(tblEnrolls.fnkStudentId) AS IBB FROM tblTeachers INNER JOIN tblSections ON tblSections.fnkTeacherNetId = tblTeachers.pmkNetId INNER JOIN tblEnrolls ON tblSections.fnkCourseId = tblEnrolls.fnkCourseId AND tblSections.fldCRN = tblEnrolls.fnkSectionId WHERE fldType <> "LAB" GROUP BY fldFirstName, fldLastName ORDER BY IBB </li>

        </ol>