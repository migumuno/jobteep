<script>
	
	d3.json("<?php echo $program->getDir(); ?>json/circles.json", function(error, data) {
		var margin = {top: 20, right: 80, bottom: 60, left: 40};
			width = $( window ).width() - 10,
			height = $( window ).height() - 10;
			
		var	graphicWidht = width - margin.right - margin.left,
			graphicHeight = height - margin.top - margin.bottom;
	
		var xScale = d3.scale.linear()
							.domain([0,100])
							.range([0,graphicWidht]);
	
		var yScale = d3.scale.linear()
							.domain([0,100])
							.range([graphicHeight, 0]);
		
		var xAxis = d3.svg.axis()
							.scale(xScale)
							.orient("bottom");
		
		var yAxis = d3.svg.axis()
							.scale(yScale)
							.orient("left");
	
		var svgcontainer = d3.select("body").append("svg")
							.attr("width", width)
							.attr("height", height)
							.attr("transform", "translate(" + margin.left + "," + margin.top + ")");
		
		var axesX = svgcontainer
						 .append("g")
						 	.attr("class", "axis")
	   	 					.attr("transform", "translate(" + margin.left + "," + (graphicHeight + margin.top) + ")")
						    .call(xAxis);
	
	    var axesY = svgcontainer
	    				.append("g")
	    					.attr("class", "axis")
	    					.attr("transform", "translate(" + margin.left + "," + margin.top + ")")
	    					.call(yAxis);
		
		var circles = svgcontainer.selectAll("circle")
							.data(data)
							.enter()
							.append("circle");
	
		var circleAttributes = circles
							.attr("cx", function (d) { return ((graphicWidht / 100) * d.cx) + margin.left; })
							.attr("cy", function (d) { return (graphicHeight - ((graphicHeight/100) * d.cy)) + margin.top; })
							.attr("r", function (d) { return d.r; })
							.style("fill-opacity", 0.6)
							.style("fill", function (d) { return d.color; });
	});
</script>