<?php
/*
+ ----------------------------------------------------------------------------+
|     ROOFDOG DONATION TRACKER v2.3
|     By roofdog78
|    
|     Original Donation Tracker plugin by Septor
|     Original Donate Menu plugin by Lolo Irie,Cameron,Barry Keal,Richard Perry
|     Plugin support at http://www.roofdog78.com
|     
|     For the e107 website system visit http://e107.org     
|
|     Released under the terms and conditions of the
|     GNU General Public License (http://gnu.org).
|
+----------------------------------------------------------------------------+

// Traduction francaise by NooTe (2007)
// Version 1.0

*/

//-----------------------------------------------------------------------------------------------------------+

define("LAN_TRACK_00",     "Configurer le compteur de dons Roofdog");
define("LAN_TRACK_01",     "Parametres de PayPal");
define("LAN_TRACK_02",     "Configuration");
define("LAN_TRACK_03",     "Parametres Sauvegardés");
define("LAN_TRACK_04",     "Sauvegarder les Parametres");
define("RD_TRACK_PROTECTION_01",       "Prevention contre le Spam de l'atteinte de l'adresse PayPal");
define("RD_TRACK_PROTECTION_02",       "Repondez");
define("RD_TRACK_PROTECTION_03",       "Envoyer");
define("RD_TRACK_PROTECTION_04",       "Cliquez ci-dessous pour faire un don, s'il vous plait.");
define("LAN_TRACK_05",      "Oui");
define("LAN_TRACK_06",      "Non");
define("LAN_TRACK_07",      "Main");
define("LAN_TRACK_08",      "Optionel");
define("LAN_TRACK_09",      "Extra");
define("LAN_TRACK_10",      "Le Compteur de dons Roofdog installé!");
define("LAN_TRACK_11",      "Le Plugin est maintenant à jour!");
define("LAN_TRACK_12",      "Statut du compteur de dons Roofdog");
define("LAN_TRACK_13",      "ReadMe.txt");
define("LAN_TRACK_14",      "Le Compteur de dons Roofdog a été mis à jour!");
define("LAN_TRACK_15",      "Parametres du Menu");

//-----------------------------------------------------------------------------------------------------------+

define("LAN_TRACK_CONFIG_01", "Titre du Menu :");
define("LAN_TRACK_CONFIG_02", "Devise à faire apparaite dans le Menu :");
define("LAN_TRACK_CONFIG_03", "Couleur de la Progress bar :");
define("LAN_TRACK_CONFIG_04", "Couleur de fond de la la Progress bar :");
define("LAN_TRACK_CONFIG_05", "Couleur des bords de la Progress bar :");
define("LAN_TRACK_CONFIG_06", "Hauteur de la Progress bar :");
define("LAN_TRACK_CONFIG_07", "Montant des dons à atteindre :");
define("LAN_TRACK_CONFIG_08", "Montant des dons atteint :");
define("LAN_TRACK_CONFIG_09", "Date butoire :");
define("LAN_TRACK_CONFIG_10", "Les donateurs du mois :");
define("LAN_TRACK_CONFIG_11", "Le titre du menu de votre compteur.");
define("LAN_TRACK_CONFIG_12", "Sélectionnez le symbole de la devise à faire apparaitre dans le menu.");
define("LAN_TRACK_CONFIG_13", "La couleur de la progress bar pleine. Saisissez les 6 digits en code hex.");
define("LAN_TRACK_CONFIG_14", "La couleur de fond de la progress bar. Saisissez les 6 digits en code hex.");
define("LAN_TRACK_CONFIG_15", "La couleur des bords dela progress bar. Saisissez les 6 digits en code hex.");
define("LAN_TRACK_CONFIG_16", "La hauteur de la progress bar. Saisissez votre valeur en pixels.");
define("LAN_TRACK_CONFIG_17", "Saisissez le montant cible des dons à atteindre.");
define("LAN_TRACK_CONFIG_18", "Montant des dons déjà atteint.");
define("LAN_TRACK_CONFIG_19", "La date à laquelle vous voulez atteindre votre montant cible.");
define("LAN_TRACK_CONFIG_20", "Liste des noms des donateurs.");

//-----------------------------------------------------------------------------------------------------------+

define("LAN_TRACK_PAL_01",  "Texte du Bouton :");
define("LAN_TRACK_PAL_02",  "Texte qui sera situé en dessous de l'image du bouton, devra être formaté en utilisant la syntaxe XHTML comme &lt;br /&gt; pour lee nouvelles lignes.");
define("LAN_TRACK_PAL_03",  "Image du Bouton :");
define("LAN_TRACK_PAL_04",  "Choisissez une image ou téléchargez-la vers '/rdonation_tracker/images/'");
define("LAN_TRACK_PAL_05",  "Choix");
define("LAN_TRACK_PAL_06",  "Popup du Bouton :");
define("LAN_TRACK_PAL_07",  "Texte qui apparaitra lorsque la souris passera au dessus du bouton.");
define("LAN_TRACK_PAL_08",  "Faites un don avec PayPal");
define("LAN_TRACK_PAL_09",  "Adresse PayPal ou Identifiant PayPal Business :");
define("LAN_TRACK_PAL_10",  "Cela devra être un compte PayPal validé.");
define("LAN_TRACK_PAL_11",  "Description du don :");
define("LAN_TRACK_PAL_12",  "Si c'est laissé vide, le donateur vera un champs qui remplira lui même.");
define("LAN_TRACK_PAL_13",  "Devise :");
define("LAN_TRACK_PAL_14",  "Sélectionnez la devise correspondante au montant à payer.");
define("LAN_TRACK_PAL_15",  "Protection contre le Spam :");
define("LAN_TRACK_PAL_16",  "Prevention contre le Spam de l'atteinte de l'adresse PayPal.");

