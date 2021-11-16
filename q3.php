<!DOCTYPE html>
<html lang="en"> 
<head>
    <title>Result of Capped Section Query</title>
</head>
<body> 
    <h1>Result of Capped Section Query</h1>
    <?php
        $dbconn = pg_connect("host=tr01")
            or die('Could not connect: ' . pg_last_error());

        // Prepare a query for execution with $1 as a placeholder
        $result = pg_prepare($dbconn, "cap_query", 'SELECT S.dname, S.cno, S.sectno FROM section S JOIN enroll E ON E.dname=S.dname AND E.cno=S.cno AND E.sectno=S.sectno GROUP BY S.dname, S.cno, S.sectno HAVING $1 > COUNT(*);')
            or die('Query preparation failed: ' . pg_last_error());

        // Execute the prepared query with the value from the form as the actual argument 
        $result = pg_execute($dbconn, "cap_query", array($_POST['capacity']))
            or die('Query execution failed: ' . pg_last_error());

        $nrows = pg_numrows($result);
            if($nrows != 0)
            {
            print "<p>Data for capacity cap: " . $_POST['capacity'];
            print "<table border=2><tr><th>Department Name<th>Course Number<th>Section Number\n";
            for($j=0;$j<$nrows;$j++)
                {
                    $row = pg_fetch_array($result);
                    print "<tr><td>" . $row["dname"];
                    print "<td>" . $row["cno"];
                    print "<td>" . $row["sectno"];
                    print "\n";
                }
                print "</table>\n";
            }
            else    print "<p>No Entry for " . $_POST['capacity'];
            pg_close($dbconn);
    ?>
    </p>
</body>
</html>

