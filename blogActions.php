
<?php
    session_start();
    include('config.php');


// delete blog 
if(isset($_POST['delete']))
{
    

    $blogid = $_POST['blogid'];

    $sql  = "delete from comments where blogid =  '$blogid';";
    $sql .= "delete from blogstags where blogid =  '$blogid';";
    $sql .= "delete from blogs where blogid =  '$blogid';";
    

    if (mysqli_multi_query($con, $sql)) {
        header("location:blog.php");
      } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($con);
    }
}

if (isset($_POST['follow']))
{
    $leader = $_POST['leader'];
    $follower = $_SESSION["username"];
    $sql = "insert into follows values('$leader', '$follower')";
    if (mysqli_query($con, $sql)) {
        header("location:blog.php");
      } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($con);
    }

}

if (isset($_POST['unfollow']))
{
    $leader = $_POST['leader'];
    $follower = $_SESSION["username"];
    $sql = "delete from follows where leader = '$leader' and follower = '$follower'";
    if (mysqli_query($con, $sql)) {
        header("location:blog.php");
      } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($con);
    }

}


// edit blog
if(isset($_POST['edit']))
{
    $blogid = $_POST['blogid'];

    header("location:updatePost.php?blogid=" . $blogid);
    
}


?>