//-----------------------------------------------------------------------------------------------------------+

define("LAN_TRACK_PAL_17",  "Demande d'une adresse postale :");
define("LAN_TRACK_PAL_18",  "Demander aux donateurs de fournir une adresse postale.");
define("LAN_TRACK_PAL_19",  "Demande d'une annotation :");
define("LAN_TRACK_PAL_20",  "Demander aux donateurs de fournir une courte annotation avec le paiement.");
define("LAN_TRACK_PAL_21",  "Libellé de l'annotation :");
define("LAN_TRACK_PAL_22",  "Texte qui apparaitra a coté de l'annotation.");
define("LAN_TRACK_PAL_23",  "URL du paiement reussi");
define("LAN_TRACK_PAL_24",  "Lien de redirection des donateurs apres qu'ils auront fini leur paiement. Le lien par defaut sera :<br /> www.yoursite.com/e107_plugins/rdonation_tracker/thank_you.php");
define("LAN_TRACK_PAL_25",  "URL du paiement annulé");
define("LAN_TRACK_PAL_26",  "Lien de redirection des donateurs lorsque'ils annulerons le paiement. Le lien par defaut sera :<br /> www.yoursite.com/e107_plugins/rdonation_tracker/cancel_return.php");
define("LAN_TRACK_PAL_27",  "Nom du style de la page");
define("LAN_TRACK_PAL_28",  "Connectez vous a PayPal pour creer des styles d'affichage. My Account, Profile, Custom Payment Pages.");

//-----------------------------------------------------------------------------------------------------------+

define("LAN_TRACK_PAL_29",  "Local :");
define("LAN_TRACK_PAL_30",  "Le parametrage par defaut est 'US English', utilisez un code a deux digits de type 'ISO 3166-1' pour le changer.");
define("LAN_TRACK_PAL_31",  "Nombre d'items :");
define("LAN_TRACK_PAL_32",  "Si rempli alors apparait devant le nom de l'item.");
define("LAN_TRACK_PAL_33",  "Personalisation :");
define("LAN_TRACK_PAL_34",  "Non montré au donateur, transmit lors du paiement.");
define("LAN_TRACK_PAL_35",  "Facture :");
define("LAN_TRACK_PAL_36",  "Non montré au donateur, transmit lors du paiement.");
define("LAN_TRACK_PAL_37",  "Montant :");
define("LAN_TRACK_PAL_38",  "Fixe la valeur du montant, laissez à vide pour que le donateur saisisse son propre montant.");
define("LAN_TRACK_PAL_39",  "Taxe :");
define("LAN_TRACK_PAL_40",  "Remplacer le parametrage des taxes selon les profils des donateurs.");

//-----------------------------------------------------------------------------------------------------------+

define("LAN_TRACK_MENU_01",  "Collecté !");
define("LAN_TRACK_MENU_02",  "Obtenu :");
define("LAN_TRACK_MENU_03",  "Reste :");
define("LAN_TRACK_MENU_04",  "Cible :");
define("LAN_TRACK_MENU_05",  "Date de fin :");
define("LAN_TRACK_MENU_06",  "Les Donateurs du Mois :");
define("LAN_TRACK_MENU_07",  "Configuration");

//------------------------------------------------------------------------------------------------------------+

define("LAN_TRACK_ADMENU_01",  "Statut du compteur de dons");
define("LAN_TRACK_ADMENU_02",  "Parametres de PayPal");
define("LAN_TRACK_ADMENU_03",  "Configuration");
define("LAN_TRACK_ADMENU_04",  "Readme.txt");
define("LAN_TRACK_ADMENU_05",  "Parametres du Menu");

//------------------------------------------------------------------------------------------------------------+

define("LAN_TRACK_THANKS_01", "<b>Merci</b>");
define("LAN_TRACK_THANKS_02", "Merci pour votre chouette donation ! Consultez votre boite de messagerie pour la confirmation PayPal. <br />Soyez patient, votre donation sera ajouté au compteur un fois qu'un administrateur aura validé votre don !<br />Merci encore !<br /><br /><a href='".e_BASE."index.php'>Retour à la page d'acceuil</a>");

//-------------------------------------------------------------------------------------------------------------+

define("LAN_TRACK_CANCELLED_01", "<b>Paiement annulé</b>");
define("LAN_TRACK_CANCELLED_02", "Vous avez annulé votre transaction. s'il vous plait : veuillez reconsiderer votre choix de don dans le futur.<br /><br /><a href='".e_BASE."index.php'>Retour à la page d'acceuil.</a>");

?>
