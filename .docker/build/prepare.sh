#!/bin/bash


eval $(ssh-agent)
ssh-add ~/.ssh/id_rsa
export DOCKER_BUILDKIT=1
docker compose build --no-cache
docker save -o analytics-api.tar docker-registry.grupocednet.com.br/analytics-api:1.0.1-stable
