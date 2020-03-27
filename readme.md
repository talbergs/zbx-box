> Portable zabbix php-dev environment.

How-to:
- git clone this
- add `<this-repo>/bin` to your $PATH
- `cp <this-repo>/env.example <this-repo>/.env`, then adjust environment variables
- ensure services are up `zbx,box -U`
- work on `zbx,dev <branch-basename>`

Checkpoints:
- [ ] Developer dashboard (overview and links)
- [x] containerized (all you need is a docker, terminal and browser)
- [x] postgresql
- [ ] oracle
- [ ] mariadb
- [x] git hooks
- [x] multiple zabbix servers (same port different TLD)
- [x] self signed ssl
- [x] php 5.4
- [x] php 7.4
- [ ] jira API integration (issue description)
- [x] emails (mailhog-view)
- [x] http/2
- [ ] traefik (rewrite /frontends/php and more ..)
- [x] xdebug (also used as profiler) + ui tool (php 5.4 only)
- [x] symfony vardumper (for terminal view also)
- [x] dev scripts
- [ ] debug level logs for all containers
- [x] opcache + opcache-gui
- [x] git worktree workflow
- [ ] cloud setup (server proxy agent etc)
- [ ] easy tests runner (API, unit, integration and headless selenium)
- [ ] ellastic search stack
- [ ] php profiler XProf + https://github.com/badoo/liveprof-ui/
- [x] i18n (all zabbix locales)
- [ ] clean abandoned data (databases etc) for deleted <Refs> (or any)
