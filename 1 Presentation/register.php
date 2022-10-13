<?php 
function showRegisterContent() {
    $data = getData('register');
    

    showMetaForm($data, "Sign up");
    
}
?>