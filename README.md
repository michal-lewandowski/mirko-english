# Mirko-english
Skrypt do zabawy na wykopie: https://www.wykop.pl/tag/mirkoangielski/

# Setup
1. Należy wypełnić plik config.php danymi z https://www.wykop.pl/dla-programistow/twoje-aplikacje/ Aplikacja powinna mieć uprawnienia do logowania i do mikrobloga
2. W pliku index.php zmienna $previousPostId powinna mieć jako wartość id wpisu, którego plusujący otrzymają słówko. 
3. W pliku index.php zmienna $currentPostId powinna mieć jako wartość id wpisu, pod którym zostaną dodane komentarze ze słowami. 

# Uruchomienie skryptu
W katalogu projektu:
```sh
php index.php
```
