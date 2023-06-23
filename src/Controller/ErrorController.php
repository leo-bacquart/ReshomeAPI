<?php

namespace Hetic\ReshomeApi\Controller;

// Contrôleur dédié à la gestion des erreurs
class ErrorController extends BaseController
{
    // Le constructeur appelle immédiatement la méthode error
    public function __construct(int $status, string $errorMsg)
    {
        parent::__construct();
        $this->error($status, $errorMsg);
    }

    // Méthode pour afficher la page d'erreur
    public function error(int $status, string $message)
    {
        // Définir le titre de la page
        $title = 'Error';

        // Définir le chemin vers le template du squelette
        $template = $this->templateDir . 'skeleton.php';

        // Définir le chemin vers la vue d'erreur
        $view = $this->viewDir . 'error.php';

        // Débuter la mise en tampon de sortie
        ob_start();

        // Exige la vue (cette vue doit gérer l'affichage du message d'erreur)
        require $view;

        // Finir la mise en tampon et récupérer le contenu
        $content = ob_get_clean();

        // Retourner le contenu du template avec le contenu récupéré
        return require $template;
    }
}
