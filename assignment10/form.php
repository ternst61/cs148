<?php
include ("top.php");
?>

<body>

    <?php
//    include ("header.php");
//    include ("nav.php");

//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1 Initialize variables
//
// SECTION: 1a.
// variables for the classroom purposes to help find errors.
    $debug = false;

    if (isset($_GET["debug"])) { // ONLY do this in a classroom environment
        $debug = true;
    }

    if ($debug)
        print "<p>DEBUG MODE IS ON</p>";

//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1b Security
//
// 
    $yourURL = $domain . $phpSelf;


//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1c form variables
// Initialize variables one for each form element
// in the order they appear on the form
    
    $query = "SELECT fldFirstName, fldMiddleName, fldLastName FROM tblPeople WHERE fldGender = 'M'";
    
    $fathers = $thisDatabaseReader->select($query, "",1,0,2,0,false,false);
    
    $testquery = $thisDatabaseReader->testquery($query, "",1,0,2,0,false,false);
    
    

    $fldFirstName = "";
    $fldMiddleName = NULL;
    $fldLastName = "";
    $fldGender = "male";        //ADD GENDER CHECKBOX
    $fldFather = "";            //ADD FATHER DROP DOWN 
    $fldDateOfBirth = NULL;  
    $fldCityOfBirth = NULL;
    $fldStateOfBirth = NULL;
    $fldCountryOfBirth = NULL;
    $fldDateOfDeath = NULL;
    $fldCityOfDeath = NULL;
    $fldStateOfDeath = NULL;
    $fldCountryOfDeath = NULL;
    $userEmail = "";
    
    
//
//
//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1d form error flags
//
//
//
    $fldFirstNameError = false;
    $fldMiddleNameError = false;
    $fldLastNameError = false;
    $fldDateOfBirthError = false;  
    $fldCityOfBirthError = false;
    $fldStateOfBirthError = false;
    $fldCountryOfBirthError = false;
    $fldDateOfDeathError = false;
    $fldCityOfDeathError = false;
    $fldStateOfDeathError = false;
    $fldCountryOfDeathError = false;


//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1e misc variables
//
// 
    $errorMsg = array();

// array used to hold form values that will be written to a CSV file

    $dataRecord = array();


    $mailed = false;

