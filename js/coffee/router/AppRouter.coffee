class AppRouter extends Backbone.Router

    id : null

    routes:

        "*other" : "defaultRoute"

    start: ->
        Backbone.history.start({pushState:true})

    # Default

    defaultRoute: ->
        new AppView()