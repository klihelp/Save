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

    POST /api/index.php
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
Copyright 2017 krmax44

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

## Used open source projects

 - Bootstrap *[getbootstrap.com](http://getbootstrap.com)*
 - Bootswatch *[bootswatch.com](http://bootswatch.com)*
 - jQuery *[jquery.com](jquery.com)*
 - Font Awesome *[fontawesome.io](http://fontawesome.io)*
 - LazyLoad *[GitHub](https://github.com/tuupola/jquery_lazyload/)*
 - HideSeek *[staytuned.gr](http://vdw.staytuned.gr)*
 - PhantomJS *[phantomjs.org](http://phantomjs.org)*
 - Lato Font *[latofonts.com](http://latofonts.com)*
 - loading.io *[loading.io](http://loading.io)*
