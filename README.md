# TecTock
Progetto di Tecnologie Web per l'anno 2023/2024 per il corso della prof.ssa Gaggi, UniPD, Informatica

**PER IL DB:**

il file DB.sql ha tutte le tabelle, eseguite quello su phpmyadmin e ve le crea.
le tabelle sono:

1. prodotto --> ha chiavi esterne alle tabelle marca, prodotto, cinturino, cassa così dato il prodotto posso visualizzare le informazioni della marca, del tipo, del cinturino, della cassa.
2. marca --> ha solo ID e nomemarca.
3. tipo --> per tipo si intende al quarzo, automatico, cinetico, digitale, smartwatch ecc (riferimento al link https://www.orologi4you.it/orologi-da-polso/categorie.htm che ho messo pure su discord)
4. utente --> informazioni dell'utente.
5. recensione --> la recensione ha chiave esterna alla tabella utente, così data la recensione posso visualizzare l'utente che l'ha scritta.
6. cassa --> info della cassa
7. cinturino --> info del cinturino

Nelle tabelle ho messo gli attributi che mi sembravano più sensati da mettere per un orologio, siete liberi di aggiungere quello che vi pare, basta che dopo avvisiate
se avete fatto modifiche siccome dobbiamo lavorare tutti sullo stesso DB.

per il collegamento con il DB, i valori delle variabili di connessione sono le seguenti:

private const HOST_DB = "127.0.0.1";

private const DATABASE_NAME = "tectock";

private const USERNAME = "root";

private const PASSWORD = "";
