<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include "top.php";

//now print out each record
    $columns = 3;
    $query = 'SELECT DISTINCT tblSections.fldDays, tblSections.fldStart, tblSections.fldStop '
            . 'FROM tblSections '
            . 'INNER JOIN tblTeachers '
            . 'ON tblSections.fnkTeacherNetId = tblTeachers.pmkNetId '
            . 'WHERE tblTeachers.fldLastName = "Snapp" '
            . 'AND tblTeachers.fldFirstName = "Robert Raymond" '
            . 'ORDER BY tblSections.fldStart ASC';
    //public function testquery($query, $values = "", $wheres = 0, $conditions = 0, $quotes = 0, $symbols = 0, $spacesAllowed = false, $semiColonAllowed = false)
    //$testquery = $thisDatabaseReader->select($query, "", 0, 0, 0, 0, false, false);
    $info2 = $thisDatabaseReader->select($query, "", 1, 2, 4, 0, false, false);

    print ' ' . count($info2) . ' records';
    print '<table>';

    print '<tr><th>Days</th><th>Start Time</th><th>End Time</th></tr>';
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
    ?><?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

