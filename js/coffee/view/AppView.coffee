class AppView extends Backbone.View

    initialize: ->

    	console.log 'appview init'
    	@child = new ContentView()

    	