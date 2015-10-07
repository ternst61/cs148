<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include "top.php";

//now print out each record
    $columns = 4;
    $query =  'SELECT fldFirstName, fldLastName, COUNT(fnkSectionId) AS NumberOfClasses, SUM(fldGrade) / COUNT(fnkSectionId) AS GPA '
            . 'FROM tblStudents JOIN tblEnrolls ON pmkStudentId = fnkStudentId '
            . 'WHERE fldState = "VT" GROUP BY fldFirstName, fldLastName '
            . 'HAVING GPA > (SELECT SUM(fldGrade) / COUNT(fnkSectionId) FROM tblEnrolls '
            . 'JOIN tblStudents ON fnkStudentId = pmkStudentId WHERE fldState = "VT")'
            . ' ORDER BY GPA DESC, fldLastName, fldFirstName';
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
    $info2 = $thisDatabaseReader->select($query, "", 2, 1, 4, 1, false, false);

    print ' ' . count($info2) . ' records';
    print '<table>';
    
    print '<tr><th>Last Name</th><th>First Name</th><th>Number of Classes</th><th>GPA</th></tr>';

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
