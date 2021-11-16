<!DOCTYPE html>
<html lang="en"> 
<head>
    <title>Result of Department Age Query</title>
</head>
<body> 
    <h1>Result of Department Age Query</h1>
    <?php
        $dbconn = pg_connect("host=tr01")
            or die('Could not connect: ' . pg_last_error());

        // Prepare a query for execution with $1 as a placeholder
        $result = pg_prepare($dbconn, "age_query", 'SELECT DISTINCT M.dname FROM major M WHERE EXISTS (SELECT S.sid FROM student S WHERE M.sid=S.sid AND S.age < $1)')
            or die('Query preparation failed: ' . pg_last_error());

        // Execute the prepared query with the value from the form as the actual argument 
        $result = pg_execute($dbconn, "age_query", array($_POST['age']))
            or die('Query execution failed: ' . pg_last_error());

        $nrows = pg_numrows($result);
            if($nrows != 0)
            {
            print "<p>Data for age: " . $_POST['age'];
            print "<table border=2><tr><th>Department Name\n";
            for($j=0;$j<$nrows;$j++)
                {
                    $row = pg_fetch_array($result);
                    print "<tr><td>" . $row["dname"];
                    print "\n";
                }
                print "</table>\n";
            }
            else    print "<p>No Entry for " . $_POST['age'];
            pg_close($dbconn);
    ?>
    </p>
</body>
</html>

