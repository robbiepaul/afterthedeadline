<?php namespace RobbieP\Afterthedeadline;


use RobbieP\Afterthedeadline\Error\Grammar;
use RobbieP\Afterthedeadline\Error\Spelling;
use RobbieP\Afterthedeadline\Error\Suggestion;

class FormatText
{
    protected $content;
    protected $results = [];
    protected $output;


    public function __construct($text, $results = [])
    {
        $this->content = $text;
        $this->results = $results;

        $this->format();
    }

    private function format()
    {
        foreach($this->results as $result) {
            $this->content = $this->setWords($result);
        }
    }

    private function setWords($result)
    {
        $text = str_replace($this->string($result), $this->string($result, true), $this->content);
        return $this->output = $text;
    }

    private function wrapSpan($result)
    {
        switch(true){
            case ($result instanceof Spelling):
                $suggestions = json_encode($result->getSuggestions());
                return "<span class='atd-{$result->type}' data-suggestions='{$suggestions}'>{$result->string}</span>";
            case ($result instanceof Grammar):
                $result->getInfo();
                return "<span class='atd-{$result->type}' data-info='{$result->hint_html}'>{$result->string}</span>";
            case ($result instanceof Suggestion):
                $result->getInfo();
                $suggestions = json_encode($result->getSuggestions());
                return "<span class='atd-{$result->type}' data-info='{$result->hint_html}' data-suggestions='{$suggestions}'>{$result->string}</span>";

        }
    }

    public function __toString()
    {
        return "<div id='atd-content'>".nl2br($this->output)."</div>"; //<button onclick='atd.finished()'>Finished</button>".$this->getStylesAndScript();
    }

    private function string($result, $replace = false)
    {
        $string = '';
        if(!empty($result->precontext)) {
            $string .= $result->precontext . ' ';
        }
        if(!$replace) {
            $string .= $result->string;
        } else {
            $string .= $this->wrapSpan($result);
        }
        return $string;
    }

    private function getStylesAndScript()
    {
        $style =  "<style>.atd-popover-grammar .popover-content h3{ margin: 0 0 10px 0;font-size: 1.4em;} .atd-popover-grammar .popover-content{font-size:0.9em} .atd-popover hr {margin-bottom:5px} .atd-popover ul.list-unstyled li a { cursor:pointer;padding:5px;display: block }.atd-spelling{cursor:pointer;border-bottom: 1px dotted tomato !important;}.atd-grammar{cursor:pointer;border-bottom: 1px dotted green !important;}.atd-suggestion{cursor:pointer;border-bottom: 1px dotted #0085ff !important;}</style>";
        $script = "
<script src=\"https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js\"></script>
<link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css\" integrity=\"sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7\" crossorigin=\"anonymous\">
<script src=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js\" integrity=\"sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS\" crossorigin=\"anonymous\"></script>

<script>
var suggestions = $('[data-suggestions]');
var info = $('[data-info^=\"<h3>\"]');//[data-info^=\"<h3>\"]
$(document).ready(function(){


    info.popover({
        html: true,
        trigger: 'hover',
        title: function(){
            return atd.getTitle.call(this)
        },
        content: function(){
            return atd.getInfo.call(this)
        },
        template:  '<div class=\"popover atd-popover atd-popover-grammar\" role=\"tooltip\" style=\"width:500px\"><div class=\"arrow\"></div><h3 class=\"popover-title\"></h3><div class=\"popover-content\"></div></div>'


    }).click(function(e) {
        info.not(this).popover('hide');
        $(this).popover('toggle');
        e.stopPropagation();
    });

    suggestions.popover({
        html: true,
        trigger: 'manual',
        title: function(){
            return atd.getTitle.call(this)
        },
        content: function(){
            return atd.getContent.call(this)
        },
        template:  '<div class=\"popover atd-popover\" role=\"tooltip\" style=\"width:200px\"><div class=\"arrow\"></div><h3 class=\"popover-title\"></h3><div class=\"popover-content\"></div></div>'


    }).click(function(e) {
        suggestions.not(this).popover('hide');
        $(this).popover('toggle');
        e.stopPropagation();
    });


});
var atd = {};
atd.getTitle = function() {
    var title = this.className.replace('atd-', '');
    return atd.ucFirst(title);
};
atd.getContent = function() {
    atd.activeEl = this;
    var links = '<ul class=\"list-unstyled\">';
    var s = $(this).data('suggestions');

    if( typeof s == 'string' ) {
        links += atd.spellingLink(s.replace(new RegExp('\"', 'g'), ''));
    } else if ( typeof s == 'object' ) {
        for(var i in s) {
            links += atd.spellingLink(s[i]);
        }
    }
    links += '</ul><hr><small><a onclick=\"atd.ignoreString()\">Ignore</a></small>';
    return links;
};
atd.getInfo = function() {
    atd.activeEl = this;
    var s = $(this).data('info');

    return s;
};
atd.spellingLink = function(s) {
    return '<li><a onclick=\"atd.replaceString(\''+s+'\')\">'+s+'</a></li>';
};
atd.replaceString = function(s) {
    atd.closeAllPopovers();
    $(atd.activeEl).after(s).remove();
};
atd.ignoreString = function() {
    var s = $(atd.activeEl).text();
    atd.replaceString(s);
};
atd.closeAllPopovers = function() {
    suggestions.popover('hide')
}
atd.ucFirst = function(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}
atd.finished = function() {
    $('#atd-content span').each(function(){
        atd.activeEl = this;
        atd.ignoreString();
    });
    atd.output();
}
atd.output = function() {
    alert($('#atd-content').html());
}
</script>";


        return $style.$script;
    }


}