class HackerNewsTopStoriesView extends AppView

	el: $('#hacker-news-stories')

	initialize: ->

		@loadingEl = @$el.find('.loading')[0]
		@render()

	render: ->

		@$el.fadeIn(750)

		@template = $('#hacker-news-stories-template').html()

		#async get aggregated stories from backend (ben)
		#then chuck stuff back in da templatez
		
		$.ajax
			url : 'feeds/articles.php'
			method: 'GET'
			data: null
			success: (res) =>

				@hideLoadState()
				@$el.append( _.template @template, {'success' : true, 'data' : res} )
				@animateStoriesIn()

			error: (res) ->

				@hideLoadState()
				@$el.append( _.template @template, {'success' : false} )

	animateStoriesIn: ->

		stories = @$el.find 'li'
		timeDelay = 0

		_.each stories, (story) ->
			p = $(story).find('p')[0]
			setTimeout( ->
				$(p).animate({opacity:1})
			, timeDelay)
			timeDelay = (timeDelay + 65)

	# For debug
	resetAnimation: ->
		stories = @$el.find 'li'
		_.each stories, (story) ->
			p = $(story).find('p')[0]
			$(p).css({opacity:0})

	hideLoadState: ->

		$(@loadingEl).hide()

	showLoadState: ->

		$(@loadingEl).show()