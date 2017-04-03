
function run(d) {
    stopReloader();
    $('#result').val("");
    $.ajax( {
	url: "/run",
	method: "POST",
	processData: false,
	async: false,
	data: d
    })
	.done(function(data, textStatus, jqXHR) {
	    out = data.split('\n')[0]
	    startReloader(out);
	    name = out.replace(/\.out$/, "") + ".py";
	    $('#history').prepend("<li><a href=\"#\" onclick=\"javascript:load('" + name + "')\">" + name + "</a></li>");
	})
	.fail(function(jqXHR, textStatus, errorThrown) {
	    alert("Run failed: " + textStatus);
	})
    ;
    return false;
}

function save(d, name) {
    name = name.replace(/\.py$/, "") + ".py";
    $.ajax( {
	url: "/save/" + name,
	method: "POST",
	processData: false,
	async: false,
	data: d
    })
	.done(function(data, textStatus, jqXHR) {
	    $('#portfolio').prepend("<li><a href=\"#\" onclick=\"javascript:load('" + name + "')\">" + name + "</a></li>");
	})
	.fail(function(jqXHR, textStatus, errorThrown) {
	    alert("Save failed: " + textStatus);
	})
    ;
    return false;
}

var reloader;

function startReloader(out) {
    $('#resultfile').text(out + ":");
    reloader = setInterval(function () {
	$.get("turtlescripts/" + out, null, function (data) {
	    $('#result').val(data);
	}, "text");
    }, 1000);
}

function stopReloader() {
    clearInterval(reloader);
}

function load(file) {
    stopReloader();
    $('#code').val("");
    $('#result').val("");
    $.get("turtlescripts/" + file, null, function (data) {
	$('#code').val(data);
    }, "text");
    out = file.replace(/\.py$/, ".out");
    startReloader(out);
}
