<?php

//##############################################################################
//
// main home page for the site 
// 
//##############################################################################
include "top.php";

// Begin output
print '<article>';
print '<h2><a href = "tables.php"> TABLES </a></h2><break>';
print '<h2><a href = "../erd.pdf">ER Diagram</a></h2><break>';
print '<h2><a href = "../schema.pdf">Schema</a></h2><break>'; 
print '</article>';
include "footer.php";
?>