Each script supports additional (hidden) flags:
- `-h` or `--help`  Print help.
- `-e` or `--edit`  Open script in editor to edit or view.
- `-c` or `--cat`   Print script contents to view em.
Except for these thee, all options has ucfirst shortflag.

Script naming vs meaning:
- All prefixed 'zbx'
- Dash "-" as a word separator? I.e. zbx-script-header means these are system and helper scripts - mainly used by other scripts.
- Comma "," as a word separator? Like localleader - each script name should start with unique char. So in fish shell `,d<TAB>` becomes `zbx,dev`. Commonly used shorthand scripts.
- Plus "+" as a word separator? Like second localleader also.. User scripts that are not too often used.
- Plus ":" as a word separator? Works like third localleader also.. An "Alias wrapper" for zbx:server zbx:sender .. etc..

Scripts are part of zbx-box - a lot is tied in conventions here - git-worktree structure for example,
but zbx-box/.env file allows few thing to be cofigured.

System dependencies:
- ag (the_silver_searcher) (kinda grep thing)
- nc (openbsd version of netcat)
- fzf (terminal menu)
- notify-send (from libnotify)

Depends on system environment to be set:
- $BROWSER
- $EDITOR
