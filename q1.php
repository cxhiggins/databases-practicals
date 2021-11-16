<!DOCTYPE html>
<html lang="en"> 
<head>
    <title>Result of Course Number Query</title>
</head>
<body> 
    <h1>Result of Course Number Query</h1>
    <?php
        $dbconn = pg_connect("host=tr01")
            or die('Could not connect: ' . pg_last_error());

        // Prepare a query for execution with $1 as a placeholder
        $result = pg_prepare($dbconn, "cno_query", 'SELECT S.sname, E.dname, E.grade FROM student S JOIN enroll E ON S.sid=E.sid WHERE E.cno = $1;')
            or die('Query preparation failed: ' . pg_last_error());

        // Execute the prepared query with the value from the form as the actual argument 
        $result = pg_execute($dbconn, "cno_query", array($_POST['cno']))
            or die('Query execution failed: ' . pg_last_error());

        $nrows = pg_numrows($result);
            if($nrows != 0)
            {
            print "<p>Data for course number: " . $_POST['cno'];
            print "<table border=2><tr><th>Student Name<th>Department Name<th>Grade\n";
            for($j=0;$j<$nrows;$j++)
                {
                    $row = pg_fetch_array($result);
                    print "<tr><td>" . $row["sname"];
                    print "<td>" . $row["dname"];
                    print "<td>" . $row["grade"];
                    print "\n";
                }
                print "</table>\n";
            }
            else    print "<p>No Entry for " . $_POST['cno'];
            pg_close($dbconn);
    ?>
    </p>
</body>
</html>

