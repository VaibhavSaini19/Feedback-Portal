<?php
    if(!isset($_SESSION)) { 
        session_start(); 
    } 
    // if(!isset($_SESSION['user'])){
    //     header ('Locaiton: student.php?act=login');
    //     exit();
    // }
    if($_SESSION['user']['status']==0){
        header ('Location: student.php?act=home');
    }
?>

<div class="content">
    <h1>Feedback Completed</h1>
    <h2>Thank you</h2>
    <h3>Your response have been saved <strong>successfully</strong>.</h3>
    <a href="student.php">Logout</a>
</div>

<style>
    .content{
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 3em;
        flex-grow: 1;
    }
</style>
