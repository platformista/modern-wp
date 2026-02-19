<img width="1200" height="630" alt="default_social" src="https://github.com/user-attachments/assets/7a12fa09-656f-44d6-a72d-5570067775f4" />


## WordPress on Upsun

Upsun provide an incredibly flexible and powerful PaaS. As they once called it, it is the Idea-to-Cloud PaaS. With a GitHub integration, you can have a preview environment cloned from your a parent environment (the root of the tree is usually the production environment) for each pull request, and a Status Check that runs a build on Upsun out of the new branch, so to verify that the changes do not break anything. Upon merging a PR, the code is deployed straight to the parent environment. And you can change the infrastructure in code, too.

To deploy this repository on Upsun: 

1. make a copy or a fork of it
1. [create a new project](https://console.upsun.com/vinnie-1/create-project) on Upsun (requires an account)
1. select 'Sync your GitHub repository with Upsun'
1. select the repository as per #1

# Modern WordPress development and deployment workflow

This repository hosts the codebase for two sites, both

- are built using [WordPress.org](https://wordpress.org)
- are deployed on [Upsun](https://upsun.com) in [Multi-App setup](https://docs.upsun.com/create-apps/multi-app.html)
- have their codebase managed via [Composer](https://getcomposer.org), thanks to [`johnpbloch/wordpress`](https://github.com/johnpbloch/wordpress) and [WordPress Packagist](https://wpackagist.org)
- have their dependencies automatically upgraded by [Dependabot](https://dependabot.com)
- have their Dependabot PRs automatically merged by [Mergify](https://mergify.io) when builds pass
- have new code deployed to production automatically on every PR merge
- use [Redis](https://redis.io) as back-end caching
- use [Cloudflare](https://www.cloudflare.com) as CDN
- use [GitHub Actions](https://github.com/features/actions) as CI/CD and Cron Scheduler

In addition to the above:

- the `ita` site uses [Elasticsearch](https://www.elastic.co/elasticsearch/)
- the `eng` site uses [Algolia](https://www.algolia.com)

## WordPress

WordPress remains by far the CMS that is easiest to adopt, and that provides a fast time to market in the majority of use cases. There is so much high quality stuff out there for WordPress, be it OSS or Premium, that one can have beautiful sites powered by an easy-to-use CMS up and running in no time.

## Dependabot

Now part of the GitHub family, it provides a free plan for public repositories, and it supports PHP+Composer. You can configure it to decide what kind of upgrades you want to perform on your dependencies, and the bot will issue pull requests periodically, avoiding stale dependencies.

## Mergify

This service, too, provides a free plan for public repositories. You can configure it with a number of conditions that, when met, will trigger an automatic merge of your pull requests.

## Redis

Redis is an open source, in-memory data structure store, that here I use as a back-end cache system via the [Redis Object Cache](https://wordpress.org/plugins/redis-cache/) plugin. It is [easy to adopt with Upsun](https://docs.upsun.com/add-services/redis.html), as it is one of the many containeresed services that you can add to your project.

## Cloudflare

Cloudflare is one of the CDNs best [supported by Upsun](https://docs.upsun.com/domains/cdn/cloudflare.html); it is also one that provides a good free plan.
When you combine that with the awesome plugin [WP Cloudflare Super Page Cache](https://wordpress.org/plugins/wp-cloudflare-page-cache/), choosing Cloudflare for your personal sites becomes really a no-brainer.

## WordPress translation files and Composer

One of the sites is not in English and uses translation files for WordPress core, themes, and plugins for an optimal setup. WordPress Packagist does not currently provide such files, but—–thankfully–—the FOSS community never rests, and [`inpsyde/wp-translation-downloader`](https://github.com/inpsyde/wp-translation-downloader) is a great Composer plugin to manage WordPress translations.

## GitHub Actions

It seemed like the obvious choice. Currently no particular CI/CD task is implemented, as Upsun provide their own built-in CI/CD for builds and deployments. Moreover, I do not require particular testing at present, so I am not using Actions for that either. However, I am using it as Cron Scheduler, to perform regular tasks on my Upsun project.

Although Upsun allow you to do that by defining Cron Jobs [on their own platform](https://docs.upsun.com/create-apps/image-properties/crons.html), I chose to have this functionality decoupled.

## Elasticsearch

[Elasticsearch](https://www.elastic.co/elasticsearch/) is a distributed, RESTful search and analytics engine that centrally stores your data for lightning fast search, fine‑tuned relevancy, and powerful analytics that scale with ease. [Upsun allows a very easy adoption of the service](https://docs.upsun.com/add-services/elasticsearch.html). [ElasticPress](https://github.com/10up/ElasticPress) provides a seamless integration with WordPress.

## Algolia

[Algolia](https://www.algolia.com/doc/faq/why/what-makes-algolia-different-than-elasticsearch-or-solr/) is a commercial service similar to ElasticSearch or Solr, but that claims to be up to 200x faster than Elasticsearch. There is a [free plan](https://www.algolia.com/pricing) that is definitely suitable for small sites. Algolia [no longer maintains an official WordPress plugin](https://www.algolia.com/doc/integration/wordpress/indexing/setting-up-algolia/) but their former official plugin was forked and it is now known as [WP Search with Algolia](https://wordpress.org/plugins/wp-search-with-algolia/). It is actively maintained and works well as far as we have been able to ascertain.

## Rudimentary "distro" support for WordPress

"Distros" or "install profiles" are essentially a way to have your own default installation configuration. Whilst [some softwares have built-in support](https://www.drupal.org/docs/drupal-distributions) for that, WordPress does not. Our rudimentary support for this in WordPress relies on two things: a [bespoke section](https://github.com/vincenzo/modern-wp/commit/e82203270889a769bef1a9d2e72f8cf060e213a9#diff-09041310fc9f9e3a7f23395f30f37f8b89818edcb546ae0d411054a11113e415R51-R66) in the `composer.json` file and [a script](https://github.com/vincenzo/modern-wp/blob/master/ita/scripts/deploy.sh) that uses the information in that section to perform some initial setup. The script is then executed as [part of the `deploy` hook](https://github.com/vincenzo/modern-wp/blob/master/ita/.platform.app.yaml#L20) in Upsun. If you are wondering why we didn't simply use the `scripts.postbuild` section in `composer.json` to run such a script, the reason is that during the `build` phase in Upsun (when `composer` is run) the database service is not yet available.

## Jetpack's identity crisis averted

You may know that Jetpack can suffer from [identity crisis](https://jetpack.com/support/safe-mode/#what-is-an-identity-crisis). This template is configured so that non-production environments on Upsun automatically adopt [Offline Mode](https://jetpack.com/support/development-mode/), thus averting the identity crisis. It would've been preferable to use [Staging Mode](https://jetpack.com/support/staging-sites/) instead of Offline Mode, but it turns out—after a long chat with WordPress support—that just adding `define( 'JETPACK_STAGING_MODE', true );` to `wp-config.php` for a site that already has an active production connection to Jetpack doesn't actually put that site in Safe Mode automatically as described, but still causes the identity crisis.
