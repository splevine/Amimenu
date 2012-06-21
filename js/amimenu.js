/*
 * ----------------------------- Amimenu -------------------------------------
 * all major browsers - IE6+, Firefox2+, Safari4+, Chrome4+ and Opera 10.5+
 *
 * Copyright (c) 2012 Alberto Mu–oz Fuertes, slaptot@gmail.com
 * Project homepage: www.mowaps.com
 *
 * Licensed under MIT-style license:
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */
 
 /*
 * ----------------------------- Custom Toggle  -------------------------------------
 * 
 */
 
 
 jQuery('.toggleToMap').click(function () {
 jQuery('#map').showMap();
 jQuery('.nav-collapse').collapse('toggle');
 });
    jQuery('.toggleWidth').click(function () {
    jQuery('#mapcontentlist').slideToggleWidth();
    jQuery('#map').slideToggleWidth();
   // jQuery('.nav-collapse').collapse('toggle');
});

    
jQuery.fn.extend({
 showMap: function() {
    jQuery(this).animate({width: 'show'});
    jQuery('#mapcontentlist').animate({width: 'hide'});
    
   
  },
  slideRight: function() {
  jQuery('.icon-map-marker.icon-white').removeClass("icon-map-marker").addClass("icon-list");
  jQuery('.icon-map-marker.icon-white').removeClass("icon-map-marker").addClass("icon-th-list");
    return this.each(function() {
      jQuery(this).animate({width: 'show'});
    });
  },
  slideLeft: function() {
  jQuery('.icon-list.icon-white').removeClass("icon-list").addClass("icon-map-marker");
  jQuery('.icon-th-list.icon-white').removeClass("icon-th-list").addClass("icon-map-marker");
    return this.each(function() {
      jQuery(this).animate({width: 'hide'});
    });
  },
  slideToggleWidth: function() {
    return this.each(function() {
      var el = jQuery(this);
      if (el.css('display') == 'none') {
        el.slideRight();
         
      } else {
        el.slideLeft();
      }
    });
  }
}); 
 /*
 * ----------------------------- Map initialization  -------------------------------------
 * Leaflet API http://leaflet.cloudmade.com
 *
 */
var map, newUser, users, mapquest, firstLoad;

firstLoad = true;
var LeafIcon = L.Icon.extend({
		options : {
			iconUrl : 'markerMe.png',
			shadowUrl : 'marker-shadow.png',
			iconSize : new L.Point(25, 41),
			shadowSize : new L.Point(25, 41)
		}
	});
	var icon = new LeafIcon();
users = new L.FeatureGroup();
newUser = new L.LayerGroup();

mapquest = new L.TileLayer(
		"http://{s}.mqcdn.com/tiles/1.0.0/osm/{z}/{x}/{y}.png", {
			maxZoom : 17,
			minZoom : 4,
			subdomains : [ "otile1", "otile2", "otile3", "otile4" ],
			attribution : '<img width="90" src="img/logoheader.png"/>'
		});

map = new L.Map('map', {
	center : new L.LatLng(40.430224, -3.713379),
	zoom : 8,
	layers : [ mapquest, users, newUser ]
});

map.addControl(new L.Control.Scale());
/*
 * ----------------------------- Screen Handlers & Ajax Request Config  -------------------------------------
 * 
 */
$(document).ready(function() {
	$.ajaxSetup({
		cache : false,
		scriptCharset : "utf-8",
		contentType : "application/json; charset=utf-8"
	});
	$('#map').css('height', ($(window).height() - 90));
	if($(window).width()<970){
	$('#mapcontentlist').css('margin-top', '-5px');
	$('#mapcontentlist').css('height', ($(window).height() - 135));
	$('#map').css('margin-top', '0px');
	}else{
	$('#mapcontentlist').css('margin-top', '40px');
	$('#mapcontentlist').css('height', ($(window).height() - 140));
	$('#map').css('margin-top', '60px');
	}
	getRestaurants();
});

$(window).resize(function() {
	$('#map').css('height', ($(window).height() - 90));
	if($(window).width()<970){
	$('#mapcontentlist').css('margin-top', '-5px');
	$('#mapcontentlist').css('height', ($(window).height() - 135));
	$('#map').css('margin-top', '0px');
	}else{
	$('#mapcontentlist').css('margin-top', '40px');
	$('#mapcontentlist').css('height', ($(window).height() - 140));
	$('#map').css('margin-top', '60px');
	}


}).resize();

