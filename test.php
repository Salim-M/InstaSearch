<?php
    include('Instagram.class.php');
    $ig = new Instagram('majzoub_salim');
    // fetch all associated accounts
    $results = $ig->results();
    var_dump($results);
    //match the account
    var_dump($ig->match($results));
?>