#!/bin/bash

echo -e "\e[32mConnecting to php-fpm container!"
echo -e "\e[97m"

docker exec -it docs_generator_php_fpm bash