// map events
function setRadiusActive() {
	document.body.style.cursor = 'crosshair';
	map.on('click', function myCallback(e) {
		liveRadiusSearch(e.latlng.lat, e.latlng.lng);
		map.off('click', myCallback);
		$('#iconoradius').removeClass("activeicon");
		document.body.style.cursor = 'default';
		return false;
	});
	$('#iconoradius').addClass("activeicon");

}
/*
 * ----------------------------- onLocationFound(e)  -------------------------------------
 * Leaflet API http://leaflet.cloudmade.com
 * e: Return event data
 *
 */
map.on('locationfound', onLocationFound);

function onLocationFound(e) {
	var radius = e.accuracy / 2;
	
	var markerme = new L.Marker(e.latlng, {
		icon : icon
	});
	map.addLayer(markerme);
	$.jStorage.set("lastlat", e.latlng.lat);
	$.jStorage.set("lastlng", e.latlng.lng);
	//var circle = new L.Circle(e.latlng, radius);
	//map.addLayer(circle);
	map
	liveRadiusSearch(e.latlng.lat, e.latlng.lng)
}
/*
 * ----------------------------- geoLocate() -------------------------------------
 * Action Button to get location
 *
 */
function geoLocate() {
	map.locate({
		setView : true,
		maxZoom : 17
	});
}
/*
 * ----------------------------- getLocate(lat, lon)  -------------------------------------
 * Action Button to get location from http://nominatim.openstreetmap.org/
 * lat: STRING
 * lng: STRING
 *
 */
function getLocate(lat, lon) {
	var reverse = "http://nominatim.openstreetmap.org/reverse?email=slaptot@gmail.com&accept-language=en_EN&format=json&lat="
			+ lat + "&lon=" + lon + "&zoom=18&addressdetails=1";

	$.getJSON(reverse, function(data) {
		var city = data.address.city;
		var state = data.address.state;
		var country = data.address.country;
		var postcode = data.address.postcode;
		$("#city").val(city);
		$("#state").val(state);
		$("#country").val(country);
		$("#postcode").val(postcode);
		$("#addresse").val(data.display_name);
	});

}

/*
 * ----------------------------- initRegistration()  -------------------------------------
 * Start Leaflet Map Configuration
 * 
 */
function initRegistration() {

	map.addEventListener('click', onMapClick);
	document.body.style.cursor = 'crosshair';
	return false;
}
/*
 * ----------------------------- cancelEdit()  -------------------------------------
 * Hide editSuccessModal view and map listener
 * 
 */
function cancelEdit() {
	newUser.clearLayers();
	$('#editSuccessModal').modal('hide');
	document.body.style.cursor = 'default';
	map.removeEventListener('click', onMapClick);
}
/*
 * ----------------------------- cancelRegistration()  -------------------------------------
 * Hide registerModal view and map listener
 * 
 */
function cancelRegistration() {
	newUser.clearLayers();
	$('#registerModal').modal('hide');

	document.body.style.cursor = 'default';
	map.removeEventListener('click', onMapClick);
}
/*
 * ----------------------------- getCountries()  -------------------------------------
 * Hide registerModal view and map listener
 * 
 */
function getCountries() {
	$.getJSON("getcountries.php", function(data) {
	for ( var i = 0; i < data.length; i++) {
		var name = data[i].pay;
		$("#listcountries").append("<li><a href='#' onClick='getState(\"" + data[i].pay + "\")'>" + data[i].pay + "</a></li>");
		}
	});
}
/*
 * ----------------------------- changeNameCity(city)  -------------------------------------
 * Change Dropdown name to parameter city
 * city: STRING
 *
 */
function changeNameCity(city) {
	$('#namecity').empty();
	$('#namecity').html(city + " <b class='caret'></b>");
}
/*
 * ----------------------------- changeNameState(state)  -------------------------------------
 * Change Dropdown name to parameter state
 * state: STRING
 *
 */
function changeNameState(state) {
	$('#namestate').empty();
	$('#namestate').html(state + " <b class='caret'></b>");
}
/*
 * ----------------------------- getState(country)  -------------------------------------
 * Get States from given country
 * country: STRING
 *
 */
