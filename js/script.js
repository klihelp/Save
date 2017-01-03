var app = {
	code: "",
	done: 0,
	needed: 0,
	r: 0
};

String.prototype.startsWith = function(str) {
	return (this.match("^"+str)==str);
};

app.fetch = function () {
	$.ajax({
		url: "api/get.php"
	}).done(function(res){
		if (res == "Can't connect to database.") {
			alert("Can't connect to the database! Please check your config.php.");
			$("body").fadeOut();
			return;
		}
		if (res.length == 0) {
			$(".loader").addClass("animated zoomOut").slideUp();
			$(".no-items").fadeIn();
			$(".about").show();
			app.r = 1;
			return;
		}
		app.needed = res.length;
		$(document).on("linksready", function(){
			app.done++;
			var progress = (100 / app.needed) * app.done;
			$(".navbar").css({ backgroundSize: progress + "% 100%" }, 500);
			if (app.needed == app.done) {
				$(".navbar").css({ backgroundSize: "0% 100%" }, 1000);
				$(".container .loader").fadeOut();
				$(".container .panel-parent").html(app.code).find('.col-sm-6').sort(function (a, b) {
				    return +a.dataset.sort - +b.dataset.sort;
				}).appendTo(".container .panel-parent");
				$(".container .panel-parent").fadeIn();
				$(".panel-link img").lazyload({
					effect: "fadeIn"
				});
				$("#search").trigger("keyup");
				$(".about").show();
			}
		});
		$.each(res, function(i){
			app.append(this);
		});
	});
};

