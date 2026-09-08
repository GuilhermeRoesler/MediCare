#!/usr/bin/env bash
set -euo pipefail

cd "$(dirname "$0")"

if docker compose version >/dev/null 2>&1; then
  COMPOSE=(docker compose)
elif docker-compose version >/dev/null 2>&1; then
  COMPOSE=(docker-compose)
else
  echo "[ERRO] Docker não encontrado. Instale o Docker e tente novamente." >&2
  exit 1
fi

cmd="${1:-start}"

ensure_env() {
  if [[ ! -f .env && -f .env.example ]]; then
    cp .env.example .env
    echo "Arquivo .env criado a partir de .env.example"
  fi
}

print_info() {
  cat <<EOF

MediCare rodando em: http://localhost:8080
MySQL no host:       localhost:3307

Login admin:     admin@medicare.com / 123456
Login recepção:  recepcao@medicare.com / 123456

Comandos: ./run.sh stop | restart | logs | status
EOF
}

usage() {
  cat <<EOF
Uso: ./run.sh [comando]

Comandos:
  start    Sobe o projeto com Docker (padrão)
  stop     Para e remove os containers
  restart  Reinicia o ambiente
  logs     Acompanha os logs
  status   Mostra status dos containers
  help     Mostra esta ajuda
EOF
}

case "$cmd" in
  start|up)
    echo "=== MediCare - iniciando ==="
    ensure_env
    "${COMPOSE[@]}" up --build -d
    print_info
    ;;
  stop|down)
    echo "=== MediCare - parando ==="
    "${COMPOSE[@]}" down
    ;;
  restart)
    echo "=== MediCare - reiniciando ==="
    "${COMPOSE[@]}" down
    ensure_env
    "${COMPOSE[@]}" up --build -d
    print_info
    ;;
  logs)
    "${COMPOSE[@]}" logs -f
    ;;
  status)
    "${COMPOSE[@]}" ps
    ;;
  help|-h|--help)
    usage
    ;;
  *)
    echo "Comando desconhecido: $cmd" >&2
    echo
    usage
    exit 1
    ;;
esac
