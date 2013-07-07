$(document).ready(function() {

$("#db-chooser").on("DbxChooserSuccess", function(evt) {
    $("#dropbox-chooser-urls").empty();
    var files = evt.originalEvent.files;
	$links = makeLinks(files);
    $("#dropbox-chooser-urls").append($links);
});

});

function makeLinks() {
	for(var i=0; i<files.length; i++) {
        $link = $('<a/>', {
            'href': files[i].link,
            'text': files[i].link,
            'target': "blank_"
        }).append("<br/>")
    }
	
}



*/