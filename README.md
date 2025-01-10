# COMANDI PROGETTO

1. **Installazione delle dipendenze**
   - `composer i`
   - `npm i`

2. **Configurazione dell'ambiente**
   - `cp .env.example .env`
   - `php artisan key:generate`
   - `settare i dati del db nel file env e cambiare in mysql il campo DB_CONNECTION nel caso di un db mysql`

3. **Setup del database**
   - `php artisan migrate`
   - `php artisan db:seed`

---

# COMANDI PER ESEGUIRE IL PROGETTO

1. **Avviare il server PHP**
   - `php artisan serve`

2. **Avviare il server di sviluppo frontend**
   - `npm run dev`

---

# COMMANDI CLI

### Aggiunta nuova Task
- **Comando**:
  ```bash
  php artisan task:insert "Task Title" "Task description" --due_date=2025-02-20

### Eliminazione Task
- **Comando**:  
  ```bash
  php artisan task:delete "id"
