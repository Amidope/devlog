#!/bin/bash

if [ ! -f .env ]; then
  cp .env.example .env
fi

if ! grep -q '^UID=' .env; then
  echo "UID=$(id -u)" >> .env
fi

if ! grep -q '^GID=' .env; then
  echo "GID=$(id -g)" >> .env
fi
