@echo off
setlocal EnableExtensions
cd /d "%~dp0"

set "COMPOSE=docker compose"
docker compose version >nul 2>&1
if errorlevel 1 (
    docker-compose version >nul 2>&1
    if errorlevel 1 (
        echo [ERRO] Docker nao encontrado. Instale o Docker Desktop e tente novamente.
        exit /b 1
    )
    set "COMPOSE=docker-compose"
)

if /i "%~1"=="" goto :start
if /i "%~1"=="start" goto :start
if /i "%~1"=="up" goto :start
if /i "%~1"=="stop" goto :stop
if /i "%~1"=="down" goto :stop
if /i "%~1"=="restart" goto :restart
if /i "%~1"=="logs" goto :logs
if /i "%~1"=="status" goto :status
if /i "%~1"=="help" goto :help
if /i "%~1"=="-h" goto :help
if /i "%~1"=="--help" goto :help

echo Comando desconhecido: %~1
echo.
goto :help

:start
echo === MediCare - iniciando ===
if not exist ".env" (
    if exist ".env.example" (
        copy /Y ".env.example" ".env" >nul
        echo Arquivo .env criado a partir de .env.example
    )
)

%COMPOSE% up --build -d
if errorlevel 1 (
    echo [ERRO] Falha ao subir os containers.
    exit /b 1
)

echo.
echo MediCare rodando em: http://localhost:8080
echo MySQL no host:       localhost:3307
echo.
echo Login admin:     admin@medicare.com / 123456
echo Login recepcao:  recepcao@medicare.com / 123456
echo.
echo Comandos: run.bat stop ^| restart ^| logs ^| status
exit /b 0

:stop
echo === MediCare - parando ===
%COMPOSE% down
exit /b %ERRORLEVEL%

:restart
echo === MediCare - reiniciando ===
%COMPOSE% down
%COMPOSE% up --build -d
exit /b %ERRORLEVEL%

:logs
%COMPOSE% logs -f
exit /b %ERRORLEVEL%

:status
%COMPOSE% ps
exit /b %ERRORLEVEL%

:help
echo Uso: run.bat [comando]
echo.
echo Comandos:
echo   start    Sobe o projeto com Docker ^(padrao^)
echo   stop     Para e remove os containers
echo   restart  Reinicia o ambiente
echo   logs     Acompanha os logs
echo   status   Mostra status dos containers
echo   help     Mostra esta ajuda
exit /b 0
