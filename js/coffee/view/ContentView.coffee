class ContentView extends AppView

    el: $('.main')

    initialize: ->

    	console.log "content view init"

    	@githubRepos = new GithubFeaturedReposView()

    	@$el.append @githubRepos.$el