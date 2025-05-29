#!/bin/bash


eval $(ssh-agent)
ssh-add ~/.ssh/id_rsa
export DOCKER_BUILDKIT=1
docker compose build # --no-cache
