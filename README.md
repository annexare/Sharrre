# jQuery Sharrre Plugin

Make your sharing widget!
Sharrre is a jQuery plugin that allows you to create nice widgets sharing for Facebook, Twitter, Google Plus (with PHP script) and more.
More information on [Sharrre.com](http://sharrre.com/#demos).

## Usage

```js
	$('#sharrre').sharrre({
		share: {
			googlePlus: true,
			facebook: true,
			twitter: true
		},
		url: 'http://sharrre.com'
	});
```

## Example

```html
	<div id="demo1" data-title="sharrre" data-url="http://sharrre.com"></div>
```

```js
	$(document).ready(function(){
		$('#demo1').sharrre({
			share: {
				googlePlus: true,
				facebook: true,
				twitter: true,
				delicious: true
			},
			buttons: {
				googlePlus: {size: 'tall'},
				facebook: {layout: 'box_count'},
				twitter: {count: 'vertical'},
				delicious: {size: 'tall'}
			},
			hover: function(api, options){
				$(api.element).find('.buttons').show();
			},
			hide: function(api, options){
				$(api.element).find('.buttons').hide();
			}
		});
	});
```

See examples on [official website](http://sharrre.com/#demos).


## Dependencies

* [jQuery 1.7](http://jquery.com/) or later.
* [PHP](http://php.net/) (optionally for some networks).


## Author

* [Julien Hany](http://hany.fr/)
* [Twitter (@_JulienH)](http://twitter.com/_JulienH)
* [Google+](http://plus.google.com/111637545317893682325)

## Modifications

Changes by [Annexare Studio](http://annexare.com/):

* Facebook Page likes count.
* Twitter Followers button and global count.
* [VK](http://vk.com/) support.

```js
	buttons: {
		twitter: {
			username: false // if string, gets number of followers instead of tweets
		},
		vk: {
		  apiId: 0,       // VK.com App ID
		  height: 22,     // button height: 18, 20, 22, 24
		  // pageTitle
		  // pageDescription
		  pageUrl: '',    // if you need to personalize url button
		  // pageImage
		  // text: '',    // 140 chars max
		  type: 'full',   // button, full, mini, vertical
		  verb: 0,        // 0 like, 1 recommend
		  width: 350      // only for type = full
		}
	}
```

