<!DOCTYPE html>
<html lang="en">
<body> 
    <?php
        // Start session to share variables between pages
        session_start();

        // Check that studentid is set
        if(isset($_POST['studentid']) && $_POST['studentid'] != "") {
            $_SESSION['studentid'] = $_POST['studentid'];

            $dbconn = pg_connect("host=tr01")
                or die('Could not connect: ' . pg_last_error());

            // Prepare a query for execution with $1 as a placeholder
            $result = pg_prepare($dbconn, "studentid_query", 'SELECT C.dname, C.cno FROM course C WHERE EXISTS (SELECT E.sid FROM enroll E WHERE E.cno=C.cno AND E.dname=C.dname AND E.sid=$1)')
                or die('Query preparation failed: ' . pg_last_error());

            // Execute the prepared query with the value from the form as the actual argument 
            $result = pg_execute($dbconn, "studentid_query", array($_POST['studentid']))
                or die('Query execution failed: ' . pg_last_error());

            $nrows = pg_numrows($result);
            if($nrows != 0)
            {
                for($j=0;$j<$nrows;$j++)
                {
                    $row = pg_fetch_array($result);
                    $row_value = $row["dname"] . " - " . $row["cno"];
                    echo "<option value='" . $row_value . "'>" . $row_value . "</option>";
                    echo "\n";
                }
            }
            else    echo "<p>No Entry for " . $_POST['studentid'];

            pg_close($dbconn);
        }
    ?>
    </p>
</body>
</html>

