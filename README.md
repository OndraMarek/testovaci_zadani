## Instalace  
1. Naklonujte repozitář
    ```bash
   git clone https://github.com/OndraMarek/testovaci_zadani.git
    cd testovaci_zadani
   ``` 
2. Nainstalujte závislosti:
   ```bash
   composer install
   ```
3. Importujte databázi (soubor database.sql obsahuje skripty pro vytvoření databázových tabulek a jejich
naplnění)
5. Spusťte server:
   ```bash
   php -S localhost:8000 -t public public/index.php
   ```
