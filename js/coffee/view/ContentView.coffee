class ContentView extends AppView

    el: $('.main')

    initialize: ->

    	@header = @$el.find('.main-header')[0]
    	@render()

    	@hackerNewsTopStories = new HackerNewsTopStoriesView()
    	@githubTrendingRepos = new GithubTrendingReposView()
    	@githubFeaturedRepos = new GithubFeaturedReposView()
    	

    	@$el.append @hackerNewsTopStories.$el
    	@$el.append @githubTrendingRepos.$el
    	@$el.append @githubFeaturedRepos.$el

    render: ->

    	@$el.fadeIn()
    	h1 = $(@header).find('h1')[0]
    	$(h1).animate( {'margin-top' : '0'} )
    		