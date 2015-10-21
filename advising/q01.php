<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include "top.php";

//now print out each record
    $columns = 2;
    $query = 'SELECT DISTINCT tblCourses.fldCourseName, tblEnrolls.fldGrade '
            . 'FROM tblCourses '
            . 'INNER JOIN tblEnrolls '
            . 'ON tblCourses.pmkCourseId=tblEnrolls.fnkCourseId '
            . 'WHERE fldGrade = "100" '
            . 'ORDER BY fldCourseName ASC';
    //$testquery = $thisDatabaseReader->select($query, "", 0, 0, 0, 0, false, false);
    $info2 = $thisDatabaseReader->select($query, "", 1, 1, 2, 0, false, false);
    
    print ' ' . count($info2) . ' records';
    
   print '<table>';
   
   print '<tr><th>Course Name</th><th>Grade</th></tr>';

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