function getState(country) {
	$.jStorage.set("lastcountry", country);
	$('#namestate').html("- <b class='caret'></b>");
	$('#namecity').html("- <b class='caret'></b>");
	$('#namecountry').html(country + ' <b class="caret"></b>');
	$("#liststates").empty();
	$("#listcities").empty();
	if (firstLoad == false) {
	liveSearch('country', state);
	}
	$.getJSON("getstates.php?country=" + country, function(data) {

		for ( var i = 0; i < data.length; i++) {

			$("#liststates").append(
					"<li><a href='#' onClick='getCities(\""
							+ data[i].departement
							+ "\");liveSearch(\"state\",\""
							+ data[i].departement + "\");changeNameState(\""
							+ data[i].departement + "\");'>"
							+ data[i].departement + "</li>");
		}
	});

}
/*
 * ----------------------------- getCities(state)  -------------------------------------
 * Get Cities from given state
 * state: STRING
 *
 */
function getCities(state) {
	$.jStorage.set("laststate", state);
	$('#namecity').html("- <b class='caret'></b>");
	$("#listcities").empty();
	if (firstLoad == false) {
	liveSearch('country', state);
	}
	$
			.getJSON(
					"getcities.php?state=" + state,
					function(data) {

						for ( var i = 0; i < data.length; i++) {

							$("#listcities")
									.append(
											"<li><a href='#' onClick='liveSearch(\"city\",\""
													+ data[i].ville
													+ "\");changeNameCity(\""
													+ data[i].ville
													+ "\");$(\".nav-collapse\").collapse(\"toggle\");'>"
													+ data[i].ville + "</li>");
						}
					});

}
/*
 * ----------------------------- setListItems(data)  -------------------------------------
 * Create the list of the items on the map
 * data: JSON
 */
function setListItems(data) {

	$('.thumbnails').empty();
	
	for ( var i = 0; i < data.length; i++) {

		var location = new L.LatLng(data[i].glat, data[i].glng);
		var name = data[i].nom;
		var imagen = data[i].img;
		var intro = data[i].intro;
		var id = data[i].id;
		var tel = data[i].tel;
		 var itemshtml = '<li class="span6"><div class="thumbnail"><img src="uploads/50_'
				+ imagen
				+ '" alt=""><div class="caption"><h5>'
				+ name
				+ '</h5><p>'
				+ intro
				+ '</p><p><a href="#" onClick="getRestaurant('
				+ id
				+ ')" class="btn btn-primary">Go</a>';
		if (tel) {
			itemshtml += '<a a href="tel:' + tel
					+ '" class="btn">Call</a>';
		}
		itemshtml += '</p></div></div></li>';
		$('.thumbnails').append(itemshtml);

				
/*
 * ----------------------------- Image Error  -------------------------------------
 * 
 */
$("img").error(function () {
  $(this).unbind("error").attr("src", "uploads/50_undefined");
});
	
		
	}

}
/*
 * ----------------------------- liveRadiusSearch(lat, lng)  -------------------------------------
 * Search items around position from given latitude and longitude. If radius active we send to the server
 * lat: STRING
 * lng: STRING
 *
 */
function liveRadiusSearch(lat, lng) {
	users.clearLayers();
	var radius = $('#radiustosend').html();
	$.jStorage.set("lastradius", radius);
	$.jStorage.set("lastlat", lat);
	$.jStorage.set("lastlng", lng);
	$
			.getJSON(
					"getbusinessradius.php?lat=" + lat + "&lng=" + lng
							+ "&radius=" + radius,
					function(data) {

						for ( var i = 0; i < data.length; i++) {
							var location = new L.LatLng(data[i].glat,
									data[i].glng);
							var name = data[i].nom;

							if (data[i].nom != null) {

								var title = "<div style='font-size: 18px; color: #0078A8;'><a href='#' onClick='getRestaurant("
										+ data[i].id
										+ ");'>"
										+ data[i].nom
										+ "</a><br/><a href='tel:"
										+ data[i].tel
										+ "'>"
										+ data[i].tel
										+ "</a><article>"
										+ data[i].intro
										+ "</article></div>";

								if (data[i].ville != null) {
									var city = "<div style='font-size: 14px;'>"
											+ data[i].ville + "</div>";
								} else {
									var city = "";
								}

								var marker = new L.Marker(location);
								marker.bindPopup(
												"<div style='text-align: center; margin-left: 10px; margin-right: 10px;'>"
														+ title
														+ city
														+ "<span><a rel='localize[btntoque]' class='btn btn-success btn-small' onClick='opentoque("
														+ data[i].tel
														+ ");'>Toque</a></span></div>",
												{
													maxWidth : '250',
													minWidth : '150'
												});
								users.addLayer(marker);
							}
						}
						setListItems(data);
					}).complete(function() {
				map.fitBounds(users.getBounds());
				if (firstLoad == true) {
					map.fitBounds(users.getBounds());
					firstLoad = true;
				}
				;
			});

}
/*
 * ----------------------------- liveSearch(param, query)  -------------------------------------
 * Search items around position from given latitude and longitude. If radius active we send to the server
 * param: STRING {searching}
 * query: STRING 
 *
 */
