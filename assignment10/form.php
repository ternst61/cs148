<?php
include ("top.php");
?>

<body>
    <h2><a href = "form2.php"> Add your Classes! </a></h2>

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

    $studentNetId = "";
    $studentEmail = "";
    $advisorNetId = "";
    $catalogYear = "";  
    $major = "";
    $minor = "";
    
    
//
//
//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1d form error flags
//
//
//

    $studentNetIdError = false;
    $emailERROR = false;
    $advisorNetIdError = false;
    $catalogYearError = false;
    $majorError = false;
    $minorError = false;

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


        $studentNetId = htmlentities($_POST["txtStudentNetId"], ENT_QUOTES, "UTF-8");
        $dataRecord[] = $studentNetId;

        $studentEmail = filter_var($_POST["txtStudentEmail"], FILTER_SANITIZE_EMAIL);
        $dataRecord[] = $studentEmail;
        
        $advisorNetId = htmlentities($_POST["txtAdvisorNetId"], ENT_QUOTES, "UTF-8");
        $dataRecord[] = $advisorNetId;
        
        $catalogYear = htmlentities($_POST["listCatalogYear"], ENT_QUOTES, "UTF-8");
        $dataRecord[] = $catalogYear;
        
        $major = htmlentities($_POST["listMajor"], ENT_QUOTES, "UTF-8");
        $dataRecord[] = $major;
        
        $minor = htmlentities($_POST["listMinor"], ENT_QUOTES, "UTF-8");
        $dataRecord[] = $minor;

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
        } elseif (!verifyAlphaNum($advisorNetId)) {
            $errorMsg[] = "Their net ID appears to have extra character.";
            $advisorNetIdError = true;
        }
        
         if ($catalogYear == "select") {
            $errorMsg[] = "Please choose the catalog year";
            $catalogYearError = true;
        }
        
         if ($major == "select") {
            $errorMsg[] = "Please choose your major";
            $majorError = true;
        }

         if ($minor == "select") {
            $errorMsg[] = "Please choose your minor";
            $minorError = true;
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
                                your new plan.</legend>
                        <fieldset class = "contact">
                            <fieldset class="contact">
                                <legend>General Information</legend>

                                <label for="txtStudentNetId" class="required">Student Net ID
                                    <input type="text" id="txtStudentNetId" name="txtStudentNetId"
                                           value="<?php print $studentNetId; ?>"
                                           tabindex="100" maxlength="45" placeholder="Enter your net ID"
                                           <?php if ($studentNetIdErrorERROR) print 'class="mistake"'; ?>
                                           onfocus="this.select()"
                                           autofocus>
                                </label>
                                
                                 <label for="txtStudentEmail" class="required">Student Email
                                    <input type="text" id="txtStudentEmail" name="txtStudentEmail"
                                           tabindex="110" maxlength="45" placeholder="example: ternst@uvm.edu"
                                           <?php if ($emailERROR) print 'class="mistake"'; ?>
                                           onfocus="this.select()" >
                                </label>

                                <label for="txtAdvisorNetId" class="required">Advisor Net ID
                                    <input type="text" id="txtAdvisorNetId" name="txtAdvisorNetId"
                                           value="<?php print $advisorNetId; ?>"
                                           tabindex="120" maxlength="45" placeholder="Enter your advisors net ID"
                                           <?php if ($advisorNetIdError) print 'class="mistake"'; ?>
                                           onfocus="this.select()"
                                           autofocus>
                                </label>                               
                            </fieldset>
                            
                            <fieldset  class="listbox">	
                                
                                <label for="listCatalogYear">Catalog Year</label>
                                <select id="listCatalogYear" 
                                        name="listCatalogYear" 
                                        tabindex="520" 
                                        <?php if ($catalogYearError) print 'class="mistake"'; ?> >

                                    <option <?php if ($catalogYear == "select") print " selected "; ?>
                                    <?php if ($catalogYearError) print 'class="mistake"'; ?>
                                        value="select" 
                                        >--- Select ---</option>
                                    <option <?php if ($catalogYear == "201314") print " selected "; ?>
                                        value="201314" 
                                        >2013-2014</option>


                                    <option <?php if ($catalogYear == "201415") print " selected "; ?>
                                        value="201415" 
                                        >2014-2015</option>


                                    <option <?php if ($catalogYear == "201516") print " selected "; ?>
                                        value="201516" 
                                        >2015-2016</option>
                                </select>
                                
                                <label for="listMajor">Major</label>
                                <select id="listMajor" 
                                        name="listMajor" 
                                        tabindex="520" 
                                        <?php if ($majorError) print 'class="mistake"'; ?> >

                                    <option <?php if ($major == "select") print " selected "; ?>
                                    <?php if ($majorError) print 'class="mistake"'; ?>
                                        value="select" 
                                        >--- Select ---</option>
                                    <option <?php if ($major == "BSCS") print " selected "; ?>
                                        value="BSCS" 
                                        >BS Computer Science</option>


                                    <option <?php if ($major == "BACS") print " selected "; ?>
                                        value="BACS" 
                                        >BA Computer Science</option>


                                    <option <?php if ($major == "BSCSIS") print " selected "; ?>
                                        value="BSCSIS" 
                                        >BS Computer Science and Information Systems</option>
                                </select>
                                
                                <label for="listMajor">Minor</label>
                                 <select id="listMinor" 
                                        name="listMinor" 
                                        tabindex="520" 
                                        <?php if ($minorError) print 'class="mistake"'; ?> >

                                    <option <?php if ($minor == "select") print " selected "; ?>
                                    <?php if ($minorError) print 'class="mistake"'; ?>
                                        value="select" 
                                        >--- Select ---</option>
                                    <option <?php if ($minor == "Math") print " selected "; ?>
                                        value="Math" 
                                        >Mathematics</option>


                                    <option <?php if ($minor == "History") print " selected "; ?>
                                        value="History" 
                                        >History</option>


                                    <option <?php if ($minor == "noMinor") print " selected "; ?>
                                        value="noMinor" 
                                        >No Minor</option>
                                </select>
                                
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
            Be sure to add your specific classes by hitting "Add your Classes" !! 
        </p>
    </footer>
</body>
</html>