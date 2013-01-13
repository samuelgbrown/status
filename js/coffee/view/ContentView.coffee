class ContentView extends AppView

	el: $('.main')

	initialize: ->

		@header = @$el.find('.main-header')[0]
		@render()

		@hackerNewsTopStories = new HackerNewsTopStoriesView()
		@githubTrendingRepos = new GithubTrendingReposView()
		@githubFeaturedRepos = new GithubFeaturedReposView()
		@charts = new ChartsView()

		#@$el.append @hackerNewsTopStories.$el
		#@$el.append @githubTrendingRepos.$el
		#@$el.append @githubFeaturedRepos.$el

		@getGithubData()

	render: ->

		@$el.fadeIn()
		h1 = $(@header).find('h1')[0]
		$(h1).animate( {'margin-top' : '0'} )


	getGithubData: =>

		@test = $.ajax
			url : 'feeds/github.php'
			method: 'GET'
			data: null
			success: (res) =>

				@githubTrendingRepos.populateRepos true, res
				@githubFeaturedRepos.populateRepos true, res
				@charts.populateCharts(res.languages_data)

			error: (res) =>

				@githubTrendingRepos.populateRepos false, res
				@githubFeaturedRepos.populateRepos false, res