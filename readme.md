> Portable zabbix php-dev environment.

How-to:
- git clone this
- add `<this-repo>/bin` to your $PATH
- `cp <this-repo>/env.example <this-repo>/.env`, then adjust environment variables
- ensure services are up `zbx,box caddy php72-fpm`
- work on `zbx,dev <branch-basename>`

Checkpoints:
- [x] git worktree workflow
- [x] http/2 + self-signed cert
- [x] php 5.4  & php 7.2 & php 7.4 (subdomain switch)
- [ ] Developer dashboard (overview and links)
- [x] postgresql [x] oracle [x] mariadb [ ] ellastic
- [x] smart git hooks
- [x] multiple zabbix servers
- [x] emails (mailhog-view)
- [ ] jira API integration (issue description)
- [x] debug level logs for all containers
- [x] cloud setup (server proxy agent etc)
- [x] easy tests runner (API, unit, integration and headless selenium)
- [x] dev scripts [x] symfony vardumper (for terminal view also)

## Git hooks:
<!-- {{{OUTPUT-git-hooks -->

<details>
<summary>`pre-commit`</summary>

```
~  Cross platform projects tend to avoid non-ASCII filenames; prevent
~  them from being added to the repository. We exploit the fact that the
~  printable range starts at the space character and ends with tilde.
~ ~
~  Note that the use of brackets around a tr range is ok here, (it's
~  even required, for portability to Solaris 10's /usr/bin/tr), since
~  the square bracket bytes happen to fall in the designated range.
~ ~
~  If there are whitespace errors, print the offending file names and fail.
~  Trailing whitespaces checked only on php js and scss files.
~ ~
```
</details>
<details>
<summary>`prepare-commit-msg`</summary>

```
The purpose of the hook is to edit the message file in place,
and it is not suppressed by the --no-verify option.
~  Creates various messages appropriately:
~  [x] Always ensures and even reassures correct flags!
~  [x] Merge message is formatted.
~  [x] Change-Log change message guessed!
~  [x] Merge with conflicts will list conflicted files.
~  [x] Ticket number taken from folder name!
~  [x] Many more good stuff..
~ ~
```
</details>
<!-- }}} -->

