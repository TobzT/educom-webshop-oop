<?php 
function ShowLoginContent($data){
    $data = getData('login');
    
    showMetaForm($data, "Log in");
}
?>