<!DOCTYPE html>
<html lang="en">
<head>
    <title>
    Practical 2 - Optional
    </title>
</head>
<body>
    <h1>
        Practical 2 - Optional
    </h1>

	Enter a student ID and select a course to return the student's grade.
	<br><br>
	<form method=post>
		Student ID:
		<input type=number name="studentid" placeholder="(1..104)">
		<!-- <input type=submit value="Submit student ID"> -->
		<select name="course" id="course" value="$course">
			<?php include("opt1.php"); ?>
		</select>
		<input type=submit value="Retrieve Grade">
	</form>
	<br>
	<?php include("opt2.php"); ?>
	<br>
	<br>
</body>
</html>
