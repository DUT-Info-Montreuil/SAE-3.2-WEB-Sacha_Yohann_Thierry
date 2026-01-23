<?php session_start(); ?>

    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Ma Buvette</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-5 shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">🥤 BuvAsso</a>
            <?php if(isset($_SESSION['login'])): ?>
            <span class="nav-link" style="color: lightgrey; padding: 0.5rem 1rem;">Compte : <?php echo $_SESSION['login']?></span>
            <a class="nav-link btn btn-outline-primary"
               style="color: lightgrey; padding: 0.5rem 0.5rem;"
               href="index.php?module=compte&action=solde&id=<?php echo $_SESSION['id_compte']; ?>">Votre Solde
            </a>

            <?php endif; ?>

            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <?php if(isset($_SESSION['login'])): ?>
                        <li class="nav-item"><a class="nav-link btn btn-outline-info" href="index.php?module=compte&action=historique">Historique</a></li>
                        <li class="nav-item"><a class="nav-link btn btn-outline-info" href="index.php?module=buvette&action=choixbuvette">Buvettes</a></li>
                        <li class="nav-item"><a class="nav-link btn btn-outline-danger btn-sm ms-lg-3" href="index.php?module=default&action=deconnexion">Déconnexion</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="index.php?module=default&action=formConnexion">Connexion</a></li>
                        <li class="nav-item"><a class="nav-link" href="index.php?module=default&action=formInscription">Inscription</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        </div>
    <div class="container mt-5">
<?php

      include_once ("connexion.php");

      $connexion = new Connexion();
      $connexion->initConnexion();

      $module = isset($_GET["module"]) ? $_GET["module"]: "default";

      switch($module){
          case 'buvette' :
              include_once ("Modules/Mod_Buvette/buvette_controleur.php");
              $controleur = new buvette_controleur();
              $controleur->exec();
              break;
          case 'inventaire' :
              include_once ("Modules/Mod_Inventaire/inventaire_controleur.php");
              $controleur = new inventaire_controleur();
              $controleur->exec();
              break;
          case 'compte' :
              include_once ("Modules/Mod_Compte/compte_controleur.php");
              $controleur = new compte_controleur();
              $controleur->exec();
              break;
          case 'gestion' :
              include_once ("Modules/Mod_Gestion/gestion_controleur.php");
              $controleur = new gestion_controleur();
              $controleur->exec();
              break;
          case 'panier':
              include_once ("Modules/Mod_Commande_Panier/cmd_panier_controleur.php");
              $controleur = new cmd_panier_controleur();
              $controleur->exec();
          case 'fournisseur':
              include_once ("Modules/Mod_Fournisseur/fournisseur_controleur.php");
              $controleur = new fournisseur_controleur();
              $controleur->exec();
              break;
          default :
              include_once ("Modules/Mod_Connexion/connexion_controleur.php");
              $controleur = new connexion_controleur();
              $controleur->exec();
              break;
      }
        ?>
    </div>

    <!-- RGPD Modal -->
    <div class="modal fade" id="rgpdModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow">
                <div class="modal-header">
                    <h5 class="modal-title">🍪 Consentement RGPD</h5>
                </div>
                <div class="modal-body">
                    <p>Ce site utilise des cookies et le stockage de session nécessaires à son fonctionnement.</p>
                    <p>Ce site récupère certaines données nécéssaires comme votre nom et votre prénom.</p>
                    <p class="text-muted small mb-0">Sans acceptation, l'accès au site est impossible.</p>
                </div>
                <div class="modal-footer d-flex flex-column gap-2">
                    <button id="rgpdAccept" class="btn btn-success w-100">Accepter</button>
                    <button id="rgpdRefuse" class="btn btn-outline-danger w-100">Refuser</button>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const modalElement = document.getElementById("rgpdModal");
        const modal = new bootstrap.Modal(modalElement, { backdrop: "static", keyboard: false });

        function blockSite() { document.body.style.overflow = "hidden"; }
        function unblockSite() { document.body.style.overflow = "auto"; }

        function showMandatoryPopup() {
            if(document.getElementById("rgpdPopup")) return;
            let popup = document.createElement("div");
            popup.id = "rgpdPopup";
            popup.innerText = "⚠️ Vous devez accepter les cookies pour accéder au site !";
            popup.style.position = "fixed";
            popup.style.top = "20px";
            popup.style.left = "50%";
            popup.style.transform = "translateX(-50%)";
            popup.style.backgroundColor = "#dc3545";
            popup.style.color = "white";
            popup.style.padding = "10px 20px";
            popup.style.borderRadius = "8px";
            popup.style.zIndex = "2000";
            document.body.appendChild(popup);
            setTimeout(() => popup.remove(), 3000);
        }

        // ✅ RGPD : ne passe qu’une seule fois
        const consent = localStorage.getItem("rgpdConsent");
        if (consent !== "accepted" && consent !== "refused") {
            blockSite();
            modal.show();

            document.getElementById("rgpdAccept").addEventListener("click", function () {
                localStorage.setItem("rgpdConsent", "accepted");
                unblockSite();
                modal.hide();
            });

            document.getElementById("rgpdRefuse").addEventListener("click", function () {
                localStorage.setItem("rgpdConsent", "refused");
                showMandatoryPopup();
            });
        }
    });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
