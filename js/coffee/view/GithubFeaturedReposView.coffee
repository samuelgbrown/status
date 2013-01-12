class GithubFeaturedReposView extends AppView

	initialize: ->

		@el = new Backbone.View().setElement $('<div/>')
		@render()

	render: ->

		@template = $('#me-summary-template').html()
		@$el.html(_.template @template)