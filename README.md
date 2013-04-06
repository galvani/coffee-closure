coffee-closure
==============

Symfony 2 bundle for coffee script support and google closure support

This package is dependent Michael's Bolin's coffee-script compiler


INSTALL
=======

add these lines to composer.json:

`"repositories": {

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
`

register bundle in your AppKernel:

`new Galvani\CoffeeClosureBundle\CoffeeClosureBundle()`

add configuration options to your config:
`coffee_closure:

  bin: "/usr/bin/env coffee"

  closure: "src/Galvani/PocketBoyBundle/Resources/public/js/"

  src: "src/Galvani/PocketBoyBundle/Resources/public/coffee"

  bundles: [ "GalvaniPocketBoyBundle" ]

`
