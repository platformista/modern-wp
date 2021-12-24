<p align="center"><a href="https://console.platform.sh/projects/create-project/?template=https://github.com/vincenzo/modern-wp/blob/master/template-definition.yaml&utm_campaign=deploy_on_platform?utm_medium=button&utm_source=affiliate_links&utm_content=https://github.com/vincenzo/modern-wp/blob/master/template-definition.yaml" target="_blank" title="Deploy with Platform.sh"><img src="https://platform.sh/images/deploy/deploy-button-lg-blue.svg"></a></p>

# Modern WordPress development and deployment workflow

This repository hosts the codebase for two sites, both

- are built using [WordPress.org](https://wordpress.org)
- are deployed on [Platform.sh](https://platform.sh) in [Multi-App setup](https://docs.platform.sh/configuration/app/multi-app.html)
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

## Platform.sh

Platform.sh provide an incredibly flexible and powerful PaaS. As they like to call it, it is the Idea-to-Cloud PaaS. With a GitHub integration, you can have a child environment cloned from your a parent environment (the root of the tree is usually the production environment) for each pull request, and a Status Check that runs a build on Platform.sh out of the new branch, so to verify that the changes do not break anything. Upon merging a PR, the code is deployed straight to the parent environment.

Feel free to poke around the Platform.sh configuration files in this repo to see how the sites were set up with a multi-container deployment comprising of various services.

## Dependabot

Now part of the GitHub family, it provides a free plan for public repositories, and it supports PHP+Composer. You can configure it to decide what kind of upgrades you want to perform on your dependencies, and the bot will issue pull requests periodically, avoiding stale dependencies.

## Mergify

This service, too, provides a free plan for public repositories. You can configure it with a number of conditions that, when met, will trigger an automatic merge of your pull requests.

## Redis

Redis is an open source, in-memory data structure store, that here I use as a back-end cache system via the [Redis Object Cache](https://wordpress.org/plugins/redis-cache/) plugin. It is [easy to adopt with Platform.sh](https://docs.platform.sh/configuration/services/redis.html), as it is one of the many containeresed services that you can add to your project.

## Cloudflare

Cloudflare is one of the CDNs best [supported by Platform.sh](https://docs.platform.sh/domains/cdn.html); it is also one that provides a good free plan.
When you combine that with the awesome plugin [WP Cloudflare Super Page Cache](https://wordpress.org/plugins/wp-cloudflare-page-cache/), choosing Cloudflare for your personal sites becomes really a no-brainer.

## WordPress translation files and Composer

One of the sites is not in English and uses translation files for WordPress core, themes, and plugins for an optimal setup. WordPress Packagist does not currently provide such files, but—–thankfully–—the OSS community never rests, and [`inpsyde/wp-translation-downloader`](https://github.com/inpsyde/wp-translation-downloader) is a great Composer plugin to manage WordPress translations.

## GitHub Actions

It seemed like the obvious choice. Currently no particular CI/CD task is implemented, as Platform.sh provide their own built-in CI/CD for builds and deployments. Moreover, I do not require particular testing at present, so I am not using Actions for that either. However, I am using it as Cron Scheduler, to perform regular tasks on my Platform.sh project.

Although Platform.sh allow you to do that by defining Cron Jobs [on their own platform](https://docs.platform.sh/configuration/app/cron.html), I chose to have this functionality decoupled from Platform.sh.

## Elasticsearch

[Elasticsearch](https://www.elastic.co/elasticsearch/) is a distributed, RESTful search and analytics engine that centrally stores your data for lightning fast search, fine‑tuned relevancy, and powerful analytics that scale with ease. [Platform.sh allows a very easy adoption of the service](https://docs.platform.sh/configuration/services/elasticsearch.html). [ElasticPress](https://github.com/10up/ElasticPress) provides a seamless integration with WordPress.

## Algolia

[Algolia](https://www.algolia.com/doc/faq/why/what-makes-algolia-different-than-elasticsearch-or-solr/) is a commercial service similar to ElasticSearch or Solr, but that claims to be up to 200x faster than Elasticsearch. There is a [free plan](https://www.algolia.com/pricing) that is definitely suitable for small sites. Algolia [no longer maintains an official WordPress plugin](https://www.algolia.com/doc/integration/wordpress/indexing/setting-up-algolia/) but their former official plugin was forked and it is now known as [WP Search with Algolia](https://wordpress.org/plugins/wp-search-with-algolia/). It is actively maintained and works well as far as we have been able to ascertain.

## Rudimentary "distro" support for WordPress

"Distros" or "install profiles" are essentially a way to have your own default installation configuration. Whilst [some softwares have built-in support](https://www.drupal.org/docs/drupal-distributions) for that, WordPress does not. Our rudimentary support for this in WordPress relies on two things: a [bespoke section](https://github.com/vincenzo/modern-wp/commit/e82203270889a769bef1a9d2e72f8cf060e213a9#diff-09041310fc9f9e3a7f23395f30f37f8b89818edcb546ae0d411054a11113e415R51-R66) in the `composer.json` file and [a script](https://github.com/vincenzo/modern-wp/blob/master/ita/scripts/deploy.sh) that uses the information in that section to perform some initial setup. The script is then executed as [part of the `deploy` hook](https://github.com/vincenzo/modern-wp/blob/master/ita/.platform.app.yaml#L20) in Platform.sh. If you are wondering why we didn't simply use the `scripts.postbuild` section in `composer.json` to run such a script, the reason is that during the `build` phase in Platform.sh (when `composer` is run) the database service is not yet available.
