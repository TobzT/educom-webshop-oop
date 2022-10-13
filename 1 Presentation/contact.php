<?php 
function showContactContent() {
    $data = getData('contact');

    // var_dump($data);
    if($data["valid"] == true) {
        showContactThanks($data);
        
    } else {
        showMetaForm($data, "Submit");
    }
}

function showContactThanks($data) {
    $genders = getGenders();
    $options = getOptions();
    echo(
        '<p class="body">
            Dankjewel ' . $genders[$data['values']['gender']] . " " . ucfirst($data['values']['name']) . '! <br> <br>

            Jouw e-mail adres is ' . $data['values']["email"] . '. <br>
            Jouw telefoonnummer is ' . $data['values']["tlf"] . '. <br>
            Jouw voorkeur is ' . $options[$data['values']["radio"]] . '. <br> <br>
            
            ' . $data['values']["text"] . '
        </p>
        '
    );
}
?>