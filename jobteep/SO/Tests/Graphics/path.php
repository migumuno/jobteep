<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Practice D3JS</title>
	<script src="http://d3js.org/d3.v3.min.js"></script>
</head>

<body>
	<div id = "ex"></div>

	<script type="text/javascript">

		var width = 1200;
		var height = 600;
		var n = 1; //nº capas
		var m = 10; //samples
		var arr1 = [ .2,.6,.8,.10,.11,.12,.11,.10,.8,.9,.12,.14,16,18,20,22,23,26,30,31,32,33,33,32,31,30,29,28,27,26,25,25,25,26,27,27,28,29,30,35,36,38,40,41,42,43,44,45,45,44,43,42,41,40,39,38,37,36,35,34,33,32,31,30,50,52,54,56,58,60,62,64,66,68,70 ];
		var stack = d3.layout.stack().offset("expand");
		var layers = stack(d3.range(n).map(function () { return genMap(m, arr1); }));
		console.log(layers);

		function genMap (m, a) {
			var arr = [], i;
			for (i = 0; i < m; ++i) arr[i] = a[i];
			console.log(arr);
			return arr.map(function(d, i) { return {x: i, y: d }; });
		}

		var x = d3.scale.linear()
	    .domain([0, m - 1])
	    .range([0, width]);

		var y = d3.scale.linear()
	    .domain([0, d3.max(layers, function(layer) { return d3.max(layer, function(d) { return d.y0 + d.y; }); }) * 10])
	    .range([height, 0]);

		var canvas = d3.select("body")
					.append("svg")
					.attr("width", width)
					.attr("height", height);

		var area = d3.svg.area()
		    .x(function(d) { return x(d.x * 5); })
		    .y0(function(d) { return y(d.y0 * 10); })
		    .y1(function(d) { return y(d.y * 10 + d.y0 * 10); });

		var group = canvas.append("g")
				.attr("transform", "translate(100,100)");

		/*var line = d3.svg.line()
			.x( function (d) { return stack(d.x); } )
			.y( function (d) { return stack(d.y); } );*/

		group.selectAll("path")
			.data(layers)
			.enter()
				.append("path")
				.attr("d", area)
				.attr("fill", "red");
	
	</script>
	
</body>

</html>