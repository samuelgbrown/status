class HackerNewsTopStoriesView extends AppView

	el: $('#hacker-news-stories')

	initialize: ->

		@loadingEl = @$el.find('.loading')[0]
		@render()

	render: ->

		@template = $('#hacker-news-stories-template').html()

		#async get aggregated stories from backend (ben)
		#then chuck stuff back in da templatez
		#@$el.append(_.template @template)

		dummyData =
			'stories' : [
				{
					'url' : 'http://www.google.com/'
					'title' : 'Man commits ludircrous act.'
				},
				{
					'url' : 'http://www.google.com/'
					'title' : 'Man foolishly speculates on issue, causes flame war.'
				},
				{
					'url' : 'http://www.google.com/'
					'title' : 'Woman writes some code, men accross the world stunned.'
				}
			]

		@hideLoadState()
		@$el.append(_.template @template, {'success' : true, 'data' : dummyData})

	hideLoadState: ->

		$(@loadingEl).hide()

	showLoadState: ->

		$(@loadingEl).show()