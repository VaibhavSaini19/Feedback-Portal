<?php
    if(!isset($_SESSION)) { 
        session_start(); 
    } 
    if(!isset($_SESSION['user'])){
        // var_dump($_SESSION);
        header ('Locaiton: index.php?act=login');
        exit();
    }
?>

<div class="content">
    <h1>HTTP 404</h1>
    <h3>The page you request was <strong>Not Found</strong></h3>
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