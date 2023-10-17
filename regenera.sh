#!/bin/bash

git fetch
git branch --delete backup
git branch backup
git reset --hard origin/master

sed -i "s/'rsaiz2@xtec.cat'/\$this->dades/g" app/Http/Controllers/MailController.php
