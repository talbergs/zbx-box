#!/bin/bash

# Pass script file through "help extract" and format into markdown detais.
bin-details() {
    bin=$(basename $1)
    printf '<details>\n<summary>`%s`</summary>\n\n```\n%s\n```\n</details>\n' \
        $bin "$(zbx.-h $1 NO_ANSI 100)"
}

update-marker() {
    marker=$1
    tmpfile=$(mktemp)

    # There must be newline soon after marker, because of how it renders.
    echo "" > $tmpfile
    cat /dev/stdin >> $tmpfile

    # Delete between all output markers.
    sed -i "/{{{OUTPUT-$marker/,/}}}/{//!d}" ./readme.md

    # Marker line number.
    line=$(sed -n "/{{{OUTPUT-$marker/=" ./readme.md)

    # Splice tempfile into readme file.
    sed -i "$line r $tmpfile" ./readme.md
    rm $tmpfile
}

todo-details() {
    printf '<details>\n<summary>`%s`</summary>\n\n```\n%s\n```\n</details>\n' \
        'TODO list' "$(grep -n --recursive TODO $1 | sort)"
}

# Scripts: help output of ./bin executables that has that "zbx-script-header" line, others are considered to be WIP.
for bin in $(find bin -maxdepth 1 -type f -executable | sort );do
    grep -q '^source zbx-script-header$' $bin && bin-details $bin
done | update-marker scripts

# Git-hooks:
for bin in $(find git.hooks -type f -executable | sort );do
    bin-details $bin
done | update-marker git-hooks

# Todo list:

dirs=(bin build cfg git.hooks tmpl)
for dir in ${dirs[*]};do
    todo-details $dir
done | update-marker TODO
