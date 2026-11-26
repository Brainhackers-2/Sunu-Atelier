# Cas d'utilisation et Parcours de commande – Sunu Atelier

**Auteur** : Concepteur / analyste  
**Référence** : Cahier des charges v1.3 (sections 2.6, 2.7, 2.8, 2.9, 6, 13.3)

---

## 1. Cas d'utilisation par rôle

```mermaid
flowchart LR
    V[Visiteur] --> UC1((Parcourir catalogue & filtres))
    V --> UC2((Gérer panier & favoris session))
    V --> UC3((Passer commande invité))
    V --> UC4((Suivre colis N° + WhatsApp))

    C[Client connecté] --> UC1
    C --> UC5((Gérer profil & adresses))
    C --> UC6((Télécharger reçu PDF))
    C --> UC7((Laisser un avis sur commande livrée))

    P[Revendeur Pro - V2] --> UC8((Demander compte Pro))
    P --> UC9((Commander au tarif de gros))
    P --> UC10((Télécharger factures & demander devis))

    L[Livreur - V2] --> UC11((Scanner QR /scan/token))
    L --> UC12((Encaisser espèces & valider livraison))

    A[Administrateur] --> UC13((Gérer produits, catégories, stocks))
    A --> UC14((Gérer commandes & statuts))
    A --> UC15((Configurer réglages & contenus du site))
    A --> UC16((Valider comptes Pro & voir rapports))
```

---

## 2. Parcours du tunnel de commande (`/commande`)

```mermaid
flowchart TD
    S1["Étape 1 : Coordonnées<br/>(Civilité, Nom, WhatsApp, Email)"] --> S2["Étape 2 : Livraison<br/>(Sénégal zones 1-4 / Retrait atelier / International)"]
    S2 --> S3["Étape 3 : Paiement simulé<br/>(Carte / Wave / OM / Espèces à la livraison)"]
    S3 --> S4["Étape 4 : Récapitulatif & Validation"]
    S4 --> TX{"Transaction SQL"}
    TX -->|lockForUpdate OK| OK["Compteur SA-AAMM-NNNN<br/>Token 32 hex<br/>Stock décrémenté<br/>order_events créé"]
    TX -->|Stock insuffisant| ERR["Erreur affichée<br/>Rollback transaction"]
    OK --> CONF["Redirection /confirmation/{token}<br/>QR + Reçu PDF + Vidage panier"]
```

---

## 3. Cycle de vie des statuts de commande

```mermaid
stateDiagram-v2
    [*] --> nouvelle : Commande validée
    nouvelle --> confirmee : Validation admin
    confirmee --> en_preparation : Fabrication / emballage
    en_preparation --> livraison_programmee : Livraison locale
    en_preparation --> prete_au_retrait : Retrait boutique
    en_preparation --> expediee : International (N° suivi)
    livraison_programmee --> en_cours_de_livraison : Prise en charge livreur
    en_cours_de_livraison --> livree : Livraison confirmée
    prete_au_retrait --> livree : Remise client
    expediee --> livree : Réception confirmée

    nouvelle --> annulee : Annulation + remise en stock
    confirmee --> annulee : Annulation + remise en stock
```

### Statuts de paiement (V1 simulé)
- `en_attente` : paiement à la livraison / au retrait, ou en attente de validation.
- `paye` : simulation marquée « Succès » (ou espèces encaissées).
- `echoue` : simulation marquée « Échec » (le client peut réessayer ou changer de mode).
