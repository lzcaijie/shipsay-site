#!/usr/bin/env bash
set -euo pipefail

# Apply shipsay-site SEO tpl support patch (adds seo_*_tpl roundtrip in config.ini.php)
# Run this at the repo root (shipsay-site).

PATCH_FILE="shipsay-site_seo_tpl_support.patch"

if [ ! -f "$PATCH_FILE" ]; then
  echo "Missing $PATCH_FILE in current directory."
  exit 1
fi

git apply --reject --whitespace=nowarn "$PATCH_FILE"
echo "OK: git apply done. If you see *.rej files, resolve them and re-run."
