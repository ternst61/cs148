<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include "top.php";

//now print out each record
    $columns = 11;
    $query = "SELECT DISTINCT tblStudents.fldFirstName, tblStudents.fldLastName, tblFourYearPlan.fldMajor, tblFourYearPlan.fldMinor,
                tblAdvisors.fldAdvisorFirstName, tblAdvisors.fldAdvisorLastName, tblSemesterPlan.fnkYear, tblSemesterPlan.fnkTerm, tblCourses.fldCourseName, tblCourses.fldDepartment, tblCourses.fldCourseNumber
                FROM tblCourses 
                INNER JOIN tblSemesterPlanCourses ON tblCourses.pmkCourseId = tblSemesterPlanCourses.fnkCourseId 
                INNER JOIN tblSemesterPlan ON tblSemesterPlanCourses.fnkTerm = tblSemesterPlan.fnkTerm AND tblSemesterPlanCourses.fnkYear = tblSemesterPlan.fnkYear 
                INNER JOIN tblFourYearPlan ON tblSemesterPlan.fnkPlanId = tblFourYearPlan.pmkPlanId
                INNER JOIN tblStudents ON tblFourYearPlan.fnkStudentNetId = tblStudents.pmkNetId
                INNER JOIN tblAdvisors ON tblFourYearPlan.fnkAdvisorNetId = tblAdvisors.pmkNetId
                ORDER BY tblSemesterPlanCourses.fldDisplayOrder";
    //$testquery = $thisDatabaseReader->select($query, "", 0, 0, 0, 0, false, false);
    $info2 = $thisDatabaseReader->select($query, "", 0, 2, 0, 0, false, false);
    
    print ' ' . count($info2) . ' records';
    
   print '<table>';
   
   //print '<tr><th>First Name</th><th>Last Name</th><th>Major</th><th>Minor</th><th>Advisor First Name</th><th>Advisor Last Name</th><th>Year</th><th>Term</th><th>Course Name</th><th>Department</th><th>Course Number</th></tr>';

   
   $headerFields = array_keys($info2[0]);
//     echo '<pre><p>';
//     print_r ($headerFields);
//     echo '</p></pre>';
    $headerArray = array_filter($headerFields, "is_string");
//     echo '<pre><p>';
//     print_r ($headerArray);
//     echo '</p></pre>';
//    //echo "<h2> Records: " . count($info2) . "</h2>";
//    print '<table>';
    //header block
    print '<tr class="tblHeaders">';
    foreach ($headerArray as $key) {
        $camelCase = preg_split('/(?=[A-Z])/', substr($key, 3));
        $message = "";
        foreach ($camelCase as $one) {
            $message .= $one . " ";
        }
        print '<th>' . $message . '</th>';
    }
    print '</tr>';

    $highlight = 0; // used to highlight alternate rows
    foreach ($info2 as $rec) {
        $highlight++;
        if ($highlight % 2 != 0) {
            $style = ' odd ';
        } else {
            $style = ' even ';
        }
        print '<tr class="' . $style . '">';
        for ($i = 0; $i < $columns; $i++) {
            print '<td>' . $rec[$i] . '</td>';
        }
        print '</tr>';
    }

    // all done
    print '</table>';
   // print '</aside>';
    
    include "footer.php";
    ?>