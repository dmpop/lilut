#!/usr/bin/env bash

container=$(buildah from ubuntu:20.04)
buildah run $container apt update
buildah run $container apt install -y php-cli php-imagick
buildah copy $container . /usr/src/lilut/
buildah config --workingdir /usr/src/lilut $container
buildah config --port 8000 $container
buildah config --cmd "php -S 0.0.0.0:8000" $container
buildah config --label description="Lilut container image" $container
buildah config --label maintainer="dmpop@linux.com" $container
buildah config --label version="0.1" $container
buildah commit --squash $container lilut
buildah rm $container
