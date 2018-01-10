Web Aplikacija koja pruža kontrolu moguceg broja pristupa web servisu u vremenskom intervalu.
Da bi aplikacija funkcionisala na vašem web serveru, potrebno je:
-	Napraviti bazu podataka sa imenom „limitedrequester“ na vašem serveru i dodeliti joj korisnika „root“ bez sifre. I importovati koristeci file: „limitedrequester.sql“ koji se nalazi u folderu. Ili možete importovati „limitedrequester.sql“ u neku drugu bazu, ali je onda potrebno adaptirati podatke u funkciji „connectToDatabase“ koja se nalazi u datoteci functions.php kao prva.
-	Dodati Rewrite Rules koji se nalaze u .htaccess fajlu koji se nalazi u folderu Vašem .htaccess fajlu, ili da bi izbegli neželjene kolizije, možete privremeno sacuvati Vaš .htaccess i prekopirati ovaj prosledjeni kako biste testirali aplikaciju valjano.
-	Citav Folder „backend_tests“ prekopirati u root vašeg servera.
-	Web servise možete testirati onako kako ste Vi definisali u vašem zadatku, ali ...
-	Radi lakšeg upravljanja, napravio sam i jednostavan i skroman interface za korišnjenje ove web aplikacije, koji možete videti otvarajuci http://localhost/rate_limiting i na njemu cete moci da testirate Rad web aplikacije. 
-	Aplikacija uzima zadati Ime korisnika, prosledjuje ga api-ju koji vraca pozdrav i beleži da je zahtev upucen od konkretnog korisnika(ili proksija) preko njegovog ip-a. 
-	Kako nisam bio siguran da li treba max 10 zahteva u poslednjih 60sekundi ili da svaki minut u vremenu ima svojih mogucih 10 zahteva, po slobodnoj volji sam implementirao oba slucaja. Jedan je trenutno aktivan, a drugi se nalazi pod komentarom tako da i njega možete testirati. 
-	Dodatno pitanje koje se vezuje za to kako implementirati N zahteva u M minuta je u potpunosti ukljuceno u implementaciju i sa promenom varijabli na samom pocetku odredjujete koliko zahteva dozvoljavate u kom vremenskom intervalu. Ti podaci se mogu cuvati u pomocnoj tabeli baze podataka koja ce biti vezana npr za ip ili apikey korisnika i tako ce svaki korisnik imati svoju kolicinu pristupanja u vremenskom intervalu.
-	Ukoliko imate bilo kakva pitanja, molim Vas da ih postavite, bice mi drago da odgovorim na njih.
Bojan Milic