## Scripts:
<!-- {{{OUTPUT-scripts -->

<details>
<summary>`zbx,api`</summary>

```
Wrapped curl and jq to run API calls on current workspace.
Automatically authorizes and logout.
~  Usage (vi): zbx,api [method] [?username] [?password]
~  Usage (pipe): cat patams.json | zbx,api [method] [?username] [?password]
~  Example:
~          echo -n '{"output":["name"]}' | zbx,api host.get
~          # Default authorization: Admin zabbix
~  Example:
~          echo -n '{"output":["name"]}' | zbx,api host.get test-user
~          # Authorization: test-user zabbix
~  Example:
~          echo -n '{"output":["name"]}' | zbx,api host.get test-user passwd
~          # Authorization: test-user passwd
~  Example:
~          zbx,api host.get test-user
~          # Editor instance will be opened to write json params
~ ~
```
</details>
<details>
<summary>`zbx,box`</summary>

```
Usage: zbx,box [FLAG?] [SERVICE?..]
~  Mini orchestrator for a service.
~  If no flag is given - --compose flag is implied.
~  Example:
~          zbx,box
~          # A menu will list all available services, the chosen ones will be rised.
~  Example:
~          zbx,box caddy postgres
~          # This will rise explicitly services.
~  Example:
~          zbx,box --rm oracle
~          # This will remove explicitly listed services.
~  Example:
~          zbx,box --rm
~          # A menu will list all available services, the chosen ones will be removed.
 -C --compose  Lift up the service (will build image if neeed).
 -R --rmi      Remove image (all layers) for this this service.
 -X --restart  Restart service.
 -S --stop     Stop and remove container.
 -B --build    Rebuild image for this service (using cache).
 -Q --devel    For testing -- teardown service -> build semage -> spin up
```
</details>
<details>
<summary>`zbx,check`</summary>

```
Usage: zbx,check <zref?> [FLAGS..]
TODO: WIP!
~  --healthcheck
~      prints overview for workspace if database is build
~   if server is build etc ..
~  --strings string changes
~ ~
 -H --healthcheck  Apply database to postgres service.
```
</details>
<details>
<summary>`zbx,clip`</summary>

```
Usage: zbx,clip <zref?> [FLAGS..]
~  Clips common stuff.
```
</details>
<details>
<summary>`zbx+config`</summary>

```
Usage: zbx+config <zref?> [FLAG?..]
~  Stub all config files based on templates.
~  Example:
~          zbx+config
~          # All options are implied - all configs are rewritten.
~          # Workspace is determined by $PWD.
~  Example:
~          zbx+config ZBX-123-4.0
~          # All options are implied - all configs are rewritten for workspace feature/ZBX-123-4.0
~  Example:
~          zbx+config --vim --server
~          # Apply specific configs only.
~  Example:
~          zbx+config . --vim --server
~          # Apply specific configs only (workspace menu will be opened).
~  Example:
~          zbx+config 4.0 --vim --server
~          # Apply specific configs only for workspace release/4.0
 -V   --vim                Write vimrc only.
 -A   --agentd             Write agentd config only.
 -Sp  --server-postgres    Write server config for postgres.
 -Son --server-oracle-19c  Write server config for oracle 19c.
 -Soo --server-oracle-11g  Write server config for oracle 11g.
 -Ta  --test-api           Write server config api-tests
 -F   --frontend           Write frontend config only.
```
</details>
<details>
<summary>`zbx,db`</summary>

```
Usage: zbx,db <zref?> [FLAGS..]
~  Feeds inital sql's into database (by default named same as $REF). They do need to be build 
~~ first.
~  For this do execute this:
~          zbx,make --database
~  If no shema.sql is found you will be prompted to agree to do this for you.
~  Example:
~          zbx,db -P -S
~          # This will determine ref based on $PWD, then build postgresql database
~          # then add selenium data.sql topping.
~  Example:
~          zbx,db -P -S -N v2
~          # This will determine ref based on $PWD, then build postgresql database
~          # then add selenium data.sql topping and ensure database name has affix v2
~  Example:
~          zbx,db 4.0 -P -S -N v2
~          # Same as above, except release/4.0 is used as $REF
~  Example:
~          zbx,db 4.0 -P -M -S
~          # Note: all swithces are applied in order they are passed to command.
~          # First is created postgres db, then mariadb, both got selenium topping.
~ ~
 -P   --postgres                   Apply database to postgres service.
 -Pq  --postgres-query             Quick open repl (use current database).
 -Aq  --api-db-query               Quick open repl (use current API database, postgres).
 -M   --mariadb                    Apply database to mariadb service.
 -On  --oracle-19c                 Apply database to oracle-19c (new) service.
 -Oo  --oracle-11g                 Apply database to oracle-11g (old) service.
 -Onq --oracle-19c-query           Quick open repl (use current database).
 -Ooq --oracle-11g-query           Quick open repl (use current database).
 -A   --api-json                   Apply api_json data set.
 -API                              Prepare API json database (postgres) It implies --named flag to 
                                   be "-api-json" (db affix)
 -S   --selenium                   Apply selenium data set.
 -N   --named             [a-z\-_] Add affix to database name
```
</details>
<details>
<summary>`zbx,dev`</summary>

```
Usage: zbx,dev <zref?>
~  This wraps for git worktree workflow.
~  Example:
~          zbx,dev
~          # This means I want to jump on review.
~          # All remote is listed to choose for branch.
~          # Chosen branch is added to worktree and upstream is set.
~          # Multiselect is possible (use tab).
~  Example:
~          zbx,dev ZBX-123-4.4
~          # This means I want to start work on fresh feature.
~          # First branch name is validated.
~          # Then you choose what branch it is based on.
~          # Then branch is created and pushed.
~          # Chosen branch is added to worktree and upstream is set.
~  Optionally worktree path is put into z jump-path helper (see .env).
~ ~
 -N  --no-push      Workspace setup as usual - except new brach will NOT be pushed!
 -Nn --no-validate  Workspace setup as usual - for local use only (implies --no-push).
```
</details>
<details>
<summary>`zbx.flags`</summary>

```
Usage #1: zbx.flags [FILE..]
Usage #2: echo [FILE..] | zbx.flags
~  Builds commit flags string based on file list.
~  Accepts list of filenames.
~  Ussually used in commit hook to create correct commit message header.
~  Example:
~          git diff HEAD^..HEAD --stat | zbx.flags
~          # Outputs something like ..F.......
~  Example:
~          zbx.flags <(git diff HEAD^..HEAD --stat)
~          # Outputs something like ..F.......
~  Example:
~          git diff $(git merge-base master HEAD)..HEAD --stat | zbx.flags
~          # Get all the flags touched in this feature.
~  Example:
~          zbx.flags --
~          # Just outputs empty flags ..........
~ ~
```
</details>
<details>
<summary>`zbx,follow`</summary>

```
Usage: zbx,follow [SERVICE?..]
~  Used to combine and tail output of multiple services.
~  By default connects to symphony var dumper (cli).
~  Example:
~          zbx,follow
~          # Determine workspace and attach tty to symphony var dumper.
~          # If ref not determined - script fails.
~  Example:
~          zbx,follow .
~          # Gives multiselect menu to select services and tail them output.
~  Example:
~          zbx,follow php74-fpm-oracle
~          # Attaches to this service and tail (using container name).
~ ~
```
</details>
<details>
<summary>`zbx+generate`</summary>

```
Usage: zbx+generate <zref?>
~  Generates few things.
~  TODO: for now only changelog entry file.
~  TODO: check-strings comment
```
</details>
<details>
<summary>`zbx,jira`</summary>

```
Usage: zbx,jira <zref?> [FLAG?]
~  Shorthand to open jira ticket in browser.
~  Example:
~          zbx,jira .
~          # This will open fuzzy finder to select one of available workspaces,
~          # then constructed jira ticket URL will be opened.
~  Example:
~          zbx,jira
~          # Will attempt to determine workspace based on $PWD, then point browser
~          # jira ticket URL.
~  Example:
~          zbx,jira -n
~          # Do not open browser, only echo derrived URL.
~  Example:
~          zbx,jira DEV-123-4.4 -n
~          # Will echo url for given workspace.
~ ~
 -n  Dry run - only echo URL Ussually used to pipe it into clipboard when needed.
```
</details>
<details>
<summary>`zbx,make`</summary>

```
Usage: zbx,make <zref?> [FLAGS..]
~  Builds various things based on switches.
~  Example:
~          zbx,make . --server --database
~          # This will open fuzzy finder to select one of available workspaces,
~          # then for a chosen workspace server and schema will be built
~          # from within disposable container.
~  Example:
~          zbx,make --server --database
~          # This will attempt to determine workspace based on $PWD,
~          # if workspace is found, server and schema will be built
~          # from within disposable container.
~  Example:
~          zbx,make m --server --database
~          # Same as above, but the workspace will be 'master'.
~  Example:
~          zbx,make 4.0 --server --database
~          # Same as above, but the workspace will be 'release/4.0'.
~  Example:
~          zbx,make DEV-1471-4.0 --server --database
~          # Same as above, but the workspace will be 'feature/DEV-1471-4.0'.
~ ~
 -D  --database         Build DB all schema variants.
 -C  --css              Build styles using sass.
 -L  --locales          Generate locales and translation files (*.mo files).
 -A  --agent            Build agent (emits: zabbix_get and zabbix_sender)
 -P  --proxy            Build proxy (sqlite3 variant) (emits: zabbix_js zabbix_proxy)
 -Sp --server-postgres  Build server (postgres invariant).
 -Sm --server-mysql     Build server (mysql invariant).
 -So --server-oracle    Build server (oracle invariant).
```
</details>
<details>
<summary>`zbx,run`</summary>

```
Usage: zbx,run
~  Orchistrates on-demand services.
~  Example:
~          zbx,run -S
~          # This will spin up server in container for $PWD.
~  Example:
~          zbx,run 4.0 -S
~          # Same as above, but use version 4.0.
~  Example:
~          zbx,run . -S
~          # Same as above, but offer menu with available workspaces.
~ ~
 -S  --server         Run server.
 -So --server-oracle  Run server (oracle)
 -A  --agent          Run agent.
 -Sx --stop-server    Run server.
 -Ax --stop-agent     Stop agent.
 -F  --foreground     Do not detach and block (Ctrl+Z do detach and Ctrl+C to exit). Server logs 
                      are still always sent to containers standard output.
```
</details>
<details>
<summary>`zbx.]sender`</summary>

```
Usage: zbx.]sender
~  To get help from zabbix_sender binary use mid-short flag -help.
```
</details>
<details>
<summary>`zbx.[server`</summary>

```
Usage: zbx.[server
~  Wraps current workspace zabbix_server binary.
~  Example:
~      zbx.[server -R log_level_increase="lld worker"
~      zbx.[server -R log_level_decrease="lld worker"
~      zbx.[server -R log_level_increase="alerter"
~      zbx.[server -R log_level_increase="alert syncer"
~      zbx.[server -R log_level_increase="alert manager"
~      zbx.[server -R log_level_increase="preprocessing worker"
~      zbx.[server -R config_cache_reload
~  To get help from zabbix_server binary use mid-short flag "-help".
~ ~
```
</details>
<details>
<summary>`zbx,string-changes`</summary>

```
Usage: zbx,string-changes <zref?> [FLAGS..]
~  Check translation strings.
~  Script must be run from within git repo.
~  Program usage:
~     check-strings <sha-then> <sha-now>
~  Examples:
~     * Last commit checked.
~     $~ check-strings $(git rev-parse HEAD^) $(git rev-parse HEAD)
~     * Any commit checked, by revrapsing it's parent.
~     $~ check-strings $(git rev-parse <sha>^) <sha
~     
~     * Changes in this branch
~     $~ check-strings $(git rev-parse <sha>^) <sha
~ ~
```
</details>
<details>
<summary>`zbx,test`</summary>

```
Usage: zbx,test <zref?> [phpunit-args..]
~  Runs api tests at given workspace. (uses postgres db only)
~  Tests are executed on a disposable copy of source code and on separated http server.
~  Example:
~      zbx,test -- --filter="*Host*" api_json/ApiJsonTests.php
~      Api tests are run at current workspace.
~  Example:
~      zbx,test m api_json/ApiJsonTests.php
~      All api tests are run at "master" workspace.
~  Before runing this ensure database is in place: zbx,db -API
~  One workspace can be tested at a time.
~ ~
```
</details>
<details>
<summary>`zbx-util-color`</summary>

```
Usage: program 2>&1 | zbx-util-color [ARGS..]
~  Outputs program STDOUT to file in tmp and shows preview only.
 -P --preview-size  If this flag is given STDIN strem will be shown in preview box. Complete output 
                    will be then placed in tmp file. Optionally accepts positive number of lines to 
                    show. Defaults to 5.
 -H --header        Print current stream header. Accepts a string as argument.
 -E --error         Use error mode - as if STDERR was piped into this.
```
</details>
<details>
<summary>`zbx,version`</summary>

```
Usage: zbx,version <zref?> FLAG?
~  Prints various version numbers.
~  Accepts only one switch at most.
~  Example:
~          zbx,version . --major
~          # This will open fuzzy finder to select one of available workspaces,
~          # then will print major version. For example - 5.0
~  Example:
~          zbx,version --api
~          # Will attempt to determine workspace based on $PWD, then print API version.
~  Example:
~          zbx,version
~          # Will attempt to determine workspace based on $PWD, then print full frontend version.
~          # For example: 5.0.0beta1
~  Example:
~          zbx,version 4.0
~          # Will use 'release/4.0' workspace and print full frontend version.
~          # For example: 4.4.7rc1
~ ~
 -D  --db      Fetches db version.
 -E  --export  Fetches export version.
 -A  --api     Fetches api version.
 -M  --major   Fetches major frontend version.
 -Mn --minor   Fetches minor frontend version (default).
```
</details>
<details>
<summary>`zbx,web`</summary>

```
Usage: zbx,web <zref?> [FLAG?]
~  Shorthand to open workspace in browser.
~  Ensures correct subdomain to be used (subdomain swithces php versions).
~  Based on workspace version either php 5.4 or php 7.2 is chosen as minimal supported version.
~  Example:
~          zbx,web .
~          # This will open fuzzy finder to select one of available workspaces,
~          # then constructed wen web URL will be opened.
~  Example:
~          zbx,web
~          # Will attempt to determine workspace based on $PWD, then point browser.
~  Example:
~          zbx,web -n
~          # Do not open browser, only echo derrived URL.
~  Example:
~          zbx,web 4.4 -n
~          # Will echo url for given workspace.
~ ~
 -n  Dry run - only echo URL Ussually used to pipe it into clipboard when needed.
```
</details>
<!-- }}} -->


