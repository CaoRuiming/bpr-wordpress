//change font of article content
function changeFont(font) {
    $(document).ready(function(){
        $("#single-template p").css({"font-family" : font});
    });
}

//on April Fool's day, change font to Hellvetica 
function checkDate() {
    $(document).ready(function(){
        var time = new Date();    

        if (time.getMonth() == 3 &&
            time.getDate() == 1) {

            //add button to return font to normal
            $(".article-bottom").append("<button id='stop-hell'>Happy April Fool's Day! <br> Click to continue reading as normal.</button>");
            $("#stop-hell").css({
                "position": "fixed", 
                "left": "5px", 
                "bottom": "5px", 
                "display": "block", 
                "margin": "0 auto",
                "border-radius": "6px",
                "border": "1px solid #616161",
                "padding": "10px 15px",
                "font-family": "Work Sans",
                "cursor": "pointer",
                "z-index": "999"
            })
            $("#stop-hell").hover(
                function() {
                    $(this).css({"border": "3px solid #000000", "padding": "8px 13px"});
                }, function() { 
                    $(this).css({"border": "1px solid #000000", "padding": "10px 15px"});
                }
            );
            
            changeFont("Hellvetica");
        } 
    });
}

checkDate();

//on button click, change font back to normal and remove button
$(document).ready(function(){
    $('#stop-hell').click(function(){   
        changeFont("Work Sans");
        $(this).remove();
    });
});

