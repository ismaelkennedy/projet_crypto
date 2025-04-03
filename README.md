# Système de Chiffrement et Déchiffrement avec AES-256 et RSA

Ce projet contient deux systèmes de chiffrement et de déchiffrement en PHP utilisant respectivement les algorithmes AES-256 et RSA. L'objectif est de démontrer l'utilisation de ces algorithmes pour sécuriser les messages à l'aide de clés symétriques et asymétriques.

## Fichiers du projet

### 1. **AES-256 - Chiffrement Symétrique (aes.php)**

Ce fichier implémente un système de chiffrement et de déchiffrement utilisant l'algorithme AES-256 en mode CBC (Cipher Block Chaining).

#### Fonctionnalités :
- **Chiffrement** : Permet de chiffrer un message avec une clé symétrique (clé de 32 caractères) et un vecteur d'initialisation (IV) de 16 caractères.
- **Déchiffrement** : Permet de déchiffrer un message chiffré en base64 en utilisant la même clé et IV.

#### Utilisation :
1. **Chiffrement** : Entrez un message, une clé (32 caractères) et un IV (16 caractères) puis cliquez sur "Chiffrer". Le message chiffré sera affiché.
2. **Déchiffrement** : Entrez un message chiffré (en base64), la même clé et IV, puis cliquez sur "Déchiffrer". Le message original sera affiché.

#### Prérequis :
- PHP avec la bibliothèque OpenSSL activée.

---

### 2. **RSA - Chiffrement Asymétrique (rsa.php)**

Ce fichier implémente un système de chiffrement et de déchiffrement utilisant les clés publiques et privées RSA (2048 bits).

#### Fonctionnalités :
- **Chiffrement** : Permet de chiffrer un message en utilisant une clé publique RSA.
- **Déchiffrement** : Permet de déchiffrer un message chiffré en utilisant une clé privée RSA.

#### Utilisation :
1. **Chiffrement** : Le système génère une clé publique et une clé privée RSA (si elles n'existent pas encore). Vous pouvez ensuite chiffrer un message en utilisant la clé publique.
2. **Déchiffrement** : Entrez un message chiffré et déchiffrez-le en utilisant la clé privée.

#### Prérequis :
- PHP avec la bibliothèque OpenSSL activée.

#### Explication du code :
- **Clé Publique et Privée** : Les clés sont générées automatiquement à l'aide de la fonction `openssl_pkey_new()` si elles n'existent pas déjà et sont sauvegardées dans des fichiers (`rsa_public.pem` et `rsa_private.pem`).
- **Chiffrement** : Utilise `openssl_public_encrypt()` pour chiffrer le message.
- **Déchiffrement** : Utilise `openssl_private_decrypt()` pour déchiffrer le message.

---

## Installation

1. Clonez ou téléchargez ce projet sur votre machine.
2. Assurez-vous d'avoir PHP installé avec la bibliothèque OpenSSL activée.
3. Ouvrez les fichiers `aes.php` ou `rsa.php` dans votre serveur local ou environnement de développement.
4. Accédez aux pages via votre navigateur pour tester le chiffrement et le déchiffrement.

## Sécurité

- **AES-256** : Bien que sécurisé, le chiffrement symétrique dépend de la gestion sécurisée des clés. Veillez à protéger la clé et l'IV.
- **RSA** : RSA est plus sécurisé pour la gestion des clés à grande échelle, car il permet de partager la clé publique tout en gardant la clé privée secrète.

## License

Ce projet est sous licence MIT. Vous pouvez l'utiliser et l'adapter à vos besoins, mais la mention de l'auteur d'origine doit être conservée.
