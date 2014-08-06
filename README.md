# NeoNexusIoniconsBundle

[![Dependency Status](https://www.versioneye.com/user/projects/53e2a345e0a229fbe8000014/badge.svg?style=flat)](https://www.versioneye.com/user/projects/53e2a345e0a229fbe8000014)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/6dd9b5ce-6ed5-4919-a7a9-b8487969f56f/mini.png)](https://insight.sensiolabs.com/projects/6dd9b5ce-6ed5-4919-a7a9-b8487969f56f)
[![Latest Stable Version](https://poser.pugx.org/neonexus/ionicons-bundle/version.svg)](https://packagist.org/packages/neonexus/ionicons-bundle)
[![Latest Unstable Version](https://poser.pugx.org/neonexus/ionicons-bundle/v/unstable.svg)](//packagist.org/packages/neonexus/ionicons-bundle)
[![Total Downloads](https://poser.pugx.org/neonexus/ionicons-bundle/downloads.svg)](https://packagist.org/packages/neonexus/ionicons-bundle)
[![License](https://poser.pugx.org/neonexus/ionicons-bundle/license.svg)](https://packagist.org/packages/neonexus/ionicons-bundle)

## About

This Bundle makes it easy to integrate [Ionicons](https://github.com/driftyco/ionicons) into your [Symfony2](http://symfony.com/) projects.


## Prerequisites

- Ionicons repo installed somewhere in your project. It is not contained in this bundle. You can use [Composer](http://getcomposer.org), [Bower](http://bower.io) or any other way to install it.


## Installation

1. Add `neonexus/ionicons-bundle` to your `composer.json`:

        {
            ...
            "require": {
                ...
                "neonexus/ionicons-bundle": "~0.4.0",
                "driftyco/ionicons": "1.5.*"
            }
            ...
        }

2. Add `NeoNexusIoniconsBundle` to your `AppKernel.php`:

        ...
        public function registerBundles()
        {
            $bundles = array(
                ...
                new NeoNexus\Bundle\IoniconsBundle\NeoNexusIoniconsBundle()
            );
            ...
        }
        ...

3. Update your dependencies: `composer update`.

NOTICE Installing Ionicons via composer is optional but makes this bundle work out of the box. So I recommend this way.


## Configuration

If you did not install Ionicons via composer you have to configure the path to your installation:

    neonexus_ionicons:
        assets_dir: %kernel.root_dir%/../vendor/driftyco/ionicons


## Customization

If you want to customize Ionicons you have to put a customized variables file somewhere in your project and configure the path. You also have to set the output path.

    neonexus_ionicons:
        filter: less
        customize:
            variables_file:         %kernel.root_dir%/Resources/ionicons/variables.less
            ionicons_output:    %kernel.root_dir%/Resources/less/ionicons.less

If you want to use the `lessphp` or `sass` Assetic filter you have to set the `filter` variable accordingly.

There is a command to generate a customized output file to incorporate your customized variables file:

    app/console neonexus:ionicons:generate


## Usage

### Installation of font files

The bundle provides a command to install the font files to the `web/fonts` directory:

    app/console neonexus:ionicons:install

There is also a `ScriptHandler` for conveniently doing this automatically on each `composer install` or `composer update`:

    ...
    "scripts": {
        "post-install-cmd": [
            ...
            "NeoNexus\\Bundle\\IoniconsBundle\\Composer\\ScriptHandler::install"
        ],
        "post-update-cmd": [
            ...
            "NeoNexus\\Bundle\\IoniconsBundle\\Composer\\ScriptHandler::install"
        ]
    },
    ...

To include the Ionicons css just include `@ionicons_css` in your base template.

    <!DOCTYPE html>
    <html>
        <head>
            <meta charset="UTF-8" />
            <title>{% block title %}Welcome!{% endblock %}</title>
            {% block stylesheets %}
                {% stylesheets
                    '@ionicons_css'
                %}
                    <link rel="stylesheet" href="{{ asset_url }}" media="screen"/>
                {% endstylesheets %}
            {% endblock %}

#### Simple icons (currently broken)

To insert a simple icon add `{{ fa_icon( icon name|options ) }}` into your template.

The parameter can be a `string` containing only the icon name without `fa-` prefix
or `JSON` for more customization. The complete set of options is as follows:

    {
        icon:           name of the icon without 'fa-' prefix
        scale:          [lg|2x|3x|4x|5x|stack-1x|stack-2x],
        fixed-width:    [true|false],
        list-icon:      [true|false],
        border:         [true|false],
        pull:           [left|right],
        spin:           [true|false],
        rotate:         [90|180|270],
        flip:           [horizontal|vertical],
        inverse:        [true|false]
    }

## TODO

- Fix the Twig Extension
- Fix the tests


## License

- This bundle is licensed under the [MIT License](http://opensource.org/licenses/MIT).
- Ionicons is also licensed under the [MIT License](http://opensource.org/licenses/MIT).


## Acknowledgment

- This bundle is forked from, and inspired by the [Font Awesome Bundle](https://github.com/codingfogey/fontawesome-bundle). Thanks [Andreas Ernst](https://github.com/codingfogey) (aka Coding Fogey).