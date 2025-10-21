# Applicazione AutoSalone

Un'applicazione web completa per la gestione di un autosalone, costruita con Laravel 11, Livewire 3 e Tailwind CSS.

## Caratteristiche Principali

### Area Pubblica
- **Homepage Accattivante**: Pagina di benvenuto con veicoli in evidenza
- **Catalogo Veicoli**: Lista completa con filtri avanzati
- **Ricerca Avanzata**: Filtra per marca, modello, anno, prezzo, condizione (nuovo/usato)
- **Design Responsive**: Ottimizzato per mobile, tablet e desktop
- **Esperienza SPA**: Navigazione fluida con transizioni animate usando Livewire Wire:navigate

### Pannello Amministrativo
- **Gestione Veicoli**: Crea, modifica, elimina veicoli
- **Upload Immagini**: Carica multiple immagini per ogni veicolo
- **Attivazione/Disattivazione**: Controlla la visibilità dei veicoli
- **Storicizzazione**: Traccia tutte le modifiche ai veicoli
- **Dashboard Intuitiva**: Interfaccia amministrativa user-friendly

### Database
- **Marche**: 20 marche automobilistiche pre-popolate
- **Modelli**: Oltre 100 modelli associati alle marche
- **Veicoli**: Centinaia di veicoli di esempio generati automaticamente
- **Storicizzazione**: Registro completo di tutte le modifiche

## Struttura del Database

### Tabelle Principali
1. **brands** - Marche automobilistiche (Audi, BMW, Mercedes, ecc.)
2. **car_models** - Modelli di auto associati alle marche
3. **vehicles** - Veicoli in vendita con tutti i dettagli
4. **vehicle_histories** - Storico delle modifiche ai veicoli

## Installazione e Configurazione

### Prerequisiti
- PHP 8.2+
- Composer
- Node.js & NPM
- MySQL/PostgreSQL

### Setup

1. **Installa le dipendenze PHP**
```bash
composer install
```

2. **Installa le dipendenze JavaScript**
```bash
npm install
```

3. **Configura il database**
- Crea un database MySQL
- Configura `.env` con le credenziali del database

4. **Esegui le migrazioni e seeders**
```bash
php artisan migrate:fresh --seed
```
Questo creerà:
- Tutte le tabelle necessarie
- 20 marche automobilistiche
- Oltre 100 modelli di auto
- Centinaia di veicoli di esempio
- Un utente admin (admin@autosalone.com)

5. **Compila gli asset**
```bash
npm run dev
```

6. **Avvia il server**
```bash
php artisan serve
```

## Accesso all'Applicazione

### Area Pubblica
- **Homepage**: http://localhost:8000
- **Catalogo Veicoli**: http://localhost:8000/vehicles

### Pannello Admin
- **URL**: http://localhost:8000/admin/vehicles
- **Login**: http://localhost:8000/login
- **Credenziali default**: 
  - Email: admin@autosalone.com
  - Password: password

## Funzionalità Dettagliate

### Ricerca e Filtri
- Ricerca testuale per marca, modello, titolo
- Filtro per marca (con caricamento dinamico dei modelli)
- Filtro per modello
- Filtro per condizione (nuovo/usato)
- Filtro per range di prezzo
- Filtro per range di anno
- Ordinamento personalizzabile
- Paginazione dei risultati

### Gestione Veicoli (Admin)
- Form completo con validazione
- Upload multiplo di immagini
- Anteprima immagini in tempo reale
- Eliminazione immagini
- Attivazione/disattivazione rapida
- Flag "In evidenza" per homepage
- Storicizzazione automatica di ogni modifica

### Dettagli Veicolo
Ogni veicolo include:
- Marca e modello
- Titolo personalizzato
- Descrizione dettagliata
- Anno di immatricolazione
- Chilometraggio
- Prezzo
- Condizione (nuovo/usato)
- Tipo di carburante (benzina, diesel, elettrico, ibrido)
- Tipo di cambio
- Tipo di carrozzeria
- Colore
- Immagini multiple
- Stato di attivazione
- Flag in evidenza

## Tecnologie Utilizzate

- **Backend**: Laravel 11
- **Frontend**: Livewire 3, Alpine.js
- **Styling**: Tailwind CSS
- **Icons**: Font Awesome 6
- **Database**: MySQL
- **File Storage**: Laravel Storage (locale)

## Transizioni SPA

L'applicazione utilizza Livewire Wire:navigate per creare un'esperienza Single Page Application con:
- Transizioni fluide tra le pagine
- Loading states
- Animazioni CSS personalizzate
- Scroll to top automatico
- Nessun reload della pagina

## Struttura dei File

```
app/
├── Livewire/
│   ├── Admin/
│   │   ├── VehicleManagement.php (Lista veicoli admin)
│   │   └── VehicleForm.php (Form crea/modifica)
│   └── Public/
│       └── VehicleList.php (Catalogo pubblico)
├── Models/
│   ├── Brand.php
│   ├── CarModel.php
│   ├── Vehicle.php
│   └── VehicleHistory.php

database/
├── migrations/
│   ├── *_create_brands_table.php
│   ├── *_create_car_models_table.php
│   ├── *_create_vehicles_table.php
│   └── *_create_vehicle_histories_table.php
└── seeders/
    ├── BrandSeeder.php
    ├── CarModelSeeder.php
    └── VehicleSeeder.php

resources/
├── views/
│   ├── layouts/
│   │   ├── admin.blade.php
│   │   └── public.blade.php
│   ├── livewire/
│   │   ├── admin/
│   │   │   ├── vehicle-management.blade.php
│   │   │   └── vehicle-form.blade.php
│   │   └── public/
│   │       └── vehicle-list.blade.php
│   ├── home.blade.php
│   └── vehicles.blade.php
```

## Personalizzazione

### Aggiungere Nuove Marche
Modifica `database/seeders/BrandSeeder.php`

### Aggiungere Nuovi Modelli
Modifica `database/seeders/CarModelSeeder.php`

### Modificare i Colori
I colori principali sono configurati in Tailwind CSS:
- Blu primario: `blue-600`
- Modificabile in `tailwind.config.js`

## Supporto e Contributi

Questa applicazione è stata creata come esempio completo di gestione autosalone con Laravel e Livewire.

## Licenza

Open source - Usa liberamente per i tuoi progetti!
