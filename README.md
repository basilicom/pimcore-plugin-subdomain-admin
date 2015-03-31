SubdomainAdmin Pimcore Plugin
================================================
    
Developer info: [Pimcore at basilicom](http://basilicom.de/en/pimcore)

## Synopsis

This Pimcore http://www.pimcore.org plugin disables admin access on main domain and enables it
on another subdomain/domain set in Website Settings. 

## Code Example / Method of Operation

After installing the plugin there is a new website setting available (under Settings > Website) with name
**subdomainAdmin**. Set it to the domain that you want your admin accessible after (e.g. admin.yourdomain.com).

## Motivation

Even though Pimcore comes with great security, it still makes sense to prevent access to admin through the
main domain, especially to any bots, script kiddies, ...

## Installation

Add "basilicom-pimcore/subdomain-admin" as a requirement to the
composer.json in the toplevel directory of your Pimcore installation. Then enable and install the plugin
in Pimcore Extension Manager (under Extras > Extensions)

Example:

    {
        "require": {
            "basilicom-pimcore-plugin/subdomain-admin": ">=1.0.0"
        }
    }


## Contributors

* Igor Benko igor.benko@basilicom.de


## License

* BSD-3-Clause