class GithubFeaturedReposView extends AppView

	el: $('#github-featured')

	initialize: ->

		@render()

	render: ->

		@template = $('#github-featured-template').html()
		@$el.html(_.template @template)