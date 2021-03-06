<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include "top.php";

//now print out each record
    $columns = 3;
    $query = "SELECT tblTeachers.fldFirstName, tblTeachers.fldLastName,  count(tblStudents.fldFirstName) as total
                FROM tblSections
                JOIN tblEnrolls on tblSections.fldCRN  = tblEnrolls.`fnkSectionId`
                JOIN tblStudents on pmkStudentId = fnkStudentId
                JOIN tblTeachers on tblSections.fnkTeacherNetId=pmkNetId
                WHERE fldType != 'LAB'
                group by fnkTeacherNetId
                ORDER BY total desc";
    //public function testquery($query, $values = "", $wheres = 0, $conditions = 0, $quotes = 0, $symbols = 0, $spacesAllowed = false, $semiColonAllowed = false)
    // 
    // $query should be in the form:
    //       SELECT fieldNames FROM table WHERE field = ?
    //
    // $wheres is the total number of WHERE statements in the query. 
    // 
    // $conditions is how many AND, &&, OR, ||, NOT, !, XOR are in the $query 
    //
    // $quotes is how many quotes your query string has
    // 
    // $symbols is for < and > in your conditional expression 
    // 
    // all of the above can be inside the wuery any place.
    //
    // function returns "" if it is not correct
   // $testquery = $thisDatabaseReader->select($query, "", 0, 0, 0, 0, false, false);
    $info2 = $thisDatabaseReader->select($query, "", 1, 2, 2, 0, false, false);

    print ' ' . count($info2) . ' records';
    print '<table>';
    
    print '<tr><th>First Name</th><th>Last Name</th><th>total</th></tr>';

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
