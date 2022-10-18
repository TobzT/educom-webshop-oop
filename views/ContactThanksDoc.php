<?php 
include_once("./views/FormsDoc.php");
class ContactThanksDoc extends FormsDoc {

    protected function showBodyContent() {
        $genders = getGenders();
        $options = getOptions();
        echo(
            '<p class="body">
                Dankjewel ' . $genders[$this->data['values']['gender']] . " " . ucfirst($this->data['values']['name']) . '! <br> <br>

                Jouw e-mail adres is ' . $this->data['values']["email"] . '. <br>
                Jouw telefoonnummer is ' . $this->data['values']["tlf"] . '. <br>
                Jouw voorkeur is ' . $options[$this->data['values']["radio"]] . '. <br> <br>
                
                ' . $this->data['values']["text"] . '
            </p>
            '
        );
    }
}
?>