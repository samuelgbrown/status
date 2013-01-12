class HackerNewsTopStoriesView extends AppView

	el: $('#hacker-news-stories')

	initialize: ->

		@render()

	render: ->

		@template = $('#hacker-news-stories-template').html()
		@$el.html(_.template @template)