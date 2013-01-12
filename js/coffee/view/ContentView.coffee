class ContentView extends AppView

    el: $('.main')

    initialize: ->

    	console.log "content view init"

    	@header = @$el.find('.main-header')[0]
    	@render()

    	@githubRepos = new GithubFeaturedReposView()
    	@hackerNewsTopStories = new HackerNewsTopStoriesView()

    	@$el.append @hackerNewsTopStories.$el
    	@$el.append @githubRepos.$el

    render: ->

    	@$el.fadeIn()
    	h1 = $(@header).find('h1')[0]
    	$(h1).animate( {'margin-top' : '0'} )
    		