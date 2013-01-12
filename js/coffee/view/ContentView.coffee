class ContentView extends AppView

    el: $('.main')

    initialize: ->

    	console.log "content view init"

    	@githubRepos = new GithubFeaturedReposView()
    	@hackerNewsTopStories = new HackerNewsTopStoriesView()

    	@$el.append @hackerNewsTopStories.$el
    	@$el.append @githubRepos.$el