//have we mailed the information to the user?
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//
// SECTION: 2 Process for when the form is submitted
//
    if (isset($_POST["btnSubmit"])) {

        //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
        //
     // SECTION: 2a Security
        // 
        if (!securityCheck1(true)) {
            $msg = "<p>Sorry you cannot access this page. ";
            $msg.= "Security breach detected and reported</p>";
            die($msg);
        }

        //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
        //
    // SECTION: 2b Sanitize (clean) data 
        // remove any potential JavaScript or html code from users input on the
        // form. Note it is best to follow the same order as declared in section 1c.


        $fldFirstName = htmlentities($_POST["txtFirstName"], ENT_QUOTES, "UTF-8");
        $dataRecord[] = $fldFirstName;

        $fldMiddleName = htmlentities($_POST["txtMiddleName"], ENT_QUOTES, "UTF-8");
        $dataRecord[] = $fldMiddleName;
        
        $fldLastName = htmlentities($_POST["txtLastName"], ENT_QUOTES, "UTF-8");
        $dataRecord[] = $fldLastName;
        
        $fldFather = htmlentities($_POST["listFather"], ENT_QUOTES, "UTF-8");
        $dataRecord[] = $fldFather;
        
        $fldGender = htmlentities($_POST["radGender"], ENT_QUOTES, "UTF-8");
        $dataRecord[] = $fldGender;
        
        $fldDateOfBirth = htmlentities($_POST["txtDOB"], ENT_QUOTES, "UTF-8");
        $dataRecord[] = $fldDateOfBirth;
        
        $fldCityOfBirth = htmlentities($_POST["txtCityOB"], ENT_QUOTES, "UTF-8");
        $dataRecord[] = $fldCityOfBirth;
        
        $fldStateOfBirth = htmlentities($_POST["txtStateOB"], ENT_QUOTES, "UTF-8");
        $dataRecord[] = $fldStateOfBirth;
        
        $fldCountryOfBirth = htmlentities($_POST["txtCountryOB"], ENT_QUOTES, "UTF-8");
        $dataRecord[] = $fldCountryOfBirth;
                
        $fldDateOfDeath = htmlentities($_POST["txtDOD"], ENT_QUOTES, "UTF-8");
        $dataRecord[] = $fldDateOfDeath;
        
        $fldCityOfDeath = htmlentities($_POST["txtCityOD"], ENT_QUOTES, "UTF-8");
        $dataRecord[] = $fldCityOfDeath;
        
        $fldStateOfDeath = htmlentities($_POST["txtStateOD"], ENT_QUOTES, "UTF-8");
        $dataRecord[] = $fldStateOfDeath;
        
        $fldCountryOfDeath = htmlentities($_POST["txtCountryOD"], ENT_QUOTES, "UTF-8");
        $dataRecord[] = $fldCountryOfDeath;
        
        

        //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
        //
    // SECTION: 2c Validation
        //
    // Validation section. Check each value for possible errors, empty or
        // not what we expect. You will need an IF block for each element you will
        // check (see above section 1c and 1d). The if blocks should also be in the
        // order that the elements appear on your form so that the error messages
        // will be in the order they appear. errorMsg will be displayed on the form
        // see section 3b. The error flag ($emailERROR) will be used in section 3c.





        if ($fldFirstName == "") {
            $errorMsg[] = "Please enter the first name";
            $fldFirstNameError = true;
        } elseif (!verifyAlphaNum($fldFirstName)) {
            $errorMsg[] = "The first name appears to have extra character.";
            $fldFirstNameError = true; 
        }
        

        if ($fldMiddleName and !verifyAlphaNum($fldMiddleName)) {
            $errorMsg[] = "The middle name appears to have extra character.";
            $fldMiddleNameError = true; 
        }
        
        if ($fldLastName == "") {
            $errorMsg[] = "Please enter the last name";
            $fldLastNameError = true;
        } elseif (!verifyAlphaNum($fldLastName)) {
            $errorMsg[] = "The last name appears to have extra character.";
            $fldLastNameError = true; 
        }
        
        //if ($fldDateOfBirth == "") {
        //    $errorMsg[] = "Please enter the DOB in correct format: yyyy-mm-dd";
        //    $fldDateOfBirthError = true;
        //} else
        
        if ($fldDateOfBirth and !verifyDate($fldDateOfBirth)) {
            $errorMsg[] = "Please enter the DOB in correct format: yyyy-mm-dd";
            $fldDateOfBirthError = true; 
        }
        
        /*if ($fldCityOfBirth == "") {
            $errorMsg[] = "Please enter the city of birth";
            $fldCityOfBirthError = true;
        } else*/
        
        if ($fldCityOfBirth and !verifyAlphaNum($fldCityOfBirth)) {
            $errorMsg[] = "The city appears to have extra character.";
            $fldCityOfBirthError = true; 
        }

        /*if ($fldStateOfBirth == "") {
            $errorMsg[] = "Please enter the state of birth";
            $fldLastNameError = true;
        } else*/
            
        if ($fldStateOfBirth and !verifyAlphaNum($fldStateOfBirth)) {
            $errorMsg[] = "The state appears to have extra character.";
            $fldStateOfBirthError = true; 
        }
        
        if ($fldCountryOfBirth and !verifyAlphaNum($fldCountryOfBirth)) {
            $errorMsg[] = "The country appears to have extra character.";
            $fldCountryOfBirthError = true; 
        }

        if ($fldDateOfDeath and !verifyDate($fldDateOfDeath)) {
            $errorMsg[] = "Please enter the DOD in correct format: yyyy-mm-dd";
            $fldDateOfDeathError = true; 
        }
        
        if ($fldCityOfDeath and !verifyAlphaNum($fldCityOfDeath)) {
            $errorMsg[] = "The city appears to have extra character.";
            $fldCityOfDeathError = true; 
        }
        
        if ($fldStateOfDeath and !verifyAlphaNum($fldStateOfDeath)) {
            $errorMsg[] = "The state appears to have extra character.";
            $fldStateOfDeathError = true; 
        }
        
        if ($fldCountryOfDeath and !verifyAlphaNum($fldCountryOfDeath)) {
            $errorMsg[] = "The country appears to have extra character.";
            $fldCountryOfDeathError = true; 
        }
        
        //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
        //
    // SECTION: 2d Process Form - Passed Validation
        //
    // Process for when the form passes validation (the errorMsg array is empty)
        //
    if (!$errorMsg) {
            if ($debug)
                print "<p>Form is valid</p>";

            //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
            //
        // SECTION: 2e Save Data
            //
        // inserts into the query
            /*
             *   currenty coming from form:
             * 
             *   everything in tblPeople
             * 
             *   who the father/husband is
             * 
             */
            
             
            
            $query1 = 'INSERT INTO `tblPeople`(`fldFirstName`, `fldMiddleName`, `fldLastName`, `fldGender`, `fldDateOfBirth`, `fldCityOfBirth`, `fldStateOfBirth`, `fldCountryOfBirth`, `fldDateOfDeath`, `fldCityOfDeath`, `fldStateOfDeath`, `fldCountryOfDeath`, `pmkPersonId`) '
                    . 'VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)';
            
            $query2 = 'INSERT INTO `tblRelationshipType`(`fldRelationshipType`) VALUES (?)';
            
            $query3 = 'INSERT INTO `tblRoles`(`fldRole`) VALUES (?)';
            
            $query4 = 'INSERT INTO `tblRelationships`(`fnkFamilyId`, `fnkPersonOneId`, `fnkPersonTwoId`, `fnkRelationTypeId`, `fnkPersonOneRoleId`, `fnkPersonTwoRoleId`) VALUES (?,?,?,?,?,?)';

            $info1 = $thisDatabaseWriter->insert($query1, "", 0, 0, 0, 0, false, false);
            
            $info2 = $thisDatabaseWriter->insert($query2, "", 0, 0, 0, 0, false, false);
            
            $info3 = $thisDatabaseWriter->insert($query3, "", 0, 0, 0, 0, false, false);
            
            $info4 = $thisDatabaseWriter->insert($query4, "", 0, 0, 0, 0, false, false);
            
            

            //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
            //
        // SECTION: 2f Create message
            //
        // build a message to display on the screen in section 3a and to mail
            // to the person filling out the form (section 2g).

            $message .= '<h2>You have successfully entered another member of the family</h2>'
                    ;

            foreach ($_POST as $key => $value) {

                $message .= "<p>";

                $camelCase = preg_split('/(?=[A-Z])/', substr($key, 3));

                foreach ($camelCase as $one) {
                    $message .= $one . " ";
                }
                $message .= " = " . htmlentities($value, ENT_QUOTES, "UTF-8") . "</p>";
            }


            //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
            //
        // SECTION: 2g Mail to user
            //
        // Process for mailing a message which contains the forms data
            // the message was built in section 2f.
            $to = $userEmail; // the person who filled out the form
            $cc = "";
            $bcc = "";
            $from = "support <support@ernstgenealogy.com>";

            // subject of mail should make sense to your form
            $todaysDate = strftime("%x");
            $subject = "Ernst Family Genealogy" . $todaysDate;

            $mailed = sendMail($to, $cc, $bcc, $from, $subject, $message);
        } // end form is valid
    } // ends if form was submitted. 
