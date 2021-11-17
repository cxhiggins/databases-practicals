<!DOCTYPE html>
<html lang="en">
<body> 
    <?php
        // Start session to share variables between pages
        session_start();

        // Retrieve studentid from other page
        $studentid = $_SESSION['studentid'];

        if (isset($studentid) && $studentid != "" && isset($_POST['course'])) {
            $course = explode(" - ", $_POST['course']);
            $dname = $course[0];
            $cno = $course[1];
            
            if (isset($dname) && isset($cno)) {
                // echo "Dname: " . $dname . ", cno: " . $cno . "\n";

                $dbconn = pg_connect("host=tr01")
                    or die('Could not connect: ' . pg_last_error());

                // Prepare a query for execution with $1 as a placeholder
                $result = pg_prepare($dbconn, "studentid_query", 'SELECT E.grade FROM enroll E WHERE E.sid=$1 AND E.cno=$2 and E.dname=$3')
                    or die('Query preparation failed: ' . pg_last_error());

                // Execute the prepared query with the value from the form as the actual argument 
                $result = pg_execute($dbconn, "studentid_query", array($studentid, $cno, $dname))
                    or die('Query execution failed: ' . pg_last_error() . ", dname: " . $dname . ", cno: " . $cno . ", student ID: " . $studentid);

                $nrows = pg_numrows($result);
                if($nrows != 0)
                {
                    print "<table border=2><tr><th>Student ID<th>Department Name<th>Course Number<th>Grade\n";
                    for($j=0;$j<$nrows;$j++)
                    {
                        $row = pg_fetch_array($result);
                        print "<tr><td>" . $studentid;
                        print "<td>" . $dname;
                        print "<td>" . $cno;
                        print "<td>" . $row["grade"];
                        print "\n";
                    }
                    print "</table>\n";
                }
                else    echo "<p>No Entry for " . $_POST['studentid'];
                pg_close($dbconn);

                session_reset();
            }
        }
    ?>
    </p>
</body>
</html>

