coffee-closure
==============

Symfony 2 bundle for coffee script support and google closure support

This package is dependent Michael's Bolin's coffee-script compiler


INSTALL
=======

add these lines to composer.json:


	"repositories": {
                "bolinfest/coffee-script": {

                        "type": "package",
                        "package": {
                                "name": "bolinfest/coffee-script",
                                "version": "1.1",
                                "source": {
                                        "url": "https://github.com/bolinfest/coffee-script.git",
                                        "type": "git",
                                        "reference": "origin/1.1.0"
                                }
                        }
                }
        }


register bundle in your AppKernel:

	new Galvani\CoffeeClosureBundle\CoffeeClosureBundle()

add configuration options to your config:

	coffee_closure:
		bin: "/usr/bin/env coffee"
		closure: "src/Galvani/PocketBoyBundle/Resources/public/js/"
		src: "src/Galvani/PocketBoyBundle/Resources/public/coffee"
		bundles: [ "GalvaniPocketBoyBundle" ]


The bundle will scan Resources/public/coffee and compile all .coffee files in Resources/public/js


Example of application entry point, which needs to be inside the Resources/public/js:
-------------------------------------------------------------------------------------

app.js:

	goog.provide('app.start');

	goog.require('goog.dom');
	goog.require('pocketboy');

	app.start = function() {
	  var pocketboyApplication = new pocketboy();
	  pocketboyApplication.start();
	};

	// Ensures the symbol will be visible after compiler renaming.
	goog.exportSymbol('app.start', app.start);



and in you html simply add:

	<script>goog.require('app.start'); app.start();</script>


twig example using assetic:

	<script src="{{ asset('bundles/galvanipocketboy/js/closure-library/closure/goog/base.js') }}"></script>
	<script src="{{ asset('bundles/galvanipocketboy/js/deps.js') }}"></script>
	<script src="{{ asset('bundles/galvanipocketboy/js/app.js') }}"></script>


