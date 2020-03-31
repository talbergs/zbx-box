#!/bin/bash

tmpfile=$(mktemp)

# delete-outputs
sed -i '/{{{OUTPUT-scripts/,/}}}/{//!d}' ./readme.md
line=$(sed -n '/{{{OUTPUT-scripts/=' ./readme.md)

bin-details() {
    bin=$(basename $1)
    printf '<details>\n<summary>`%s`</summary>\n```\n%s\n```\n</details>\n' \
        $bin "$(zbx.-h $1 NO_ANSI)"
}

# Help output of ./bin executables that has that "zbx-script-header" line.
for bin in $(find bin -maxdepth 1 -type f -executable | sort);do
    grep -q '^source zbx-script-header$' $bin \
        && bin-details $bin >> $tmpfile
done

sed -i "$line r $tmpfile" ./readme.md
