<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include "top.php";

//now print out each record
    $columns = 8;
    $query = 'SELECT pmkStudentId, fldFirstName, fldLastName, fldStreetAddress, fldCity, fldState, fldZip, fldGender FROM tblStudents ORDER BY fldLastName ASC, fldFirstName ASC LIMIT 10 OFFSET 1000';
    //$testquery = $thisDatabaseReader->select($query, "", 0, 0, 0, 0, false, false);
    $info2 = $thisDatabaseReader->select($query, "", 0, 1, 0, 0, false, false);
    
    print ' ' . count($info2) . ' records';
    
   print '<table>';
   
   print '<tr><th>Student ID</th><th>First Name</th><th>Last Name</th><th>Street Address</th><th>City</th><th>State</th><th>Zip</th><th>Gender</th></tr>';

   
   $labels = array_filter(array_keys($info2[0]), 'is_string');
   
   print '<p><pre>';
   print_r($labels);
    
   
   
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