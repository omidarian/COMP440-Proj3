<?php
    session_start();
    require 'config.php';
    if(!$_SESSION["username"]){
        header('location:index.php');
    }
    $follower = $_SESSION["username"];
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
                        header('location:welcome.php');
                        
                    }
                ?>

            </form> 
        </div>
    </div>

    <form class="col-sm-20" method='post' action="reportActions.php">
        <input class="btn" type="submit" name="report1" value="1. List all the blogs of user X, such that all the comments are positive for these blogs."/><br>
        <label>User X: </label><input type='text' name='userX' value='<?php echo $_SESSION['username']?>' required>
    </form>
    <form class="col-sm-20" method='post' action="reportActions.php">
        <input class="btn" type="submit" name="report2" value="2. List the users who posted the most number of blogs on the selected date; if there is a tie, list all the users who have a tie."/><br>
        <label>Date: </lable><input type="date" name="date" required><br><br>
    </form>
    <form class="col-sm-20" method='post' action="reportActions.php">
        <input class="btn" type="submit" name="report3" value="3. List the users who are followed by both X and Y. Usernames X and Y are inputs from the user."/><br>
        <label>User X: </label><input type='text' name='userX' required>
        <label>&nbsp &nbsp User Y: </label><input type='text' name='userY' required><br>

    </form>
    <form class="col-sm-20" method='post' action="reportActions.php">
        <input class="btn" type="submit" name="report4" value="4. Display all the users who never posted a blog."/>
    </form>
    <form class="col-sm-20" method='post' action="reportActions.php">
        <input class="btn" type="submit" name="report5" value="5. Display all the users who posted some comments, but each of them is negative."/>
    </form>
    <form class="col-sm-20" method='post' action="reportActions.php">
        <input class="btn" type="submit" name="report6" value="6. Display those users such that all the blogs they posted so far never received any negative comments."/>
    </form> 

</div>
</body>