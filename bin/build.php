<?php
declare(strict_types=1);

$root = getcwd();
cout('Stop le conteneur Docker dans le cas ou il serait deja en marche');
trigger('docker-compose down --remove-orphans --volumes');
////////////////////////////////////
cout("Construit le conteneur Docker");
trigger('docker-compose build', true);
////////////////////////////////////
cout("Démarre le conteneur Docker");
trigger('docker-compose up -d', true);
////////////////////////////////////
chdir("$root/app/backend");
////////////////////////////////////
cout("Mise à jour de Composer");
trigger('composer install');
////////////////////////////////////
cout("Création de la base de donnée");
trigger('docker exec -u root -t --privileged my_app_app_symfony php bin/console doctrine:database:create --no-interaction', true);
////////////////////////////////////
cout("Récupération de la structure de la base de donnée");
trigger('docker exec -u root -t --privileged my_app_app_symfony php bin/console doctrine:migrations:migrate --no-interaction', true);
////////////////////////////////////
cout("Injection de fixtures dans la base de donnée");
trigger('docker exec -u root -t --privileged my_app_app_symfony php bin/console doctrine:fixtures:load --no-interaction', true);
////////////////////////////////////
cout("Nettoyage du cache de Symfony");
trigger('php bin/console cache:clear');
////////////////////////////////////
cout("Stop le serveur de Symfony dans le cas où il est déjà démarré");
trigger('symfony server:stop');
////////////////////////////////////
cout("Démarre le serveur de Symfony");
trigger('symfony server:start -d --port=8000 --dir=public', true);
////////////////////////////////////
chdir("../frontend");
cout("Vérifie si 'npm' doit être mis à jour");
trigger('npm install -g npm');
////////////////////////////////////
cout("Installe les dépendances nécessaires pour le fonctionnement du frontend");
trigger('npm install');
////////////////////////////////////
cout("Démarre et compile le frontend");
trigger('npm run start', true);

/**
 * Ecrit un message dans la console
 *
 * @param string $msg Le message a ecrire dans la console
 * @return integer 0 = Pas d'erreur/1 = Erreur lors de l'execution
 */
function cout(string $msg):int
{
    echo "$msg...\n";
    return 0;
}

/**
 * Execute une commande shell
 *
 * @param string $cmd La commande a executer
 * @param boolean $critical Determine si, en cas d'echec le reste du code doit etre interrompu
 * @return integer 0 = Pas d'erreur/1 = Erreur lors de l'execution
 */
function trigger(string $cmd, bool $critical = false):int
{
    try{
        /** @var string|null */
        $trigged = shell_exec($cmd);
        echo $trigged;
        echo "[OK]\n";
        return 0;
    }catch( \Exception $e)
    {
        echo "[KO]\n";
        if( $critical )
        {
            echo $e->getMessage();
            die();
        }
    }
}