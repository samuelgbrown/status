class ContentView extends AppView

    el: $('.main')

    initialize: ->

    	console.log "content view init"

    	@render()

    	@githubRepos = new GithubFeaturedReposView()
    	@hackerNewsTopStories = new HackerNewsTopStoriesView()

    	@$el.append @hackerNewsTopStories.$el
    	@$el.append @githubRepos.$el

    render: ->

    	@$el.fadeIn()