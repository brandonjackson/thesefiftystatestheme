jQuery(".state").each(function(index){
	state = jQuery(this).attr("rel");
	if(state=='?'){
		return;
	}
	id = jQuery(this).attr("id");
	console.log('state:'+state);
	console.log('id:'+id);
	var RS = Raphael(id, 45, 45);
	
	attr = {
		"fill": "#DDD",
		"stroke": "#fff",
		"stroke-opacity": "1",
		"stroke-linejoin": "round",
		"stroke-miterlimit": "4",
		"stroke-width": "0.75",
		"stroke-dasharray": "none"
	};
	rotations = {
		'al':5,
		'az':-7,
		'ca':-10,
		'co':-6,
		'ct':13,
		'ga':3,
		'ma':12,
		'ny':12,
		'pa':10,
		'sd':-2,
		'tn':4,
		'va':5,
		'wi':2,
		'wy':-5
	};
	scales = {
		'ak':1.4,
		'ma':1.1,
		'ny':1.05
	}
	
	path = RS.path(usMap[state].path).attr(attr);
	r = rotations[state] ? rotations[state] : 0;
	s = scales[state] ? scales[state] : 1;
	transformation = 'r'+r+',s'+s;
	
	box = path.getBBox();
	path.transform(transformation);
	RS.setViewBox(box.x,box.y,box.width,box.height, true);
});