//
//#############################################################################
//
// SECTION 3 Display Form
//
    ?>

    <article id="main">

        <?php
//####################################
//
// SECTION 3a.
//
// 
// 
// 
// If its the first time coming to the form or there are errors we are going
// to display the form.
        if (isset($_POST["btnSubmit"]) AND empty($errorMsg)) { // closing of if marked with: end body submit
            print '<div id = "processed">';
            print "<h1>The family member has ";

            if (!$mailed) {
                print "not ";
            }

            print "been entered</h1>";



            print "<p>A copy of this message has ";
            if (!$mailed) {
                print "not ";
            }
            print "been sent</p>";
            print "<p>To: " . $userEmail . "</p>";
            print "<p>Mail Message:</p>";

            print $message;
            print '</div>';
        } else {


            //####################################
            //
        // SECTION 3b Error Messages
            //
        // display any error messages before we print out the form

            if ($errorMsg) {
                print '<div id="errors">';
                print "<ol>\n";
                foreach ($errorMsg as $err) {
                    print "<li>" . $err . "</li>\n";
                }
                print "</ol>\n";
                print '</div>';
            }


            //####################################
            //
        // SECTION 3c html Form
            //
       /* Display the HTML form. note that the action is to this same page. $phpSelf
              is defined in top.php
              NOTE the line:

              value="<?php print $email; ?>

              this makes the form sticky by displaying either the initial default value (line 35)
              or the value they typed in (line 84)

              NOTE this line:

              <?php if($emailERROR) print 'class="mistake"'; ?>

              this prints out a css class so that we can highlight the background etc. to
              make it stand out that a mistake happened here.
             */
            ?>

            <form action="<?php print $phpSelf; ?>"
                  method="post"
                  id="frmRegister"
                  style = "padding-top: 2em;">

                <fieldset class="wrapper">

                    <fieldset class="wrapper legend">
                        <legend>Please add information.</legend>
                        <fieldset class = "contact">
                            <fieldset class="contact">
                                <legend>General Information</legend>

                                <label for="txtFirstName" class="required">First Name
                                    <input type="text" id="txtFirstName" name="txtFirstName"
                                           value="<?php print $fldFirstName; ?>"
                                           tabindex="100" maxlength="100" placeholder=""
                                           <?php if ($fldFirstNameError) print 'class="mistake"'; ?>
                                           onfocus="this.select()"
                                           autofocus>
                                </label>
                                
                                <label for="txtMiddleName" >Middle Name
                                    <input type="text" id="txtMiddleName" name="txtMiddleName"
                                           value="<?php print $fldMiddleName; ?>"
                                           tabindex="110" maxlength="100" placeholder=""
                                           <?php if ($fldMiddleNameError) print 'class="mistake"'; ?>
                                           onfocus="this.select()" >
                                </label>

                                <label for="txtLastName" class="required">Last Name
                                    <input type="text" id="txtLastName" name="txtLastName"
                                           value="<?php print $fldLastName; ?>"
                                           tabindex="120" maxlength="50" placeholder=""
                                           <?php if ($fldLastNameError) print 'class="mistake"'; ?>
                                           onfocus="this.select()"
                                           autofocus>
                                </label>   
                                
                                <fieldset class="radio">
                                
                                <label><input type="radio" 
                                              id="radGenderMale" 
                                              name="radGender" 
                                              value="Male"
                                              <?php if ($fldGender == "Male") print 'checked' ?>
                                              tabindex="121">Male</label>
                                <label><input type="radio" 
                                              id="radGenderFemale" 
                                              name="radGender" 
                                              value="Female"
                                              <?php if ($fldGender == "Female") print 'checked' ?>
                                              tabindex="122">Female</label>

                            </fieldset>
                                
                                <fieldset  class="listbox">	
                                    <label for ="listFather" > Father or Husband </label>
                                <select id="listFather" 
                                        name="listFather" >
                                         
                                    <?php
                                    //print_r ($fathers);
                                    foreach($fathers as $father){
                                        
                                        print '<option';
                                        //if ($fldFather == $father[0] . ' ' . $father[1] . ' ' . $father[2]) print ' selected';
                                        //print 'value="' . $father[0] . ' ' . $father[1] . ' ' . $father[2];
                                        print '>';
                                        print $father[0] . ' ' . $father[1] . ' ' . $father[2] . '</option>';
                                    }
 
                                     ?>        
                                </select>
                                </fieldset>
                                <label for="txtDOB">Date of Birth
                                    <input type="date" id="txtDOB" name="txtDOB"
                                           value="<?php print $fldDateOfBirth; ?>"
                                           tabindex="130" maxlength="50" placeholder="yyyy-mm-dd"
                                           <?php if ($fldDateOfBirthError) print 'class="mistake"'; ?>
                                           onfocus="this.select()"
                                           autofocus>
                                </label>  
                                
                                <label for="txtCityOB">City Of Birth
                                    <input type="text" id="txtCityOB" name="txtCityOB"
                                           value="<?php print $fldCityOfBirth; ?>"
                                           tabindex="140" maxlength="50" placeholder=""
                                           <?php if ($fldCityOfBirthError) print 'class="mistake"'; ?>
                                           onfocus="this.select()"
                                           autofocus>
                                </label>  
                                
                                <label for="txtStateOB">State Of Birth
                                    <input type="text" id="txtStateOB" name="txtStateOB"
                                           value="<?php print $fldStateOfBirth; ?>"
                                           tabindex="150" maxlength="50" placeholder=""
                                           <?php if ($fldStateOfBirth) print 'class="mistake"'; ?>
                                           onfocus="this.select()"
                                           autofocus>
                                </label>  
                                
                                <label for="txtCountryOB">Country Of Birth
                                    <input type="text" id="txtCountryOB" name="txtCountryOB"
                                           value="<?php print $fldStateOfBirth; ?>"
                                           tabindex="160" maxlength="50" placeholder=""
                                           <?php if ($fldCountryOfBirthError) print 'class="mistake"'; ?>
                                           onfocus="this.select()"
                                           autofocus>
                                </label>  
                                
                                <label for="txtDOD">Date of Death
                                    <input type="date" id="txtDOD" name="txtDOD"
                                           value="<?php print $fldDateOfDeath; ?>"
                                           tabindex="170" maxlength="50" placeholder="yyyy-mm-dd"
                                           <?php if ($fldDateOfDeathError) print 'class="mistake"'; ?>
                                           onfocus="this.select()"
                                           autofocus>
                                </label>  
                                
                                <label for="txtCityOD">City Of Death
                                    <input type="text" id="txtCityOD" name="txtCityOD"
                                           value="<?php print $fldCityOfDeath; ?>"
                                           tabindex="180" maxlength="50" placeholder=""
                                           <?php if ($fldCityOfDeathError) print 'class="mistake"'; ?>
                                           onfocus="this.select()"
                                           autofocus>
                                </label>  
                                
                                <label for="txtStateOD">State Of Death
                                    <input type="text" id="txtStateOD" name="txtStateOD"
                                           value="<?php print $fldStateOfDeath; ?>"
                                           tabindex="190" maxlength="50" placeholder=""
                                           <?php if ($fldStateOfDeathError) print 'class="mistake"'; ?>
                                           onfocus="this.select()"
                                           autofocus>
                                </label>  
                                
                                <label for="txtCountryOD">Country Of Death
                                    <input type="text" id="txtCountryOD" name="txtCountryOD"
                                           value="<?php print $fldCountryOfDeath; ?>"
                                           tabindex="200" maxlength="50" placeholder=""
                                           <?php if ($fldCountryOfDeathError) print 'class="mistake"'; ?>
                                           onfocus="this.select()"
                                           autofocus>
                                </label>  
                            </fieldset>
                            
                                       

                        </fieldset> <!-- ends contact -->

                    </fieldset> <!-- ends wrapper Two -->

                    <fieldset class="buttons">
                        <legend></legend>
                        <input type="submit" id="btnSubmit" name="btnSubmit" value="Submit" tabindex="900" class="button">
                    </fieldset> <!-- ends buttons -->

                </fieldset> <!-- Ends Wrapper -->
            </form>

            <?php
        }
        ?>
    </article>
    
    <footer>
        <p>
        <!-- Be sure to add your specific classes by hitting "Add your Classes" !! -->
        </p>
    </footer>
</body>
</html>