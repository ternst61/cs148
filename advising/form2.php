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

    $semester = "";
    $year = "";
    $department1 = "";
    $department2 = "";  
    $department3 = "";
    $department4 = "";
    $department5 = "";
    $department6 = "";
    $course1 = "";
    $course2 = "";
    $course3 = "";
    $course4 = "";
    $course5 = "";
    $course6 = "";
    
    
//
//
//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1d form error flags
//
//
//

    $semesterError = false;
    $yearError = false;
    $department1Error = false;
    $department2Error = false;
    $department3Error = false;
    $department4Error = false;
    $department5Error = false;
    $department6Error = false;
    $course1Error = false;
    $course2Error = false;
    $course3Error = false;
    $course4Error = false;
    $course5Error = false;
    $course6Error = false;

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
        if (!securityCheck(true)) {
            $msg = "<p>Sorry you cannot access this page. ";
            $msg.= "Security breach detected and reported</p>";
            die($msg);
        }

        //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
        //
    // SECTION: 2b Sanitize (clean) data 
        // remove any potential JavaScript or html code from users input on the
        // form. Note it is best to follow the same order as declared in section 1c.

        /*
        $studentNetId = htmlentities($_POST["txtStudentNetId"], ENT_QUOTES, "UTF-8");
        $dataRecord[] = $studentNetId;

        $studentEmail = filter_var($_POST["txtStudentEmail"], FILTER_SANITIZE_EMAIL);
        $dataRecord[] = $studentEmail;
        
        $advisorNetId = htmlentities($_POST["txtadvisorNetId"], ENT_QUOTES, "UTF-8");
        $dataRecord[] = $advisorNetId;
        
        $catalogYear = htmlentities($_POST["listCatalogYear"], ENT_QUOTES, "UTF-8");
        $dataRecord[] = $catalogYear;
        
        $major = htmlentities($_POST["listMajor"], ENT_QUOTES, "UTF-8");
        $dataRecord[] = $major;
        
        $minor = htmlentities($_POST["listMinor"], ENT_QUOTES, "UTF-8");
        $dataRecord[] = $minor;
        
        */

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



