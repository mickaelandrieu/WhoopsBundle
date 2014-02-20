WhoopsBundle
============

Symfony 2 implementation of debugguer library Whoops

![](http://i.imgur.com/7F8aIj6.png)
[![Build Status](https://travis-ci.org/mickaelandrieu/WhoopsBundle.svg?branch=1.0)](https://travis-ci.org/mickaelandrieu/WhoopsBundle)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/08dfbabf-d1e3-4d0d-abef-0fe0668a0218/small.png)](https://insight.sensiolabs.com/projects/08dfbabf-d1e3-4d0d-abef-0fe0668a0218)


INSTALLATION
-----------

As usual, there is few steps required to install this bundle:

1. Add this bundle to your project as a composer dependency:

```javascript
    // composer.json
    {
        // ...
        require-dev: {
            // ...
            "mickaelandrieu/whoops-bundle": "dev-master"
        }
    }
```

2. Add this bundle to your application kernel:

```php
    // app/AppKernel.php
    public function registerBundles()
    {
        // ...
        if (in_array($this->getEnvironment(), array('dev'))) {
            $bundles[] = new Am\WhoopsBundle\AmWhoopsBundle();
        }

        return $bundles;
    }
```
That's all ! Enjoy the new theme we've created for Symfony 2.

Note: this bundle is compatible with [GnugatWizardBunde](https://github.com/gnugat/GnugatWizardBundle)

3. Configure Path to the resources for theming (non required)

You can as well create your own theme, by create a folder in your application
with the files you want to override: you will essentialy override the css styles
and need to create a file ```whoops.base.css``` that you need to locate in an css folder.
For now, ```Whoops``` is still a WIP and you have to follow this to make your own theme.

You can override as well all the files loaded by ```Whoops``` library for the ```PrettyPageHandler```
used here:

* pretty-page.css
* pretty-template.php

Then, configure the bundle in your ```config.yml``` file:

    am_whoops:
        resources_path: "%kernel.root_dir%/../web/bundles/amwhoops"

4. How to contribute

This bundle is now fully unit-tested, I will accept only PR with tests
related to this roadmap:

* Allow user to create his own Handlers
* Update whoops library to 1.1 when tagged to stable
* Create symfony-whoops-edition to have a demo website
* The web debug toolbar should be available when an exception is thrown
