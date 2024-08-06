#!/bin/bash

# Setup Skript für Webengy Projekt - 3592508 S.Brekeller

# Farben zur Lesbarkeit

NC='\033[0m'                                    # No Color

RED='\033[0;31m'                                # Red

BLU='\033[0;34m'                                # Blue

GR='\033[1;32m'                                 # Green

###########################################################################

# System-Update

###########################################################################

printf "${BLU}Ausführen von.: Systemupdates${NC} \n";

printf "${BLU}Es kann sein, das bei diesem Schritt 'Enter' gedrückt werden muss!${NC} \n";

printf "${BLU}Bitte geben Sie, wenn aufgefordert, Ihr Passwort ein.${NC} \n";

sudo add-apt-repository ppa:ondrej/php # Press enter when prompted.

if ! { sudo apt update -y 2>&1 || echo E: update failed; } | grep -q '^[WE]:'; then

    printf "\n${GR}Software-Update-Check erfolgreich${NC} \n"

else

    printf "\n${RED}Fehler bei Software-Update-Check${NC} \n"

fi

###########################################################################

# System-Upgrade

###########################################################################

printf "${BLU}Ausführen von.: Systemupgrades${NC} \n";

if ! { sudo apt upgrade -y 2>&1 || echo E: upgrade failed; } | grep -q '^[WE]:'; then

    printf "\n${GR}Software-Upgrade erfolgreich${NC} \n"

else

    printf "\n${RED}Fehler bei Software-Upgrade${NC} \n"

fi

###########################################################################

# ALLE SOFTWARE DIE INSTALLIERT WERDEN SOLL MUSS HIER REIN GESCHRIEBEN WERDEN!!

software=("git" "unzip" "php8.2" "php8.2-curl" "php8.2-xml" "php8.2-zip" "php8.2-mysql" "php8.2-fpm" "mariadb-server")            

###########################################################################

printf "${BLU}Installation benötigter Software${NC} \n";

for i in ${!software[@]}; do

    if ! { sudo apt install ${software[i]} -y 2>&1 || echo E: ${software[i]} installation failed; } | grep -q '^[WE]:'; then

        printf "\n${GR}${software[i]} wurde erfolgreich Installiert${NC} \n"

    else

        printf "\n${RED}Fehler bei ${software[i]} installation${NC} \n"

    fi

done

###########################################################################

# Composer Install

###########################################################################

printf "${BLU}Installation des PHP-Composers ${NC} \n";

php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');";

php -r "if (hash_file('sha384', 'composer-setup.php') === 'dac665fdc30fdd8ec78b38b9800061b4150413ff2e3b6f88543c636f7cd84f6db9189d43a81e5503cda447da73c7e5b6') { echo '\n${GR}Installer verified${NC} \n'; } else { echo '\n${RED}Installer corrupt${NC} \n'; unlink('composer-setup.php'); } echo PHP_EOL;";

php composer-setup.php;

php -r "unlink('composer-setup.php');";

sudo mv composer.phar /usr/local/bin/composer;

###########################################################################

# Webengy Install

###########################################################################

printf "${BLU}Installation des Webengy-Clockin Projektes via git ${NC} \n";

sudo git clone https://github.com/LemChenju/webengy-clockin.git ./webengy

sudo chown -R $USER ./webengy/;

cd ./webengy/clockin/;

sudo touch composer.lock && sudo chown -R $USER ./composer.lock;

composer update;

composer install;

printf "${BLU}Es kann sein, das hier eine Fehlernachricht gebracht wird - das Projekt sollte trotzdem funktional sein! ${NC} \n";

npm install;

printf "${BLU}Bereitstellung von Entwicklungsumgebung und Laravel App-Key ${NC} \n";

cp localenv .env;

php artisan key:generate;

printf "${BLU}Aufsetzen und Bereitstellung der MariaDB Datenbank ${NC} \n";

sudo service mariadb start;

sudo mysql -u root -e "CREATE DATABASE laravel";

sudo mysql -u root -e "CREATE USER 'laraveluser'@'localhost' IDENTIFIED BY 'webengy';GRANT ALL PRIVILEGES ON *.* TO 'laraveluser'@'localhost';FLUSH PRIVILEGES";

php artisan migrate;

printf "${BLU}Webanwendung wird nun gestartet und ist erreichbar unter${NC} ${GR}127.0.0.1:8000/login${NC} ${BLU}in ihrem Browser erreichbar.${NC} \n";

printf "${BLU}Um die Webanwendung händisch zu starten, wechseln sie zu folgendem Pfad.:${NC}";

pwd;

printf "\n${BLU}und führen folgenden Befehl aus.: ${NC}${GR}php artisan serve${NC}\n";

php artisan serve;
