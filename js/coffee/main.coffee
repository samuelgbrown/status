window.app =
    router : null
    status : null
    view : null

$(document).ready () ->
	
    # init router
    app.router = new AppRouter()
    app.router.start()