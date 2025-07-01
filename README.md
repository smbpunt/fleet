# Fulll Fleet app

https://github.com/fulll/hiring

> **Note :** Le tag git `0.1.0` contient l'état du projet avant l'intégration de Symfony (partie 2).

## Installation

```bash
make install
```

## Outils utilisés

- PHP CS Fixer pour le formatage du code
- PHPStan et PHPMD pour l'analyse de code, bugs, complexité, etc.
- PHPUnit pour les tests unitaires (à implémenter...)
- Behat
- Symfony (à partir de la partie 2)
    - Application console
    - Doctrine ORM avec mapping XML pour la persistance des données
    - Messenger pour l'implémentation CQRS

## Tests

```bash
make tests
```

## Code check

```bash
make code-check
```

## CI (Code Check + Tests)

```bash
make ci
```

## Pistes d'amélioration

- [ ] Gérer les contraintes d'unicité
- [ ] Implémenter les agrégats (Aggregate Root)
- [ ] Tests unitaires
- [ ] Tests Behat sur base de données de test
