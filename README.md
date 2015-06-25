SubdomainAdmin Pimcore Plugin
================================================

[![Codacy Badge](https://www.codacy.com/project/badge/12cdbcbe42ac4a35ad3997f1bb4a7c30)](https://www.codacy.com/app/basilicom/pimcore-plugin-subdomain-admin)
[![Dependency Status](https://www.versioneye.com/php/basilicom-pimcore-plugin:subdomain-admin/1.0.0/badge.svg)](https://www.versioneye.com/php/basilicom-pimcore-plugin:subdomain-admin/1.0.0)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/basilicom/pimcore-plugin-subdomain-admin/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/basilicom/pimcore-plugin-subdomain-admin/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/basilicom/pimcore-plugin-subdomain-admin/badges/build.png?b=master)](https://scrutinizer-ci.com/g/basilicom/pimcore-plugin-subdomain-admin/build-status/master)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/59e3ce1e-89b7-4434-8ad2-e38bbac17c16/mini.png)](https://insight.sensiolabs.com/projects/59e3ce1e-89b7-4434-8ad2-e38bbac17c16)

Developer info: [Pimcore at basilicom](http://basilicom.de/en/pimcore)

## Synopsis

This Pimcore http://www.pimcore.org plugin disables admin access on main domain and enables it
on another subdomain/domain set in Website Settings. 

## Code Example / Method of Operation

After installing the plugin there is a new website setting available (under Settings > Website) with name
**subdomainAdmin**. Set it to the domain that you want admin accessible from (e.g. admin.yourdomain.com).

## Motivation

Even though Pimcore comes with great security it still makes sense to prevent access to admin through the
main domain, especially to any bots, script kiddies, ...

## Installation

Add "basilicom-pimcore/subdomain-admin" as a requirement to the composer.json in the toplevel directory of your Pimcore installation. Then enable and install the plugin in Pimcore Extension Manager (under Extras > Extensions)

Example:

    {
        "require": {
            "basilicom-pimcore-plugin/subdomain-admin": ">=1.0.0"
        }
    }

## Troubleshooting

In case you lose access to the admin area due to misconfiguration you have two options:
- disable plugin by editing /website/var/config/extensions.xml (change the value to 0 or delete the whole line)
- remove Website Setting by deleting the corresponding row (subdomainAdmin) in website_settings table in the database

## Contributors

* Igor Benko igor.benko@basilicom.de


## License

* BSD-3-Clause
