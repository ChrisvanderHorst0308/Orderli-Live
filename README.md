# Orderli-Live

Restaurant website generator en admin dashboard systeem.

## 📁 Project Structuur

```
Orderli-Live/
├── public/          # Publieke PHP bestanden
│   ├── index.php           # Restaurant homepage
│   ├── generator.php       # Webflow concept generator
│   ├── viewer.php          # Concept viewer
│   ├── preset.php          # Preset template
│   ├── admin_login.php     # Admin login pagina
│   └── admin_dashboard.php # Admin dashboard
├── config/          # Configuratie bestanden
│   ├── router_8000.php     # Router voor port 8000
│   ├── router_8001.php    # Router voor port 8001
│   └── google_apps_script.js # Google Apps Script
├── data/            # Data bestanden
│   ├── generated_concept.json
│   ├── pending_projects.json
│   ├── prompts.json
│   └── *.csv               # Project CSV exports
├── scripts/         # Setup en utility scripts
│   ├── auto_setup.sh       # Automatische setup
│   ├── start_servers.sh    # Start servers
│   ├── stop_servers.sh     # Stop servers
│   └── ...
├── docs/            # Documentatie
│   ├── README_GENERATOR.md
│   ├── SETUP.md
│   ├── DEMO.md
│   └── ...
└── logs/            # Server logs
    ├── server_8000.log
    └── server_8001.log
```

## 🚀 Quick Start

### Installatie

```bash
./scripts/auto_setup.sh
```

### Servers Starten

```bash
./scripts/start_servers.sh
```

### Servers Stoppen

```bash
./scripts/stop_servers.sh
```

## 📱 URLs

- **Generator**: http://localhost:8000
- **Viewer**: http://localhost:8001
- **Admin Login**: http://localhost:8000/admin_login.php
- **Admin Dashboard**: http://localhost:8000/admin_dashboard.php

## 📚 Documentatie

Zie de `docs/` folder voor uitgebreide documentatie:
- `SETUP.md` - Setup instructies
- `DEMO.md` - Demo instructies
- `README_GENERATOR.md` - Generator documentatie

## 🔐 Admin Login

- **Username**: chris
- **Password**: Orderli123
