# Automated LEMP & Observability Stack
### Day 1: Network Bridge
- Established Ed25519 asymmetric SSH key pair authentication between macOS control node and Ubuntu target server (`172.27.16.20`).
- Enabled and verified OpenSSH daemon persistence across reboots.
- Tested and confirmed passwordless remote shell execution.
### Day 2: Base Compose
- Defined multi-container orchestration with `mariadb:10.11` and `php:8.2-fpm-alpine`.
- Implemented persistent named volumes (`db_data`) for MariaDB data persistence across container lifecycles.
- Configured isolated internal bridge network (`internal_net`) preventing direct public exposure of backend components.
- Decoupled sensitive database credentials using `.env` variable interpolation; added `.env.example` template for repo documentation.
- Resolved YAML structure error: corrected indentation aligning root-level `volumes:` and `networks:` keys outside the `services:` block.
