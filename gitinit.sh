#!/bin/sh
echo "# store_backend" >> README.md
git init
git add README.md
git add *
git commit -m "first commit"
git branch -M main
git remote add origin https://github.com/atmobi998/store_backend.git
git push -u origin main

