
<?php
    session_start();
    require 'config.php';
    if(!$_SESSION["username"]){
        header('location:index.php');
    }
    $user = $_SESSION["username"];
?>


    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

<body style="background-color:#95a5a6">
    <div class="container">
    <div class="page-header form-horizontal">
        <div class="form-group" >
            <h4 class="col-sm-2" >User: <?php echo $_SESSION['username']?></h4>
            <h4 class="col-sm-3" >Reports Page</h4>
            <form class="col-sm-20" method='post'>
                <input class="btn" type="submit" name="Back" value="Back"/>
                <input class="btn" type="submit" name="Logout" value="Logout"/>                 
                <?php

                    if(isset($_POST['Logout'])){
                        unset($_SESSION['username']);
                        header('location:index.php');
                    }
                    if(isset($_POST['Back']))
                    {
                        header('location:reports.php');
                        
                    }
                ?>

            </form> 
        </div>


    
<?php
// 1. List all the blogs of user X, such that all the comments are positive for these blogs.
if(isset($_POST['report1']))
{
    $userX = $_POST['userX'];
    echo "<div><h3> List all the blogs of user " .$userX. ", such that all the comments are positive for these blogs.</h3></div></div>";
    $sql = "select b.blogid as Id, b.subject as Subject, b.description as Description, b.postuser as Name, b.pdate as 'Post Date' from blogs b join comments c on b.blogid = c.blogid 
	where postuser = '$userX' and b.blogid not in (select distinct (b.blogid) from blogs b join comments c on b.blogid = c.blogid 
	where postuser = '$userX' and c.sentiment = 'Negative')";
    $result = mysqli_query($con, $sql);
    echo "<table class='table'> <thead><tr>" ;

    while($field_info = mysqli_fetch_field($result)) {
        //$field_info = mysqli_fetch_field($result, $i);
        echo "<th>{$field_info->name}</th>";
    };
    echo "</tr></thead>";


    while($row = mysqli_fetch_array($result))
    {
        echo "<tr><td>" . $row['Id'] ."</td> 
                  <td>" . $row['Subject'] ."</td> 
                  <td>" . $row['Description'] ."</td>
                  <td>" . $row['Name'] ."</td>
                  <td>" . $row['Post Date'] ."</td>
                  </tr>";
    }
    echo "</table>";
}


// 2. List the users who posted the most number of blogs on selected date; if there is a tie, list all the users who have a tie.
if(isset($_POST['report2']))
{
    echo "<h1>". $_POST['date']."</h1>";
    $date = $_POST['date'];
    echo "<div><h3> List the users who posted the most number of blogs on ". $date . "; if there is a tie, list all the users who have a tie.</h3></div></div>";
    $sql = "select postuser as User, count(*) as 'Number of blogs' from blogs where pdate = '$date' group by postuser having count(postuser) = (select max(totalBlogs) from (select count(postuser) as totalBlogs, postuser from blogs where pdate = '$date' group by postuser) s);";
    $result = mysqli_query($con, $sql);
    echo "<table class='table'> <thead><tr>" ;

    while($field_info = mysqli_fetch_field($result)) {
        //$field_info = mysqli_fetch_field($result, $i);
        echo "<th>{$field_info->name}</th>";
    };
    echo "</tr></thead>";


    while($row = mysqli_fetch_array($result))
    {
        echo "<tr><td>" . $row['User'] ."</td> 
                  <td>" . $row['Number of blogs'] ."</td> 
                  </tr>";
    }
    echo "</table>";
}

// 3. List the users who are followed by both X and Y. Usernames X and Y are inputs from the user.
if(isset($_POST['report3']))
{
    $userX = $_POST['userX'];
    $userY = $_POST['userY'];
    echo "<div><h3> List the users who are followed by both ". $userX. " and " . $userY.". </h3></div></div>";
    $sql = "select leader as User from follows where follower = '$userX' and leader in (select leader from follows where follower = '$userY');";
    $result = mysqli_query($con, $sql);
    echo "<table class='table'> <thead><tr>" ;

    while($field_info = mysqli_fetch_field($result)) {
        //$field_info = mysqli_fetch_field($result, $i);
        echo "<th>{$field_info->name}</th>";
    };
    echo "</tr></thead>";


    while($row = mysqli_fetch_array($result))
    {
        echo "<tr><td>" . $row['User'] ."</td> 
                  </tr>";
    }
    echo "</table>";
}

// 4. Display all the users who never posted a blog.
if(isset($_POST['report4']))
{
    echo "<div><h3> Display all the users who never posted a blog. </h3></div></div>";
    $sql = "select username as Username, firstName as 'First Name', lastName as 'Last Name'  from users where username not in (select distinct(postuser) from blogs)";
    $result = mysqli_query($con, $sql);
    echo "<table class='table'> <thead><tr>" ;

    while($field_info = mysqli_fetch_field($result)) {
        //$field_info = mysqli_fetch_field($result, $i);
        echo "<th>{$field_info->name}</th>";
    };
    echo "</tr></thead>";


    while($row = mysqli_fetch_array($result))
    {
        echo "<tr><td>" . $row['Username'] ."</td>";
            echo "<td>" . $row['First Name'] ."</td>";
            echo "<td>" . $row['Last Name'] ."</td>
                  </tr>";
    }
    echo "</table>";
}


// 5. Display all the users who posted some comments, but each of them is negative.
if(isset($_POST['report5']))
{
    echo "<div><h3> Display all the users who posted some comments, but each of them is negative. </h3></div></div>";
    $sql = "select username as Username, firstName as 'First Name', lastName as 'Last Name' from users where username not in (select distinct(author) from comments where sentiment = 'Positive') and username in (select distinct(author) from comments)";
    $result = mysqli_query($con, $sql);
    echo "<table class='table'> <thead><tr>" ;

    while($field_info = mysqli_fetch_field($result)) {
        //$field_info = mysqli_fetch_field($result, $i);
        echo "<th>{$field_info->name}</th>";
    };
    echo "</tr></thead>";


    while($row = mysqli_fetch_array($result))
    {
        echo "<tr><td>" . $row['Username'] ."</td>";
            echo "<td>" . $row['First Name'] ."</td>";
            echo "<td>" . $row['Last Name'] ."</td>
                  </tr>";
    }
    echo "</table>";
}

// 6. Display those users such that all the blogs they posted so far never received any negative comments.
if(isset($_POST['report6']))
{
    echo "<div><h3> Display those users such that all the blogs they posted so far never received any negative comments. </h3></div></div>";
    $sql = "select username as Username, firstName as 'First Name', lastName as 'Last Name' from users where username not in (select distinct(postuser) from blogs b inner join comments c on b.blogid = c.blogid where sentiment = 'Negative') and username in (select distinct(postuser) from blogs)";
    $result = mysqli_query($con, $sql);
    echo "<table class='table'> <thead><tr>" ;

    while($field_info = mysqli_fetch_field($result)) {
        //$field_info = mysqli_fetch_field($result, $i);
        echo "<th>{$field_info->name}</th>";
    };
    echo "</tr></thead>";


    while($row = mysqli_fetch_array($result))
    {
        echo "<tr><td>" . $row['Username'] ."</td>";
            echo "<td>" . $row['First Name'] ."</td>";
            echo "<td>" . $row['Last Name'] ."</td>
                  </tr>";
    }
    echo "</table>";
}
?>

</div>
</body>