/*

        if ($studentNetId == "") {
            $errorMsg[] = "Please enter your net ID";
            $studentNetIdError = true;
        } elseif (!verifyAlphaNum($studentNetId)) {
            $errorMsg[] = "Your net ID appears to have extra character.";
            $studentNetIdError = true;
        }
        
        if ($studentEmail == "") {
            $errorMsg[] = "Please enter your email address";
            $emailERROR = true;
        } elseif (!verifyEmail($studentEmail)) {
            $errorMsg[] = "Your email address appears to be incorrect.";
            $emailERROR = true;
        }
        
        if ($advisorNetId == "") {
            $errorMsg[] = "Please enter your advisor's net ID";
            $advisorNetIdError = true;
        } elseif (!verifyAlphaNum($studentNetId)) {
            $errorMsg[] = "Their net ID appears to have extra character.";
            $advisorNetIdError = true;
        }
        
         if ($major == "select") {
            $errorMsg[] = "Please choose your major";
            $majorError = true;
        }

         if ($minor == "select") {
            $errorMsg[] = "Please choose your minor";
            $minorError = true;
        }
 * 
 * 
 */

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
        // This block saves the data to a CSV file.

            $fileExt = ".sql";

            $myFileName = "lib/updatePlan";

            $filename = $myFileName . $fileExt;

            if ($debug)
                print "\n\n<p>filename is " . $filename;

            // now we just open the file for append
            $file = fopen($filename, 'a');

            // write the forms informations
            fputcsv($file, $dataRecord);

            // close the file
            fclose($file);

            //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
            //
        // SECTION: 2f Create message
            //
        // build a message to display on the screen in section 3a and to mail
            // to the person filling out the form (section 2g).

            $message .= '<h2>Congrats! You have updated your plan.</h2>'
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
            $to = $studentEmail; // the person who filled out the form
            $cc = "";
            $bcc = "";
            $from = "Advising <advising@uvm.edu>";

            // subject of mail should make sense to your form
            $todaysDate = strftime("%x");
            $subject = "Plan updated" . $todaysDate;

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
            print "<h1>Your plan has ";

            if (!$mailed) {
                print "not ";
            }

            print "been updated</h1>";



            print "<p>A copy of this message has ";
            if (!$mailed) {
                print "not ";
            }
            print "been sent</p>";
            print "<p>To: " . $studentEmail . "</p>";
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
                        <legend>Please enter the information regarding
                                your classes.</legend>
                        <fieldset class = "contact">
                            <fieldset class="contact">
                                <legend>Specific Information</legend>
                                                   
                                <fieldset  class="listSemester">	
                                <label for="listSemester">Semester</label>
                                <select id="listSemester" 
                                        name="listSemester" 
                                        tabindex="100" 
                                        <?php if ($semesterError) print 'class="mistake"'; ?> >

                                    <option <?php if ($semester == "select") print " selected "; ?>
                                    <?php if ($semesterError) print 'class="mistake"'; ?>
                                        value="select" 
                                        >--- Select ---</option>
                                    <option <?php if ($semester == "Fall") print " selected "; ?>
                                        value="Fall" 
                                        >Fall</option>


                                    <option <?php if ($semester == "Spring") print " selected "; ?>
                                        value="Spring" 
                                        >Spring</option>


                                    <option <?php if ($semester == "Summer") print " selected "; ?>
                                        value="Summer" 
                                        >Summer</option>
                                    
                                    <option <?php if ($semester == "Winter") print " selected "; ?>
                                        value="Winter" 
                                        >Winter</option>
                                </select>

                                                     
                            </fieldset>
                                
                                <fieldset  class="listYear">	
                                <label for="listYear">Year</label>
                                <select id="listYear" 
                                        name="listYear" 
                                        tabindex="110" 
                                        <?php if ($yearError) print 'class="mistake"'; ?> >

                                    <option <?php if ($year == "select") print " selected "; ?>
                                    <?php if ($yearError) print 'class="mistake"'; ?>
                                        value="select" 
                                        >--- Select ---</option>
                                    <option <?php if ($year == "2013") print " selected "; ?>
                                        value="2013" 
                                        >2013</option>


                                    <option <?php if ($year == "2014") print " selected "; ?>
                                        value="2014" 
                                        >2014</option>


                                    <option <?php if ($year == "2015") print " selected "; ?>
                                        value="2015" 
                                        >2015</option>
                                    
                                    <option <?php if ($year == "2016") print " selected "; ?>
                                        value="2016" 
                                        >2016</option>
                                </select>

                                                     
                            </fieldset>
                            
                            
                            <fieldset>	
                                <legend>Course 1</legend>
                              <label for="txtDepartment1" class="required">Department
                                    <input type="text" id="txtDepartment1" name="txtDepartment1"
                                           value="<?php print $department1; ?>"
                                           tabindex="200" maxlength="20" placeholder=""
                                           <?php if ($department1Error) print 'class="mistake"'; ?>
                                           onfocus="this.select()"
                                           autofocus>
                                </label>
                                
                                <label for="txtCourse1" class="required">Course
                                    <input type="text" id="txtCourse1" name="txtCourse1"
                                           value="<?php print $course1; ?>"
                                           tabindex="210" maxlength="5" placeholder=""
                                           <?php if ($course1Error) print 'class="mistake"'; ?>
                                           onfocus="this.select()"
                                           autofocus>
                                </label>
                                
                            </fieldset>  
                                
                            <fieldset>	
                                <legend>Course 2</legend>
                              <label for="txtDepartment2" class="required">Department
                                    <input type="text" id="txtDepartment2" name="txtDepartment2"
                                           value="<?php print $department2; ?>"
                                           tabindex="230" maxlength="20" placeholder=""
                                           <?php if ($department2Error) print 'class="mistake"'; ?>
                                           onfocus="this.select()"
                                           autofocus>
                                </label>
                                
                                <label for="txtCourse2" class="required">Course
                                    <input type="text" id="txtCourse2" name="txtCourse2"
                                           value="<?php print $course2; ?>"
                                           tabindex="240" maxlength="5" placeholder=""
                                           <?php if ($course2Error) print 'class="mistake"'; ?>
                                           onfocus="this.select()"
                                           autofocus>
                                </label>
                                
                            </fieldset> 
                                
                              <fieldset>	
                                <legend>Course 3</legend>
                              <label for="txtDepartment3" class="required">Department
                                    <input type="text" id="txtDepartment3" name="txtDepartment3"
                                           value="<?php print $department3; ?>"
                                           tabindex="250" maxlength="20" placeholder=""
                                           <?php if ($department3Error) print 'class="mistake"'; ?>
                                           onfocus="this.select()"
                                           autofocus>
                                </label>
                                
                                <label for="txtCourse3" class="required">Course
                                    <input type="text" id="txtCourse2" name="txtCourse3"
                                           value="<?php print $course3; ?>"
                                           tabindex="260" maxlength="5" placeholder=""
                                           <?php if ($course6Error) print 'class="mistake"'; ?>
                                           onfocus="this.select()"
                                           autofocus>
                                </label>
                                
                            </fieldset> 
                                
                                    <fieldset>	
                                <legend>Course 4</legend>
                              <label for="txtDepartment4" class="required">Department
                                    <input type="text" id="txtDepartment4" name="txtDepartment4"
                                           value="<?php print $department4; ?>"
                                           tabindex="270" maxlength="20" placeholder=""
                                           <?php if ($department4Error) print 'class="mistake"'; ?>
                                           onfocus="this.select()"
                                           autofocus>
                                </label>
                                
                                <label for="txtCourse4" class="required">Course
                                    <input type="text" id="txtCourse4" name="txtCourse4"
                                           value="<?php print $course4; ?>"
                                           tabindex="280" maxlength="5" placeholder=""
                                           <?php if ($course4Error) print 'class="mistake"'; ?>
                                           onfocus="this.select()"
                                           autofocus>
                                </label>
                                
                            </fieldset> 
                                
                                    <fieldset>	
                                <legend>Course 5</legend>
                              <label for="txtDepartment5" class="required">Department
                                    <input type="text" id="txtDepartment5" name="txtDepartment5"
                                           value="<?php print $department5; ?>"
                                           tabindex="290" maxlength="20" placeholder=""
                                           <?php if ($department5Error) print 'class="mistake"'; ?>
                                           onfocus="this.select()"
                                           autofocus>
                                </label>
                                
                                <label for="txtCourse5" class="required">Course
                                    <input type="text" id="txtCourse5" name="txtCourse5"
                                           value="<?php print $course5; ?>"
                                           tabindex="300" maxlength="5" placeholder=""
                                           <?php if ($course5Error) print 'class="mistake"'; ?>
                                           onfocus="this.select()"
                                           autofocus>
                                </label>
                                
                            </fieldset> 
                                
                                    <fieldset>	
                                <legend>Course 6 </legend>
                              <label for="txtDepartment6" class="required">Department
                                    <input type="text" id="txtDepartment6" name="txtDepartment6"
                                           value="<?php print $department6; ?>"
                                           tabindex="310" maxlength="40" placeholder="If no course, type 'no dept'"
                                           <?php if ($department6Error) print 'class="mistake"'; ?>
                                           onfocus="this.select()"
                                           autofocus>
                                </label>
                                
                                <label for="txtCourse6" class="required">Course
                                    <input type="text" id="txtCourse6" name="txtCourse6"
                                           value="<?php print $course6; ?>"
                                           tabindex="240" maxlength="5" placeholder="no course"
                                           <?php if ($course6Error) print 'class="mistake"'; ?>
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
            all set for this semester! <br> 
        </p>
    </footer>
</body>
</html>