##### todo quickfix list
<!-- {{{OUTPUT-TODO -->

<details>

```
bin/TODO:1:TODO: create "What have I done utility" to see all commits across workspaces yesterday.
bin/util/zbx-compose-status:17:    # TODO: is log itself remembered to stderr also? (saw it on running container)
bin/util/zbx-container-id:7:# TODO: the `-n 1` flags chooses last created container, might also take all and offer to clear the leak.
bin/zbx,box:143:# TODO: show [x] or [ ] within list, then parse it out
bin/zbx,box:144:# TODO: show preview less (if no flags given only then)
bin/zbx,box:145:# TODO: bind keys to do action and put in fzf multiline header
bin/zbx,box:35:    # TODO: This deletes all stopped containers.
bin/zbx,check:8:### TODO: WIP!
bin/zbx+config:74:# TODO: must accept -D <variant> (defaults to postgres) to configure for oracle or maria
bin/zbx+config:75:# TODO: --mailhog flag would create/update media type with correct port and host for emails via api
bin/zbx,db:150:	# TODO: it creates user surrounded with doublequotes in case of "master"
bin/zbx,db:47:		# TODO : ./ui issue here > 5.0
bin/zbx,db:99:	# TODO: it creates user surrounded with doublequotes in case of "master"
bin/zbx.flags:41:# TODO not all paths are matched, contribution needed.
bin/zbx+generate:4:## TODO: for now only changelog entry file.
bin/zbx+generate:5:## TODO: check-strings comment
bin/zbx.-h:26:# TODO: if line has 4 leading spaces apply sh highlight ansi
bin/zbx,make:29:# TODO: FIX multiple builder images appear (take recent one)
bin/zbx,make:31:# TODO: This deletes all stopped containers.
bin/zbx,run:17:# TODO: This deletes all stopped containers. Crutch!
bin/zbx-script-env:29:# TODO bake these things: webgrind, opcache-gui, into dashboard
bin/zbx-script-env:63:# TODO: use labels.
bin/zbx.]sender:4:# TODO: documentation
bin/zbx-util-color:7:# TODO: implement height bounded scrolling buffer
build/oracle-11g/Dockerfile:2:# TODO: build ^ that with Incorrect parameter "NLS_NCHAR_CHARACTERSET" value: "AL16UTF16" instead "UTF8".
build/oracle-19c/Dockerfile:2:# TODO: build ^ that with Incorrect parameter "NLS_NCHAR_CHARACTERSET" value: "AL16UTF16" instead "UTF8".
build/php54-fpm/Dockerfile:26:# TODO: figure out how to install oci8 in here
git.hooks/post-update:2:# TODO: make it pull info from jira if in feature branch, then notify if info has changed
```
</details>
<!-- }}} -->

<!-- {{{EXEC-bak
tmpfile=$(mktemp)

exec {FD_W}>"$tmpfile"
exec {FD_R}<"$tmpfile"
rm "$tmpfile"

bin-details() {
    bin=$(basename $1)
    printf '<details>\n<summary>`%s`</summary>\n```\n%s\n```\n</details>\n' \
        $bin "$(zbx.-h $1 NO_ANSI)"
}

# Help output of ./bin executables that has that "zbx-script-header" line.
for bin in $(find bin -maxdepth 1 -type f -executable | sort);do
    grep -q '^source zbx-script-header$' $bin \
        && bin-details $bin >&$FD_W
done

cat <&$FD_R
}}} -->


<!--
vi: foldmethod=marker
-->