function liveSearch(param, query) {
	users.clearLayers();
	if (param == "city") {
		$.jStorage.set("lastcity", query);
	}
	$.getJSON("get_restaurants.php?" + param + "=" + query,
					function(data) {

						for ( var i = 0; i < data.length; i++) {
							var location = new L.LatLng(data[i].glat,
									data[i].glng);
							var name = data[i].nom;

							if (data[i].nom != null) {
								var title = "<div style='font-size: 18px; color: #0078A8;'><a href='#' onClick='getRestaurant("
										+ data[i].id
										+ ")'>"
										+ data[i].nom
										+ "</a><br/><a href='tel:"
										+ data[i].tel
										+ "'>"
										+ data[i].tel
										+ "</a><article>"
										+ data[i].intro
										+ "</article></div>";

								if (data[i].ville != null) {
									var city = "<div style='font-size: 14px;'>"
											+ data[i].ville + "</div>";
								} else {
									var city = "";
								}

								var marker = new L.Marker(location);
								marker.bindPopup(
												"<div style='text-align: center; margin-left: 10px; margin-right: 10px;'>"
														+ title
														+ city
														+ "<span><a rel='localize[btntoque]' class='btn btn-success btn-small' onClick='opentoque("
														+ data[i].tel
														+ ");'>Toque</a></span></div>",
												{
													maxWidth : '250',
													minWidth : '150'
												});
								users.addLayer(marker);
							}
						}
						setListItems(data);
					}).complete(function() {
				map.fitBounds(users.getBounds());
				if (firstLoad == true) {
					map.fitBounds(users.getBounds());
					firstLoad = true;
				}
				;
			});

}
/*
 * ----------------------------- getRestaurants()  -------------------------------------
 * Search random items
 *
 */
function getRestaurants() {
	$.getJSON("get_restaurants.php",
					function(data) {
					setListItems(data);
						for ( var i = 0; i < data.length; i++) {
							var location = new L.LatLng(data[i].glat,
									data[i].glng);
							var name = data[i].nom;
							if ((data[i].nom != null)&&(data[i].glat != "")&&(data[i].glng != "")) {

								var title = "<div style='font-size: 18px; color: #0078A8;'><a href='#' onClick='getRestaurant("
										+ data[i].id
										+ ")'>"
										+ data[i].nom
										+ "</a><br/><a href='tel:"
										+ data[i].tel
										+ "'>"
										+ data[i].tel
										+ "</a>";
								if (data[i].intro != null
										&& data[i].intro != 'null') {
									title += "</div>";
								} else {
									title += "</div>";
								}

								if (data[i].ville != null) {
									var city = "<div style='font-size: 14px;'>"
											+ data[i].ville + "</div>";

								} else {
									var city = "";
								}

								var marker = new L.Marker(location);
								marker.bindPopup(
												"<div style='text-align: center; margin-left: 10px; margin-right: 10px;'>"
														+ title
														+ city
														+ "<span><a rel='localize[btntoque]' class='btn btn-success btn-small' onClick='opentoque("
														+ data[i].tel
														+ ");'>Toque</a></span></div>",
												{
													maxWidth : '300',
													minWidth : '150'
												});
								users.addLayer(marker);
							}
						}
						
					}).complete(function() {
					
				if (firstLoad == true) {
				
					map.fitBounds(users.getBounds());
					firstLoad = false;
				}
				;
			});
}
/*
 * ----------------------------- opentoque(tel)  -------------------------------------
 * Send sms to given tel. Use Clickatell service (paid)
 * tel: STRING 
 *
 */
