class HackerNewsTopStoriesView extends AppView

	el: $('#hacker-news-stories')

	initialize: ->

		@loadingEl = @$el.find('.loading')[0]
		@render()

	render: ->

		@template = $('#hacker-news-stories-template').html()

		#async get aggregated stories from backend (ben)
		#then chuck stuff back in da templatez
		@$el.append(_.template @template)

	hideLoadState: ->

		@loadingEl.hide()

	showLoadState: ->

		@loadingEl.show()