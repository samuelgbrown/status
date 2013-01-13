class GithubTrendingReposView extends AppView

	el: $('#github-trending')

	initialize: ->

		@loadingEl = @$el.find('.loading')[0]
		@render()

	render: ->

		@$el.fadeIn(750)

		@template = $('#github-trending-template').html()
	
	populateRepos: (success_state, res) ->

		if success_state == true
			@hideLoadState()
			@$el.append( _.template @template, {'success' : true, 'data' : res.trending_repos} )
			@animateStoriesIn()
		else
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

	hideLoadState: ->

		$(@loadingEl).hide()

	showLoadState: ->

		$(@loadingEl).show()

