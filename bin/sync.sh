#!/bin/bash
#rm -rf /Users/$(whoami)/Library/Application\ Support/Unison/*
unison -repeat watch /Users/dimka/Projects/graf-wp/ ssh://root@127.0.0.1//home/cloudpanel/htdocs/graf.dev/ -ui text