function opentoque(tel) {
	$('#dartoqueModal').modal('show');
	$('#teltosend').html(tel);
}
/*
 * ----------------------------- prepareUpload()  -------------------------------------
 * Prepare image file to send
 *
 */
var file;
function prepareUpload() {
	document.getElementById('fileSize').innerHTML = '';

	// get file name
	file = document.getElementById('fileToUpload').value;
	if (file.lastIndexOf('\\') >= 0)
		file = file.substr(file.lastIndexOf('\\') + 1);
	document.getElementById('fileName').innerHTML = file;

	// get folder path
	var curFolder = window.location.href;
	if (curFolder[curFolder.length - 1] != '/')
		curFolder = curFolder.substring(0, curFolder.lastIndexOf('/') + 1);

	document.getElementById('target').innerHTML = curFolder;
	document.getElementById('inputform').action = curFolder;
}
/*
 * ----------------------------- insertRestaurant()  -------------------------------------
 * Send form to insert into DB
 *
 */
function insertRestaurant() {
	var name = $("#name").val();
	var phone = $("#phone").val();
	var intro = $("#intro").val();
	var email = $("#email").val();
	var website = $("#website").val();
	var city = $("#city").val();
	var lat = $("#lat").val();
	var lng = $("#lng").val();
	var introlunes = $("#mondaymenu").val();
	var intromartes = $("#tuesdaymenu").val();

	if (name.length == 0) {
		$('#checkform').val("Name is required!");
		$('#checkerror').show();
		return false;
	}
	if (email.length == 0) {
		alert("Email is required!");
		return false;
	}
	var dataString = 'name=' + name + '&intro=' + intro + '&phone=' + phone
			+ '&email=' + email + '&website=' + website + '&city=' + city
			+ '&lat=' + lat + '&lng=' + lng + '&introlunes=' + introlunes
			+ '&intromartes=' + intromartes + '&fileToUpload=' + file;
	$.ajax({
		type : "POST",
		url : "insert_restaurant.php",
		data : dataString,
		success : function() {

			cancelRegistration();
			users.clearLayers();
			getCountries();
			getRestaurants();
			$('#insertSuccessModal').modal('show');
		},
		error : function() {
			cancelRegistration();
			users.clearLayers();
			$('#insertFailModal').modal('show');
		},
		complete : function() {
			cancelRegistration();
			users.clearLayers();
			getCountries();
			getRestaurants();
			$('#insertSuccessModal').modal('show');
		}
	});
	return false;
}
/*
 * ----------------------------- sendPush()  -------------------------------------
 * Send notification to online user with http://pusher.com
 *
 */
function sendPush() {
$.getJSON(
			"pusher/tetst.php?id="+$('#id_push').val()+"&mensaje="+$('#mensaje_push').val(),
			function(data) {
			}).complete(function() {
			$('#pushedit').html('<div class="alert alert-success" style="display:block;"><a class="close" data-dismiss="alert" href="#">X</a><h4 class="alert-heading">Enviado!</h4></div>');
			});

}
/*
 * ----------------------------- getRestaurantToEdit(id)  -------------------------------------
 * Get Restaurant Data to fill edit form
 * id: STRING
 *
 */
