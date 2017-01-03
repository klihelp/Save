# Save
Save is your personal link saver.

![](http://i.imgur.com/6Xv3Qef.gif)

## Installation
### Requirements

 - PHP, MySQL
 - PHP permission for `exec()`

To install Save, just download the [latest release](http://github.com/krmax44/Save/releases/latest), upload it to your own server and connect to it with your browser. Enter your MySQL information in the installation wizard, set a password and you're ready.
## Features

 - display **screenshot** and **title of website**
 - **open and copy** link
 - **searching** your existing links
 - **bookmark button** to save any website you're currently on
 - slick UI, open source and easy to use

More are coming soon!

##API
### Login
To use any API feature, you must me logged in. To log in via the API, use:

    POST /index.php
    pass=123
### Get links

    GET /api/get.php
Returns JSON array of links, example:

    [
	  {
	    "url": "bootstrap.com",
	    "addded": "1970-01-01 00:00:01",
	    "id": "1",
	    "sort": 0
	  }
	]

### Add link

    GET /api/push.php
    url=example.com
Returns JSON object of just added link, example:

    {
	  "url": "jquery.com",
	  "addded": "1970-01-01 00:00:01",
	  "id": "2"
	}

### Delete link

    GET /api/delete.php
    url=2 (ID of link)
No return value (for now).
##License

View the license [here](https://github.com/krmax44/Save/blob/master/LICENSE).

## Used open source projects

 - Bootstrap *[getbootstrap.com](http://getbootstrap.com)*
 - Bootswatch *[bootswatch.com](http://bootswatch.com)*
 - Animate.css *[github.io](https://daneden.github.io/animate.css/)*
 - jQuery *[jquery.com](jquery.com)*
 - Font Awesome *[fontawesome.io](http://fontawesome.io)*
 - LazyLoad *[GitHub](https://github.com/tuupola/jquery_lazyload/)*
 - HideSeek *[staytuned.gr](http://vdw.staytuned.gr)*
 - PhantomJS *[phantomjs.org](http://phantomjs.org)*
 - Lato Font *[latofonts.com](http://latofonts.com)*
 - loading.io *[loading.io](http://loading.io)*
