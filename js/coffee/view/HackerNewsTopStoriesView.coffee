class HackerNewsTopStoriesView extends AppView

	el: $('#hacker-news-stories')

	initialize: ->

		@loadingEl = @$el.find('.loading')[0]
		@render()

	render: ->

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

			error: (res) ->

				@hideLoadState()
				@$el.html( _.template @template, {'success' : false} )

	hideLoadState: ->

		$(@loadingEl).hide()

	showLoadState: ->

		$(@loadingEl).show()