app.append = function (data, start) {
	$(".no-items").fadeOut();
	var urli = data.url;
	if (!urli.startsWith("http://") && !urli.startsWith("https://")) {
		urli = "http://" + urli;
	}
	var title;
	$.ajax({
		url: "api/title/title.php?url=" + encodeURIComponent(urli)
	}).done(function(res){
		title = res;
		if (start == true) {
			$(".container .panel-parent").prepend('<div class="col-lg-4 col-sm-6 col-md-6 animated zoomIn">\
						<div class="panel panel-default panel-link" data-id="'+data.id+'">\
							<div class="panel-heading">\
								<h4>'+title+'</h4>\
								<small><i>'+(urli.replace('http://','').replace('https://','').split(/[/?#]/)[0])+'</i></small>\
							</div>\
							<div class="panel-body">\
								<img data-original="api/screenshot/screenshot.php?url='+encodeURIComponent(urli)+'&w=1000&h=600&cliph=600&clipw=1000">\
							</div>\
							<div class="panel-footer">\
								<div class="btn-group btn-group-justified"><a href="'+urli+'" target="_blank" class="btn btn-primary btn-action"><i class="icon-link"></i><span>Open</span></a>\
								<a href="#!" onclick="app.copy(\''+urli+'\')" class="btn btn-default btn-action"><i class="icon-copy"></i><span>Copy</span></a>\
								<a href="#!" onclick="app.delete('+data.id+')" class="btn btn-danger btn-action"><i class="icon-delete"></i><span>Delete</span></a></div>\
							</div>\
						</div>\
					</div>');
			if (app.r == 1) {
				$(".container .panel-parent").fadeIn();
			}
			$(".panel-link img").lazyload({
				effect: "fadeIn"
			});
			$("#search").trigger("keyup");
		}
		else {
			app.code += '<div class="col-lg-4 col-sm-6 col-md-6 animated zoomIn" data-sort="'+data.sort+'">\
							<div class="panel panel-default panel-link" data-id="'+data.id+'">\
								<div class="panel-heading">\
									<h4>'+title+'</h4>\
									<small><i>'+(urli.replace('http://','').replace('https://','').split(/[/?#]/)[0])+'</i></small>\
								</div>\
								<div class="panel-body">\
									<img data-original="api/screenshot/screenshot.php?url='+encodeURIComponent(urli)+'&w=1000&h=600&cliph=600&clipw=1000">\
								</div>\
								<div class="panel-footer">\
									<div class="btn-group btn-group-justified"><a href="'+urli+'" target="_blank" class="btn btn-primary btn-action"><i class="icon-link"></i><span>Open</span></a>\
									<a href="#!" onclick="app.copy(\''+urli+'\')" class="btn btn-default btn-action"><i class="icon-copy"></i><span>Copy</span></a>\
									<a href="#!" onclick="app.delete('+data.id+')" class="btn btn-danger btn-action"><i class="icon-delete"></i><span>Delete</span></a></div>\
								</div>\
							</div>\
						</div>';
		}
		$(document).trigger("linksready");
	});
};

app.delete = function (id) {
	app.del = id;
	$("#delete").modal();
};

app.deleteY = function () {
	$.ajax({
		url: "api/delete.php?url=" + app.del
	}).done(function(){
		$(".panel[data-id="+app.del+"]").parent().fadeOut(function(){
			$(this).remove();
			if ($(".panel-link").length == 0) {
				$(".no-items").fadeIn();
			}
		});
	});
};

app.add = function () {
	$.ajax({
		url: "api/push.php?url="+encodeURIComponent($("#add").val())
	}).done(function(res){
		$("#add").val("").blur();
		app.append(res, true);
	});
	return false;
};

app.copy = function (url) {
	$("#copy span a").text("Copy");
	$("#copyurl").val(url);
	$("#copy").modal("show");
};

$(document).ready(function(){
	$("body").fadeIn();
	app.fetch();
});

$(window).on("resize", function(){
	if ($(window).width() > 767) {
		$("#search").remove();
		$('<input type="text" class="form-control" placeholder="Search..." autocomplete="off" id="search">').insertBefore(".container");
		$("#search").off("keyup").on("keyup", function(){
		    var filter = $(this).val();
		    $(".container .panel-parent .col-sm-6").each(function(){
		        if ($(this).text().search(new RegExp(filter, "i")) < 0) {
		            $(this).fadeOut();
		        } else {
		            $(this).show();
		        }
		    });
		});

		$(".navbar #add").focus(function(){
			$(".navbar").addClass("focused");
			setTimeout(function(){
				$(".navbar .navbar-collapse ul, .navbar .navbar-header").hide();
			}, 200);
		});

		$(".navbar #add").focusout(function(){
			$(".navbar").removeClass("focused");
			setTimeout(function(){
				$(".navbar .navbar-collapse ul, .navbar .navbar-header").fadeIn();
			}, 250);
		});
	}
	else {
		$("#search").remove();
		$(".form-group").append('<input type="text" class="form-control" placeholder="Search..." autocomplete="off" id="search">');
		$("#search").off("keyup").on("keyup", function(){
		    var filter = $(this).val();
		    $(".container .panel-parent .col-sm-6").each(function(){
		        if ($(this).text().search(new RegExp(filter, "i")) < 0) {
		            $(this).fadeOut();
		        } else {
		            $(this).show();
		        }
		    });
		});
	}

	$("#search").on("focusout", function(){
		$(".navbar").removeClass("search");
		$("#search").removeClass("active").val("").trigger("keyup");
	}).trigger("focusout");
}).trigger("resize");

function copyToClipboard (elem) {
	var targetId = "_hiddenCopyText_";
	var isInput = elem.tagName === "INPUT" || elem.tagName === "TEXTAREA";
	var origSelectionStart, origSelectionEnd;
	if (isInput) {
		target = elem;
		origSelectionStart = elem.selectionStart;
		origSelectionEnd = elem.selectionEnd;
	}
	else {
		target = document.getElementById(targetId);
		if (!target) {
			var target = document.createElement("textarea");
			target.style.position = "absolute";
			target.style.left = "-9999px";
			target.style.top = "0";
			target.id = targetId;
			document.body.appendChild(target);
		}
		target.textContent = elem.textContent;
	}
	var currentFocus = document.activeElement;
	target.focus();
	target.setSelectionRange(0, target.value.length);
	var succeed;
	try {
		succeed = document.execCommand("copy");
	} catch (e) {
		succeed = false;
	}
	if (currentFocus && typeof currentFocus.focus === "function") {
		currentFocus.focus();
	}
	if (isInput) {
		elem.setSelectionRange(origSelectionStart, origSelectionEnd);
	} else {
		target.textContent = "";
	}
	return succeed;
}