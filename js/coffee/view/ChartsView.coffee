class ChartsView extends AppView

	el: $('#charts')

	initialize: ->

		@loadingEl = @$el.find('.loading')[0]
		@template = $('#chart-labels-template').html()

	renderLabels: (data) ->

		@$el.append _.template @template, {'data' : data}
	
	populateCharts: (data) ->

		@hideLoadState()


		dataset = []

		_.each(data, (language) ->
				dataset.push language
			)

		width = 200
		height = 200
		radius = Math.min(width, height) / 2
		color = d3.scale.category20()
		pie = d3.layout.pie().sort(null)
		arc = d3.svg.arc().innerRadius(radius - 60).outerRadius(radius - 20)

		svg = d3.select("#charts").append("svg")
		.attr("width", width)
		.attr("height", height)
		.append("g")
		.attr("transform", "translate(" + width / 2 + "," + height / 2 + ")")

		path = svg.selectAll("path")
		.data(pie(dataset))
		.enter().append("path")
		.attr("fill", (d, i) ->
		  color i
		).attr("d", arc)

		@renderLabels(data)

		@$el.fadeIn(750)

	hideLoadState: ->

		$(@loadingEl).hide()

	showLoadState: ->

		$(@loadingEl).show()