function getRestaurantToEdit(id) {
	$.jStorage.set("lastrestedit", id);

	$.getJSON(
			"get_restaurant.php?restaurantid=" + id,
			function(data) {

				for ( var i = 0; i < data.length; i++) {
					var idrest = data[i].id;
					$('#idrestedit').val(idrest);
					$('#id_push').val(idrest);
					var image = data[i].img;
					if (image != null) {
						$('#imageedit').attr('src', 'uploads/50_' + image);
						$('#completeimagesource').attr('src',
								'uploads/500_' + image);
					} else {
						$('#imageedit').attr('src', 'uploads/pordefecto.png');
						$('#completeimagesource').attr('src',
								'uploads/pordefecto.png');
					}

					var name = data[i].nom;
					$('#nameedit').val(name);
					$('#nombreimagenrestedit').text(name);

					var pos = data[i].codepostal;
					$('#postcodeedit').val(pos);
					var est = data[i].departement;
					$('#stateedit').val(est);
					var cou = data[i].pay;
					$('#countryedit').val(cou);

					var add = data[i].adresse;
					$('#addresseedit').val(add);
					var city = data[i].ville;
					$('#cityedit').val(city);
					var lat = data[i].glat;
					$('#latedit').val(lat);
					var lng = data[i].glng;
					$('#lngedit').val(lng);

					var phone = data[i].tel;
					$('#phoneedit').val(phone);
					var mobile = data[i].tel2;
					$('#mobileedit').val(mobile);

					var addre = data[i].adresse;
					$('#addressedit').val(addre);

					var mail = data[i].email;
					$('#emailedit').val(mail);
					$('#emailedit').attr('href', 'mailto:' + mail);
					var web = data[i].web;
					$('#websiteedit').val(web);
					$('#websiteedit').attr('href', web);

					var intro = data[i].intro;
					if (intro != null) {
						$('#introedit').val(intro);
					}
					var lu = data[i].introlunes;
					if (lu != null) {
						$('#introlunesedit').val(lu);
					}
					var ma = data[i].intromartes;
					if (ma != null) {
						$('#intromartesedit').val(ma);
					}
					var mi = data[i].intromiercoles;
					if (mi != null) {
						$('#intromiercolesedit').val(mi);
					}
					var ju = data[i].introjueves;
					if (ju != null) {
						$('#introjuevesedit').val(ju);
					}
					var vi = data[i].introviernes;
					if (vi != null) {
						$('#introviernesedit').val(vi);
					}
					var sa = data[i].introsabado;
					if (sa != null) {
						$('#introsabadoedit').val(sa);
					}
					var domi = data[i].introdomingo;
					if (domi != null) {
						$('#introdomingoedit').val(domi);
					}

				}
			}).complete(function() {
			/*
 * ----------------------------- Image Error  -------------------------------------
 * 
 */
$("img").error(function () {
  $(this).unbind("error").attr("src", "uploads/50_undefined");
});

	});
}
/*
 * ----------------------------- getRestaurant(id)  -------------------------------------
 * Get Restaurant Data
 * id: STRING
 *
 */
function getRestaurant(id) {
	$
			.getJSON(
					"get_restaurant.php?restaurantid=" + id,
					function(data) {

						for ( var i = 0; i < data.length; i++) {
							var image = data[i].img;

							if (image != null) {
								$('#detailsimage').attr('src',
										'uploads/50_' + image);
								$('#completeimagesource').attr('src',
										'uploads/500_' + image);
							} else {
								$('#detailsimage').attr('src',
										'uploads/pordefecto.png');
								$('#completeimagesource').attr('src',
										'uploads/pordefecto.png');
							}

							var name = data[i].nom;
							$('#detailsname').text(name);
							$('#nombreimagenrest').text(name);
							var phone = data[i].tel;
							$('#detailsphone').text(phone);
							var mobile = data[i].tel2;
							$('#detailsmobile').text(mobile);

							var addre = data[i].adresse;
							$('#detailsaddress').text(addre);

							var mail = data[i].email;
							$('#detailsmail').text(mail);
							$('#detailsmail').attr('href', 'mailto:' + mail);
							var web = data[i].web;
							$('#detailsweb').html(web);
							$('#detailsweb').attr('href', web);

							var intro = data[i].intro;
							if (intro != null) {
								$('#detailsinfo').html(intro);
							}
							var lu = data[i].introlunes;
							if (lu != null) {
								$('#introlunesdetail').html(lu);
							}
							var ma = data[i].intromartes;
							if (ma != null) {
								$('#intromartesdetail').html(ma);
							}
							var mi = data[i].intromiercoles;
							if (mi != null) {
								$('#intromiercolesdetail').html(mi);
							}
							var ju = data[i].introjueves;
							if (ju != null) {
								$('#introjuevesdetail').html(ju);
							}
							var vi = data[i].introviernes;
							if (vi != null) {
								$('#introviernesdetail').html(vi);
							}
							var sa = data[i].introsabado;
							if (sa != null) {
								$('#introsabadodetail').html(sa);
							}
							var domi = data[i].introdomingo;
							if (domi != null) {
								$('#introdomingodetail').html(domi);
							}

		$('#shareme').attr('data-url','http://amimenu.mowaps.com/details.php?detailid='+id);
		
		$('#shareme').sharrre({
  share: {
    twitter: true,
    facebook: true,
    googlePlus: true
  },
  template: '<div class="box"><div class="left">Share</div><div class="middle"><a href="#" class="facebook">f</a><a href="#" class="twitter">t</a><a href="#" class="googleplus">+1</a></div><div class="right">{total}</div></div>',
    enableHover: false,
  enableTracking: true,
  render: function(api, options){
  $(api.element).on('click', '.twitter', function() {
    api.openPopup('twitter');
  });
  $(api.element).on('click', '.facebook', function() {
    api.openPopup('facebook');
  });
  $(api.element).on('click', '.googleplus', function() {
    api.openPopup('googlePlus');
  });
   $(api.element).on('click', '.pinterest', function() {
    api.openPopup('pinterest');
  });
}
});

		
         // $('#sharename').html('Share '+name);
         }
        }).complete(function() {
         //alert("ok")
         
         $('#restaurantDetails').modal('show');
         
        });

/*
 * ----------------------------- Image Error  -------------------------------------
 * 
 */
$("img").error(function () {
  $(this).unbind("error").attr("src", "uploads/50_undefined");
});
}
/*
 * ----------------------------- sendToque()  -------------------------------------
 * Send sms to the restaurant, if restaurant have the flag
 *
 */
