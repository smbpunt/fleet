# Fulll Fleet app

https://github.com/fulll/hiring

> **Note :** Le tag git `0.1.0` contient l'état du projet avant l'intégration de Symfony (partie 2).

## Installation

```bash
make install
```

## Usage

```bash
./fleet create <userId>

./fleet register-vehicle <fleetId> <vehiclePlateNumber>

./fleet localize-vehicle <vehiclePlateNumber> lat lng [alt]
```

### Examples

```bash
# Create a fleet for user 123
./fleet create 123

# Register a vehicle with plate number "ABC-123" to fleet 456
./fleet register-vehicle 123 ABC-123

# Set location for vehicle "ABC-123" at coordinates 48.8566, 2.3522
./fleet localize-vehicle ABC-123 48.8566 2.3522

# Set location with altitude
./fleet localize-vehicle ABC-123 48.8566 2.3522 35
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
