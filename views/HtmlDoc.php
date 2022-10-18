<?php 
class HtmlDoc {
    
    public function show() {
        $this->showHtmlStart();
        $this->showHead();
        $this->showBody();
        $this->showHtmlEnd();
    }

    private function showHtmlStart() {
        echo('<!DOCTYPE html>');
        echo('<html>');
    }

    private function showHtmlEnd() {
        echo('</html>');
    }

    //HEAD
    private function showHead() {
        $this->showHeadStart();
        $this->linkCss();
        $this->showHeadEnd();
    }

    private function showHeadStart() {
        echo('<head>');
    }

    private function showHeadEnd() {
        echo('</head>');
    }

    private function linkCss() {
        echo('<link rel="stylesheet" href="../css/css.css">');
    }

    


    protected function showBody() {
        
    }

}
?>