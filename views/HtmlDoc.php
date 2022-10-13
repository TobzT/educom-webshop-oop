<?php 
class HtmlDoc {
    
    public function show() {
        $this->showHtmlStart();
        $this->showHtmlEnd();
    }

    protected function showHtmlStart() {
        echo('<!DOCTYPE html>');
        echo('<html>');
    }

    protected function showHtmlEnd() {
        echo('</html>');
    }
}
?>