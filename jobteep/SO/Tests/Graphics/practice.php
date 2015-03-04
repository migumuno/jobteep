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

		var width = 500;
		var height = 500;
		var data = [10, 20, 30, 40, 50, 60, 70, 80, 90, 100];
		var maxOfData = Math.max.apply(null, data);

		var widthScale = d3.scale.linear()
						.domain([ 0, maxOfData ])
						.range([ 0, width ]);

		var colorScale = d3.scale.linear()
						.domain([ 0, maxOfData ])
						.range([ "white", "red" ]);
	
		var canvas = d3.select("body")
					.append("svg")
					.attr("width", width)
					.attr("height", height);

		var bars = canvas.selectAll("rect")
					.data(data)
					.enter()
						.append("rect")
						.attr("width", function (d) { return widthScale(d); })
						.attr("height", 40)
						.attr("fill", function (d) { return colorScale(d); })
						.attr("y", function (d, i) { return i * 50; } );
					
	
	</script>
	
</body>

</html>