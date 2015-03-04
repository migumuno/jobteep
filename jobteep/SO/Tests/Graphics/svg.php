<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Practice D3JS</title>
	<script src="http://d3js.org/d3.v3.min.js"></script>
</head>

<body>
	
	<script type="text/javascript">

		var width = 500;
		var height = 500;
		var data = [

		      {date: 0, popularidad: 10},
		      {date: 100, popularidad: 30},
		      {date: 200, popularidad: 30},
		      {date: 300, popularidad: 80},
		      {date: 400, popularidad: 50},
		      {date: 500, popularidad: 110}
					
		];

		var canvas = d3.select("body")
			.append("svg")
			.attr("width", width)
			.attr("height", height);

		var area = d3.svg.area()
				.x(function (d) { return d.date; })
				.y0(0)
				.y(function (d) { return d.popularidad; });

		canvas.selectAll("path")
				.data([data])
				.enter()
				.append("path")
				.attr("d", area)
				.attr("fill", "red");
		
	</script>
	
</body>

</html>