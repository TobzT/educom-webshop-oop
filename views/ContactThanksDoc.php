<?php 
include_once("./views/BasicDoc.php");
class ContactThanksDoc extends BasicDoc {

    protected function showBodyContent() {
        $genders = getGenders();
        $options = getOptions();
        $pronoun = $genders[$this->data['values']['gender']];
        if($pronoun == 'Anders') {
            $pronoun = "";
        }
        echo(
            '<p class="body">
                Dankjewel ' . $pronoun . " " . ucfirst($this->data['values']['name']) . '! <br> <br>

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