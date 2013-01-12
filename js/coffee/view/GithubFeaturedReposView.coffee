class GithubFeaturedReposView extends AppView

	el: $('#github-featured')

	initialize: ->

		@loadingEl = @$el.find('.loading')[0]
		@render()

	render: ->

		@template = $('#github-featured-template').html()

		#async grab data
		@populateGithubFeatured()
	
	populateGithubFeatured: ->

		$.ajax
			url : 'http://feeds.feedburner.com/thechangelog?format=xml'
			method: 'GET'
			data: null
			success: (res) ->

				#extract data from res
				console.log res
				#@$el.html(_.template @template, {'success' : true, 'data' : res})

			error: (res) ->

				@$el.html( _.template @template, {'success' : false} )

	hideLoadState: ->

		@loadingEl.hide()

	showLoadState: ->

		@loadingEl.show()

