<?php

include "top.php";

/*$query = 'SELECT * 
          FROM tblPeople, tblRelationships, tblRelationshipType, tblRoles
          WHERE  tblPeople.pmkPersonId = tblRelationships.fnkPersonOneId
  AND tblRoles.pmkRoleId = tblPeople.fnkPersonOneRoleId
  AND tblRelationshipType.pmkRelationTypeId = tblRelationships.fnkRelationTypeId
  AND tblPeople.pmkPersonId = ?';

    //$testquery = $thisDatabaseReader->select($query, "", 0, 0, 0, 0, false, false);
    $info2 = $thisDatabaseReader->select($query, $data, 1, 0, 0, 0, false, false);
    
 */

$children = true;
$nextChild = 2;

        $queryFirst = 'SELECT * 
           FROM tblPeople, tblRelationships, tblRelationshipType, tblRoles
          WHERE tblPeople.pmkPersonId = tblRelationships.fnkPersonOneId
            AND tblRoles.pmkRoleId = tblRelationships.fnkPersonOneRoleId
            AND tblRelationshipType.pmkRelationTypeId = tblRelationships.fnkRelationTypeId
            AND tblPeople.pmkPersonId = 2
            
            Group by tblPeople.pmkPersonId';
        
        
        //$testquery = $thisDatabaseReader->testquery($query2, "", 1, 0, 0, 0, false, false);
        $firstDetails = $thisDatabaseReader->select($queryFirst, "", 1, 3, 0, 0, false, false);
        //print "<pre>wifedetails\n";
        //print_r($wifeDetails);

printPerson($firstDetails, "first");

while ($children) {
    
	$familyMembers = getFamily($nextChild, $thisDatabaseReader);
        //print "<pre>";
        //print_r($familyMembers);
        $wife = $familyMembers[0];
        $child = $familyMembers[1];

	# Print Person
	if ($wife) {
		printPerson($wife, "s");
        }
        if ($child) {
		printPerson($child, "d");
		$nextChild = $child[0][12];
                //$children = false;
	} else {
                print_r($child);
                $children = false;
        }
            

}

function printPerson($persona, $pos)
{
    $person = $persona[0];
    //print "<pre>person\n";
    //print_r($person);
	print "<div class=\"person\"" . $pos . ">";
	//Name f m l
	print "<h2 class=\"name\">" . $person[0] . " " . $person[1] . " " . $person[2] . "</h2>";
	//Birthdate - deathdate
	print "<p class=\"basic\">" . ($person[4] == "0000-00-00" ? "Unknown" : $person[4]) . " to " . ($person[8] == "0000-00-00" ? "Unknown" : $person[8]);
        
        //Birthplace
        print "<p class=\"basic\"> Born: " . ($person[7] ? $person[5] . ", " . $person[6] . ", " . $person[7] : "Unknown") . "</p>";
        //Deathplace
        print "<p class=\"basic\"> Died: " . ($person[11] ? $person[9] . ", " . $person[10] . ", " . $person[11] : "Unknown") . "</p>";
        

	print '</div>'; 
}

 function getFamily($id, $thisDatabaseReader)
{
	$wife = "";
	$child = "";
	$query = 'SELECT fnkPersonTwoId, fnkRelationTypeId, fnkPersonTwoRoleId
			    FROM tblPeople, tblRelationships, tblRelationshipType
			   WHERE tblPeople.pmkPersonId = tblRelationships.fnkPersonOneId
			     AND tblRelationshipType.pmkRelationTypeId = tblRelationships.fnkRelationTypeId
			     AND tblPeople.pmkPersonId = ?
		        GROUP BY tblRelationships.fnkPersonTwoId';
        $data[] = $id;
        
        
	$relations = $thisDatabaseReader->select($query, $data, 1, 2, 0, 0, false, false);
        //print "<pre>relations\n";
        //print_r($relations);
        
	foreach ($relations as $relation) {
		if ($relation[2] == 8) {
			$wife = $relation[0];
		} elseif ($relation[2] == 14) {
			$child = $relation[0];
		}
	}
        //wife query
        $query2 = 'SELECT * 
           FROM tblPeople, tblRelationships, tblRelationshipType, tblRoles
          WHERE tblPeople.pmkPersonId = tblRelationships.fnkPersonTwoId
            AND tblRoles.pmkRoleId = tblRelationships.fnkPersonTwoRoleId
            AND tblRelationshipType.pmkRelationTypeId = tblRelationships.fnkRelationTypeId
            AND tblPeople.pmkPersonId = ?
            
            Group by tblPeople.pmkPersonId';
        $data1[] = $wife;
        //$testquery = $thisDatabaseReader->testquery($query2, "", 1, 0, 0, 0, false, false);
        $wifeDetails = $thisDatabaseReader->select($query2, $data1, 1, 3, 0, 0, false, false);
        //print "<pre>wifedetails\n";
        //print_r($wifeDetails);
        
        
        
        $query3 = 'SELECT * 
           FROM tblPeople, tblRelationships, tblRelationshipType, tblRoles
          WHERE tblPeople.pmkPersonId = tblRelationships.fnkPersonOneId
            AND tblRoles.pmkRoleId = tblRelationships.fnkPersonOneRoleId
            AND tblRelationshipType.pmkRelationTypeId = tblRelationships.fnkRelationTypeId
            AND tblPeople.pmkPersonId = ?
            
            Group by tblPeople.pmkPersonId';
        $data2[] = $child;
  
        
        $childDetails = $thisDatabaseReader->select($query3, $data2, 1, 3, 0, 0, false, false);
	//print "childDetails\n";
        //print_r($childDetails);
        //print "both\n";
        //print_r(array($wifeDetails, $childDetails));
        return array($wifeDetails, $childDetails);
}

?>