function sendToque() {
	var name = $("#name_toque").val();
	var email = $("#email_toque").val();
	var phone = $("#phone_toque").val();
	var phonerest = $("#teltosend").html();
	if (name.length == 0) {
		alert("Name is required!");
		return false;
	}
	if (email.length == 0) {
		alert("Email is required!");
		return false;
	}
	if (phone.length == 0) {
		alert("Phone is required!");
		return false;
	}
	var dataString = 'email=' + email + '&usuario=' + phone + '&name=' + name
			+ '&phonerest=' + phonerest + '&callback=0';
	$.ajax({
		url : "freesms.php",
		data : dataString,
		success : function(data) {
			if (data == 0) {
				$("#oksms").show();
			} else if (data == 1) {
				$("#failsms").show();
			} else {
				$("#tellsms").show();
			}
		}
	});
	return false;

}
/*
 * ----------------------------- removeRestaurant()  -------------------------------------
 * Remove restaurant link to the email and token
 *
 */
function removeRestaurant() {
	var email = $("#email_remove").val();
	var token = $("#token_remove").val();
	if (email.length == 0) {
		alert("Email is required!");
		return false;
	}
	if (token.length == 0) {
		alert("Token is required!");
		return false;
	}
	var dataString = 'email=' + email + '&token=' + token;
	$.ajax({
		type : "POST",
		url : "remove_restaurant.php",
		data : dataString,
		success : function(data) {
			if (data > 0) {
				$('#removemeModal').modal('hide');
				users.clearLayers();
				getRestaurants();
				$('#removeSuccessModal').modal('show');
			} else {
				alert("Incorrect email or token. Please try again.");
			}
		}
	});
	return false;
}
/*
 * ----------------------------- editRestaurant()  -------------------------------------
 * Auth with email and token, then getRestaurantToEdit(id)
 *
 */
function editRestaurant() {
	var email = $("#email_edit").val();
	var token = $("#token_edit").val();
	if (email.length == 0) {
		alert("Email is required!");
		return false;
	}
	if (token.length == 0) {
		alert("Token is required!");
		return false;
	}
	var dataString = 'email=' + email + '&token=' + token;

	$.getJSON("edit_restaurant.php?" + dataString, function(data) {
		for ( var i = 0; i < data.length; i++) {
			console.log(data[i].id);
			if (data.length > 0) {
				getRestaurantToEdit(data[i].id);
				$('#editmeModal').modal('hide');
				$('#editSuccessModal').modal('show');
			} else {
				alert("Incorrect email or token. Please try again.");
			}

		}

	});
	return false;
}
/*
 * ----------------------------- onMapClick(e)  -------------------------------------
 * When user click on map, get location with latitude and longitude. Leaflet api
 * e: Leaflet data
 *
 */
function onMapClick(e) {

	var lat = e.latlng.lat.toFixed(6);
	$('#lat').val(lat);
	$('#lng').val(e.latlng.lng.toFixed(6));
	$('#registerModal').modal('show');
	getLocate(lat, e.latlng.lng.toFixed(6));
}
